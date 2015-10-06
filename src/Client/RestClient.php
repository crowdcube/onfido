<?php

namespace Favor\Onfido\Client;

use Favor\Onfido\Address;
use Favor\Onfido\Applicant;
use Favor\Onfido\Checks\Check;
use Favor\Onfido\Report\IdentityReportAbstract;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\ClientException;
use InvalidArgumentException;
use Favor\Onfido\Report\ReportFactory;
use Favor\Onfido\Exception\ApplicantNotFoundException;
use Favor\Onfido\Exception\ModelRetrievalException;
use Favor\Onfido\Exception\InvalidRequestException;
use Favor\Onfido\Exception\DuplicateApplicantCreationException;

class RestClient
{
	protected $authToken;
	protected $client;

	public function __construct($authToken, $verify_certs = true)
	{
		$this->authToken = $authToken;

		$this->client = new GuzzleClient([
			'base_uri' => 'https://api.onfido.com',
			'verify' => $verify_certs
		]);
	}

	/**
	 * Creates an applicant record in Onfido.
	 *
	 * @param $params
	 *
	 * @return \Favor\Onfido\Applicant
	 *
	 * @throws \Favor\Onfido\Exception\DuplicateApplicantCreationException when an applicant with the same data exists.
	 * @throws \Favor\Onfido\Exception\InvalidRequestException when the create request could not be processed
	 */
	public function createApplicant($params)
	{
		$payload = [];

		if (array_key_exists('title', $params)) $payload['title'] = $params['title'];
		if (array_key_exists('first_name', $params)) $payload['first_name'] = $params['first_name'];
		if (array_key_exists('last_name', $params)) $payload['last_name'] = $params['last_name'];
		if (array_key_exists('middle_name', $params)) $payload['middle_name'] = $params['middle_name'];
		if (array_key_exists('email', $params)) $payload['email'] = $params['email'];
		if (array_key_exists('gender', $params)) $payload['gender'] = $params['gender'];
		if (array_key_exists('dob', $params)) $payload['dob'] = $params['dob'];
		if (array_key_exists('telephone', $params)) $payload['telephone'] = $params['telephone'];
		if (array_key_exists('mobile', $params)) $payload['mobile'] = $params['mobile'];
		if (array_key_exists('country', $params)) $payload['country'] = $params['country'];
		if (array_key_exists('addresses', $params)) $payload['addresses'] = $params['addresses'];
		if (array_key_exists('id_numbers', $params)) $payload['id_numbers'] = $params['id_numbers'];

		$query_string = $this->cleanQuery(http_build_query($payload));

		try
		{
			$response = $this->client->request('POST', "/v1/applicants", [
				'headers' => [
					'Authorization' => "Token token=$this->authToken"
				],
				'query' => $query_string
			]);
		}
		catch (ClientException $e)
		{
			$body_json = json_decode((string) $e->getResponse()->getBody(), true);

			if (array_key_exists('error', $body_json))
			{
				$error = $body_json['error'];

				if ($error['type'] == 'validation_error')
				{
					$fields = $this->formatFieldErrors($error['fields']);

					if ($fields[0] == 'applicant You have already entered this applicant into your Onfido system')
					{
						throw new DuplicateApplicantCreationException('This applicant has already been saved to the Onfido system.', $e->getCode(), $e);
					}
					else
					{
						throw new InvalidRequestException($fields, 'Could not save applicant. ' . implode($fields, ' '), $e->getCode(), $e);
					}
				}
				else
				{
					// Rethrow exception
					throw $e;
				}
			}
			else
			{
				// Rethrow exception
				throw $e;
			}
		}

		$body = $response->getBody();
		$string_body = (string) $body;
		$applicant_json = json_decode($string_body, true);

		$applicant = new Applicant();
		$this->populateApplicantWithResponse($applicant, $applicant_json);

		return $applicant;
	}

	/**
	 * Creates a new Onfido\Applicant and loads it with data retrieved from the remote
	 * data source.
	 *
	 * @throws \Favor\Onfido\Exception\ApplicantNotFoundException when the applicant with the ID cannot be found
	 * @throws \Favor\Onfido\Exception\ModelRetrievalException when there was an error retrieving the applicant's data
	 *
	 * @param string $applicant_id The ID of the applicant.
	 *
	 * @return \Favor\Onfido\Applicant The loaded applicant.
	 */
	public function retrieveApplicant($applicant_id)
	{
		try
		{
			$response = $this->client->request('GET', "/v1/applicants/$applicant_id", [
				'headers' => [
					'Authorization' => "Token token=$this->authToken"
				]
			]);
		}
		catch (ClientException $e)
		{
			throw new ApplicantNotFoundException($applicant_id, 'Could not find user with ID: ' . $applicant_id, $e->getCode(), $e);
		}
		catch (TransferException $e)
		{
			throw new ModelRetrievalException('An error occured while retrieving the remote resource.', $e->getCode(), $e);
		}

		$body = $response->getBody();
		$string_body = (string) $body;
		$applicant_json = json_decode($string_body, true);

		$applicant = new Applicant();
		$this->populateApplicantWithResponse($applicant, $applicant_json);

		return $applicant;
	}

