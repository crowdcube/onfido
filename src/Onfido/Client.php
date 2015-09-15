<?php

namespace Onfido;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\ClientException;

use Onfido\Report\ReportFactory;
use Onfido\Exception\ApplicantNotFoundException;
use Onfido\Exception\ModelRetrievalException;
use Onfido\Exception\InvalidRequestException;
use Onfido\Exception\DuplicateApplicantCreationException;

class Client
{
	protected $authToken;
	protected $client;

	public function __construct($authToken)
	{
		$this->authToken = $authToken;

		$this->client = new GuzzleClient([
			'base_uri' => 'https://api.onfido.com'
		]);
	}

	/**
	 * @throws Onfido\Exception\InvalidRequestException
	 * @throws GuzzleHttp\Exception\ClientException
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
	 * @throws Onfido\Exception\ApplicantNotFoundException when the applicant with the ID cannot be found
	 * @throws Onfido\Exception\ModelRetrievalException when there was an error retrieving the applicant's data
	 *
	 * @param string $id The ID of the applicant.
	 *
	 * @return Onfido\Applicant The loaded applicant.
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
			throw new ModelRetrievalException('An error occured while retrieving the remote resource.', $e->getCode, $e);
		}

		$body = $response->getBody();
		$string_body = (string) $body;
		$applicant_json = json_decode($string_body, true);

		$applicant = new Applicant();
		$this->populateApplicantWithResponse($applicant, $applicant_json);

		return $applicant;
	}

	public function runIdentityCheck(Applicant $applicant)
	{
		if (is_null($applicant->getId()))
		{
			throw new \InvalidArgumentException('Applicant\'s ID cannot be null.');
		}

		$applicant_id = $applicant->getId();

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
					throw new InvalidRequestException($fields, 'Could not save applicant. ' . implode($fields, ' '), $e->getCode(), $e);
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
		$factory = new ReportFactory();
		$identity_report = $factor->createReport($body_json);
		return $identity_report;
	}

	private function formatFieldErrors($field_errors)
	{
		$fields = [];

		foreach ($field_errors as $field => $errors_array)
		{
			$val_errors = $errors_array[0];

			if (is_array($val_errors))
			{
				foreach ($val_errors as $field => $error)
				{
					if (is_array($error))
					{
						for ($i=0; $i < count($error); $i++)
						{
							$fields[] = $field . ' ' . $error[$i];
						}
					}
					else
					{
						$fields[] = $field . ' ' . $error;
					}
				}
			}
			else
			{
				$fields[] = $field . ' ' . $val_errors;
			}
		}

		return $fields;
	}

	private function populateApplicantWithResponse(Applicant $applicant, $params)
	{
		$applicant->setId($params['id']);
		$applicant->setHref($params['href']);

		if (empty($params['created_at']) === false)
		{
			$created_at_time = date_create_from_format('Y-m-d\TH:i:s\Z', $params['created_at']);
			$created_at_timestamp = $created_at_time->getTimestamp();
			$applicant->setCreatedAt($created_at_timestamp);
		}

		if (empty($params['first_name']) === false)  $applicant->setFirstName($params['first_name']);
		if (empty($params['last_name']) === false)   $applicant->setLastName($params['last_name']);

		if (empty($params['dob']) === false)
		{
			$dob_date_time = date_create_from_format('Y-m-d', $params['dob']);
			$dob_timestamp = $dob_date_time->getTimestamp();
			$applicant->setDob($dob_timestamp);
		}

		if (empty($params['email']) === false)       $applicant->setEmail($params['email']);
		if (empty($params['title']) === false)       $applicant->setTitle($params['title']);
		if (empty($params['middle_name']) === false) $applicant->setMiddleName($params['middle_name']);
		if (empty($params['gender']) === false)      $applicant->setGender($params['gender']);
		if (empty($params['telephone']) === false)   $applicant->setTelephone($params['telephone']);
		if (empty($params['mobile']) === false)      $applicant->setMobile($params['mobile']);
		if (empty($params['country']) === false)     $applicant->setCountry($params['country']);


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
