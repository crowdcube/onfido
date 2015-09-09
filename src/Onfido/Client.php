<?php

namespace Onfido;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\ClientException;

use Onfido\Applicant;
use Onfido\Exception\ApplicantNotFoundException;
use Onfido\Exception\ModelRetrievalException;
use Onfido\Exception\InvalidRequestException;

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

	public function createApplicant($params)
	{
		try
		{
			$response = $this->client->request('POST', "/v1/applicants", [
				'headers' => [
					'Authorization' => "Token token=$this->authToken"
				],
				'form_params' => [
					'title' => $params['title'],
					'first_name' => $params['first_name'],
					'last_name' => $params['last_name'],
					'middle_name' => $params['middle_name'],
					'email' => $params['email'],
					'gender' => $params['gender'],
					'dob' => $params['dob'],
					'telephone' => $params['telephone'],
					'mobile' => $params['mobile'],
					'country' => $params['country'],
					// 'id_numbers' => $params['id_numbers'],
				]
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
					$fields = [];

					foreach ($error['fields'] as $field => $errors_array)
					{
						$val_errors = $errors_array[0];

						if (is_array($val_errors))
						{
							for ($i=0; $i < count($val_errors); $i++)
							{
								$fields[] = $field . ' ' . $val_errors[$i];
							}
						}
						else
						{
							$fields[] = $field . ' ' . $val_errors;
						}
					}

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

	private function populateApplicantWithResponse(Applicant $applicant, $params)
	{
		$applicant->setId($params['id']);
		$applicant->setHref($params['href']);

		$created_at_time = date_create_from_format('Y-m-d\TH:i:s\Z', $params['created_at']);
		$created_at_timestamp = $created_at_time->getTimestamp();
		$applicant->setCreatedAt($created_at_timestamp);

		$applicant->setFirstName($params['first_name']);
		$applicant->setLastName($params['last_name']);

		$dob_date_time = date_create_from_format('Y-m-d', $params['dob']);
		$dob_timestamp = $dob_date_time->getTimestamp();
		$applicant->setDob($dob_timestamp);

		$applicant->setEmail($params['email']);
		$applicant->setTitle($params['title']);
		$applicant->setMiddleName($params['middle_name']);
		$applicant->setGender($params['gender']);
		$applicant->setTelephone($params['telephone']);
		$applicant->setMobile($params['mobile']);
		$applicant->setCountry($params['country']);
	}

}
