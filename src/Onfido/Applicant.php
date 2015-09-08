<?php

namespace Onfido;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\ClientException;
use Onfido\Exception\ApplicantNotFoundException;
use Onfido\Exception\ModelRetrievalException;
use Onfido\Exception\InvalidRequestException;

class Applicant
{
	protected $id;
	protected $created_at;
	protected $href;
	protected $title;
	protected $first_name;
	protected $middle_name;
	protected $last_name;
	protected $email;
	protected $gender;
	protected $dob; // 'Y-m-d' format
	protected $telephone;
	protected $mobile;
	protected $country;
	protected $id_numbers = [];
	protected $addresses = [];

	public function __construct($first_name, $last_name, $email, $dob)
	{
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->dob = $dob;
	}

	/**
	 * Creates a new Onfido\Applicant and loads it with data retrieved from the remote
	 * data source.
	 * 
	 * @param string $authToken The token to use for REST authentication.
	 * @param string $id The ID of the applicant.
	 * 
	 * @throws Onfido\Exception\ApplicantNotFoundException if an applicant with the specified ID is not found
	 * @throws Onfido\Exception\ModelRetrievalExcpetion if an error occured loading the date for the applicant.
	 * 
	 * @return Onfido\Applicant The loaded applicant.
	 */
	public static function load($authToken, $id)
	{
		$client = new Client([
			'base_uri' => 'https://api.onfido.com'
		]);
		
		try
		{
			$response = $client->request('GET', "/v1/applicants/$id", [
				'headers' => [
					'Authorization' => "Token token=$authToken"
				]
			]);
		}
		catch (ClientException $e)
		{
			throw new ApplicantNotFoundException($id, 'Could not find user with ID: ' . $id, $e->getCode(), $e);
		}
		catch (TransferException $e)
		{
			throw new ModelRetrievalException('An error occured while retrieving the remote resource.', $e->getCode, $e);
		}

		$body = $response->getBody();
		$string_body = (string) $body;
		$applicant_json = json_decode($string_body, true);
		$applicant = new self($applicant_json['first_name'], $applicant_json['last_name'], $applicant_json['email'], $applicant_json['dob']);

		$applicant->id = $applicant_json['id'];
		$applicant->href = $applicant_json['href'];
		$applicant->created_at = $applicant_json['created_at'];

		$applicant->setTitle($applicant_json['title']);
		$applicant->setMiddleName($applicant_json['middle_name']);
		$applicant->setGender($applicant_json['gender']);
		$applicant->setTelephone($applicant_json['telephone']);
		$applicant->setMobile($applicant_json['mobile']);
		$applicant->setCountry($applicant_json['country']);

		return $applicant;
	}

	public function save($authToken)
	{
		$client = new Client([
			'base_uri' => 'https://api.onfido.com'
		]);
		
		try
		{
			$response = $client->request('POST', "/v1/applicants", [
				'headers' => [
					'Authorization' => "Token token=$authToken"
				],
				'form_params' => [
					'title' => $this->title,
					'first_name' => $this->first_name,
					'last_name' => $this->last_name,
					'middle_name' => $this->middle_name,
					'email' => $this->email,
					'gender' => $this->gender,
					'dob' => $this->dob,
					'telephone' => $this->telephone,
					'mobile' => $this->mobile,
					'country' => $this->country,
					'id_numbers' => $this->id_numbers,
					'addresses' => $this->addresses
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

						for ($i=0; $i < count($val_errors); $i++)
						{ 
							$fields[] = $field . ' ' . $val_errors[$i];
						}
					}
					print_r($fields);
					throw new InvalidRequestException($fields, 'Could not save applicant. Invalid fields.', $e->getCode(), $e);
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
	}

	public function getId()
	{
		return $this->id;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getHref()
	{
		return $this->href;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function setMiddleName($middle_name)
	{
		$this->middle_name = $middle_name;
	}

	public function getMiddleName()
	{
		return $this->middle_name;
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getGender()
	{
		return $this->gender;
	}

	public function setGender($gener)
	{
		$this->gener = $gender;
	}

	public function getDob()
	{
		return $this->dob;
	}

	public function getTelephone()
	{
		return $this->telephone;
	}

	public function setTelephone($telephone)
	{
		$this->telephone = $telephone;
	}

	public function getMobile()
	{
		return $this->mobile;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function getCountry()
	{
		return $this->country;
	}

	public function setCountry($country)
	{
		$this->country = $country;
	}

	public function getIdNumbers()
	{
		return $this->id_numbers;
	}

	public function setIdNumbers($id_numbers)
	{
		$this->id_numbers = $id_numbers;
	}

	public function getAddresses()
	{
		return $this->addresses;
	}

	public function setAddresses($addresses)
	{
		$this->addresses = $addresses;
	}
}