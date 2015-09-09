<?php

use Onfido\Client;
use Faker\Factory;

class ClientTest extends \PHPUnit_Framework_TestCase
{
	const ONFIDO_TOKEN = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

	public function testCreateRetrieveApplicant()
	{
		$faker = Factory::create();
		$title = 'Mr';
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$middle_name = $faker->firstName;
		$email = $faker->email;
		$gender = 'Male';
		$dob = '1980-11-23';
		$telephone = '11234567890';
		$mobile = '10987654321';
		$country = 'usa';

		$params = array(
			'title' => $title,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'middle_name' => $middle_name,
			'email' => $email,
			'gender' => $gender,
			'dob' => $dob,
			'telephone' => $telephone,
			'mobile' => $mobile,
			'country' => $country
		);

		$client = new Client(self::ONFIDO_TOKEN);

		// Create the applicant on Onfido
		$applicant = $client->createApplicant($params);

		$this->assertInstanceOf('Onfido\Applicant', $applicant);
		$this->assertNotNull($applicant->getId());
		$this->assertNotNull($applicant->getHref());
		$this->assertNotNull($applicant->getCreatedAt());
		$this->assertEquals($title, $applicant->getTitle());
		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($middle_name, $applicant->getMiddleName());
		$this->assertEquals($email, $applicant->getEmail());
		$this->assertEquals($gender, $applicant->getGender());
		$this->assertEquals($dob, $applicant->getDob());
		$this->assertEquals($telephone, $applicant->getTelephone());
		$this->assertEquals($mobile, $applicant->getMobile());
		$this->assertEquals($country, $applicant->getCountry());

		// Retrieve the applicant from Onfido
		$id = $applicant->getId();
		$applicant = $client->retrieveApplicant($id);

		$this->assertInstanceOf('Onfido\Applicant', $applicant);
		$this->assertNotNull($applicant->getId());
		$this->assertNotNull($applicant->getHref());
		$this->assertNotNull($applicant->getCreatedAt());
		$this->assertEquals($title, $applicant->getTitle());
		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($middle_name, $applicant->getMiddleName());
		$this->assertEquals($email, $applicant->getEmail());
		$this->assertEquals($gender, $applicant->getGender());
		$this->assertEquals($dob, $applicant->getDob());
		$this->assertEquals($telephone, $applicant->getTelephone());
		$this->assertEquals($mobile, $applicant->getMobile());
		$this->assertEquals($country, $applicant->getCountry());
	}
}