	/**
	 * Runs an identity check for the supplied applicant.
	 *
	 * @throws \InvalidArgumentException if the applicant_id is null
	 * @throws \Favor\Onfido\Exception\InvalidRequestException if the supplied data for the identity check is not valid
	 *
	 * @param string $applicant_id The id of the applicant to run through an identity check
	 *
	 * @return \Favor\Onfido\Report\IdentityReportAbstract The identity report result
	 */
	public function runIdentityCheck($applicant_id)
	{
		if (is_null($applicant_id))
		{
			throw new InvalidArgumentException('Applicant\'s ID cannot be null.');
		}

		$post_fields = array(
			'type' => 'express',
			'reports' => array(
				array('name' => 'identity')
			)
		);

		$query_string = $this->cleanQuery(http_build_query($post_fields));

		try
		{
			$response = $this->client->request('POST', "/v1/applicants/$applicant_id/checks", [
				'headers' => [
					'Authorization' => "Token token=$this->authToken"
				],
				'query' => $query_string
			]);
		}
		catch (ClientException $e)
		{
			$body_json = json_decode((string) $e->getResponse()->getBody(), true);

			if (array_key_exists('error', $body_json))
			{
				$error = $body_json['error'];

				if ($error['type'] == 'validation_error')
				{
					$fields = $this->formatFieldErrors($error['fields']);
					throw new InvalidRequestException($fields, 'Could not run identity check. ' . implode($fields, ' '), $e->getCode(), $e);
				}
				else
				{
					// Rethrow exception
					throw $e;
				}
			}
			else
			{
				// Rethrow exception
				throw $e;
			}
		}

		$body_json = json_decode((string) $response->getBody(), true);
		$report_info = $body_json['reports'][0];

		$identity_report = new IdentityReportAbstract(
			$report_info['id'],
			$report_info['href'],
			$report_info['name'],
			$report_info['created_at'],
			$report_info['status']
		);

		$identity_report->setResult($report_info['result']);

		if (array_key_exists('properties', $report_info))
		{
			$identity_report->setProperties($report_info['properties']);
		}

		if (array_key_exists('breakdown', $report_info))
		{
			$identity_report->setSocialSecurityResult($report_info['breakdown']['ssn']['result']);
			$identity_report->setMortalityResult($report_info['breakdown']['mortality']['result']);
			$identity_report->setDateOfBirthMatchResult($report_info['breakdown']['date_of_birth']['result']);

			if (array_key_exists('address', $report_info['breakdown']))
			{
				$identity_report->setAddressResult($data['breakdown']['address']['result']);
			}
		}

		return $identity_report;
	}

    public function retrieveCheck($applicant_id, $check_id, $load_reports = true)
    {
        $url = "/v1/applicants/$applicant_id/checks/$check_id";

        if ($load_reports === true)
        {
            $url .= "?expand=reports";
        }

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => "Token token=$this->authToken"
            ]
        ]);

        $body = (string) ($response->getBody());
        $check_json = json_decode($body, true);

        if ($load_reports === true)
        {
            $reports = [];
            $report_factory = new ReportFactory();

            foreach ($check_json['reports'] as $report_data)
            {
                $report_id = $report_data['id'];
                $report = $report_factory->createReport($report_data);
                $reports[$report_id] = $report;
            }
        }

        $check = new Check($check_json['id'],
                           $check_json['created_at'],
                           $check_json['href'],
                           $check_json['type'],
                           $check_json['status'],
                           $check_json['result'],
                           $reports);

        return $check;
    }

	public function retrieveReport($check_id, $report_id)
    {
        $response = $this->client->request('GET', "/v1/checks/$check_id/checks/$report_id", [
            'headers' => [
                'Authorization' => "Token token=$this->authToken"
            ]
        ]);

        $body = (string) ($response->getBody());
        $report_json = json_decode($body, true);
        $report_factory = new ReportFactory();
        $report = $report_factory->createReport($report_json);
        return $report;
    }

	private function formatFieldErrors($field_errors)
	{
		$errors = [];
		$this->formatFieldErrorsHelper($errors, $field_errors);
		return $errors;
	}

	private function formatFieldErrorsHelper(&$errors, $field_errors)
	{
		foreach ($field_errors as $field => $error)
		{
			if (is_array($error))
			{
				$this->formatFieldErrorsHelper($errors, $error);
			}
			else
			{
				$errors[] = $field . ' ' . $error;
			}
		}
	}

	private function populateApplicantWithResponse(Applicant $applicant, $params)
	{
		$applicant->setId($params['id']);
		$applicant->setHref($params['href']);

		$applicant->setCreatedAt($params['created_at']);
		$applicant->setFirstName($params['first_name']); $applicant->setLastName($params['last_name']);
		$applicant->setDob($params['dob']);
		$applicant->setEmail($params['email']);
		$applicant->setTitle($params['title']);
		$applicant->setMiddleName($params['middle_name']);
		$applicant->setGender($params['gender']);
		$applicant->setTelephone($params['telephone']);
        $applicant->setMobile($params['mobile']);
        $applicant->setCountry($params['country']);

		if (empty($params['addresses']) === false)
		{
			foreach ($params['addresses'] as $addressInfo)
			{
				$address = new Address();

				$address->setFlatNumber($addressInfo['flat_number']);
				$address->setBuildingNumber($addressInfo['building_number']);
				$address->setStreet($addressInfo['street']);
				$address->setSubStreet($addressInfo['sub_street']);
				$address->setTown($addressInfo['town']);
				$address->setState($addressInfo['state']);
				$address->setPostcode($addressInfo['postcode']);
				$address->setCountry($addressInfo['country']);
				$address->setStartDate($addressInfo['start_date']);
				$address->setEndDate($addressInfo['end_date']);

				$applicant->addAddress($address);
			}
		}
	}

	/**
	 * Reformats a percentage-encoded query string to remove integers in square brackets.
	 *
	 * For nested params int he queries, Guzzle would encode arrays with indicies which
	 * malformed the query. This strips out those numbers so it's just the square brackets.
	 *
	 * @param  string $query_string The query to clean
	 * @return string               The sanitized query
	 */
	private function cleanQuery($query_string)
	{
		$query_string = preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $query_string);
		return $query_string;
	}

}
