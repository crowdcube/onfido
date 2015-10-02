<?php

namespace Favor\Onfido\Test;

use Favor\Onfido\Client\RestClient;
use Faker\Factory;

class ClientTest extends \PHPUnit_Framework_TestCase
{
	const ONFIDO_TOKEN = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

	/**
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 * @dataProvider invalidFirstNameProvider
	 */
	public function testCreateWithInvalidFirstName($first_name)
	{
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $first_name
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function invalidFirstNameProvider()
	{
		return array(
			array(''),
			array(null)
		);
	}

	/**
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 * @dataProvider invalidLastNameProvider
	 */
	public function testCreateWithInvalidLastName($first_name, $last_name)
	{
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $first_name,
			'last_name' => $last_name
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function invalidLastNameProvider()
	{
		$faker = Factory::create();

		return array(
			array($faker->firstName, ''),
			array($faker->firstName, null)
		);
	}

	/**
	 * @dataProvider validTitleProvider
	 */
	public function testValidTitles($title)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'title' => $title
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validTitleProvider()
	{
		return array(
			array('Mr'),
			array('Ms'),
			array('Miss'),
			array('Mrs'),
			array(null)
		);
	}

	/**
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 * @dataProvider invalidTitleProvider
	 */
	public function testInvalidTitles($title)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'title' => $title
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function invalidTitleProvider()
	{
		return array(
			array('Mr.'),
			array('Ms.'),
			array('Mrs.'),
			array(''),
		);
	}

	/**
	 * @dataProvider validGenderProvider
	 */
	public function testValidGenders($gender)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'gender' => $gender
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validGenderProvider()
	{
		return array(
			array('male'),
			array('Male'),
			array('female'),
			array('Female'),
			array(null)
		);
	}

	/**
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 * @dataProvider invalidGenderProvider
	 */
	public function testInvalidGenders($gender)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'gender' => $gender
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function invalidGenderProvider()
	{
		return array(
			array('m'),
			array('M'),
			array('f'),
			array('F'),
			array(''),
		);
	}

	/**
	 * @dataProvider validCountryProvider
	 */
	public function testValidCountries($country)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email, // Include email because applicants created in the USA need it
			'country' => $country
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validCountryProvider()
	{
		return array(
			array('usa'),
			array('USA'),
			array('can'),
			array('CAN'),
			array(null)
		);
	}

	/**
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 * @dataProvider invalidCountryProvider
	 */
	public function testInvalidCountries($country)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'country' => $country
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function invalidCountryProvider()
	{
		return array(
			array('U.S.A.'),
			array('US'),
			array('CA'),
			array(''),
		);
	}

	/**
	 * @dataProvider validPhoneNumbersProvider
	 */
	public function testValidPhoneNumbers($phone_number)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'telephone' => $phone_number
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validPhoneNumbersProvider()
	{
		return array(
			array('1234567890'),
			array('123-456-7890'),
			array('(123) 456-7890'),
			array('11234567890'),
			array('+11234567890'),
			array('+1 123 456 7890'),
			array(null),
			array(''),
			array('12345')
		);
	}

	/**
	 * @dataProvider validMobileNumbersProvider
	 */
	public function testValidMobileNumbers($phone_number)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'mobile' => $phone_number
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validMobileNumbersProvider()
	{
		return array(
			array('1234567890'),
			array('123-456-7890'),
			array('(123) 456-7890'),
			array('11234567890'),
			array('+11234567890'),
			array('+1 123 456 7890'),
			array(null),
			array(''),
			array('12345')
		);
	}

	/**
	 * @dataProvider validDateOfBirthProvider
	 */
	public function testValidDatesOfBirth($dob)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'dob' => $dob
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validDateOfBirthProvider()
	{
		$faker = \Faker\Factory::create();

		return array(
			array($faker->date('Y-m-d')),
			array($faker->date('Y/m/d')),
			array($faker->date('y-9-d')),
			array($faker->date('Y-m-4')),
			array(null),
		);
	}

	/**
	 * @dataProvider invalidDateOfBirthProvider
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 */
	public function testInvalidDatesOfBirth($dob)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'dob' => $dob
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function invalidDateOfBirthProvider()
	{
		$faker = Factory::create();

		return array(
			array($faker->date('Y m d')),
			array($faker->date('Y/24/12')),
			array('')
		);
	}

	/**
	 * @dataProvider validEmailProvider
	 */
	public function testValidEmails($email)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $email
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validEmailProvider()
	{
		$faker = Factory::create();

		return array(
			array($faker->email),
			array(''),
		);
	}

	/**
	 * @dataProvider invalidEmailProvider
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 */
	public function testInvalidEmails($email)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $email
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function invalidEmailProvider()
	{
		return array(
			array('email'),
			array('email.com'),
		);
	}

	/**
	 * @dataProvider validMiddleNameProvider
	 */
	public function testValidMiddleNames($middle_name)
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'middle_name' => $middle_name
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	public function validMiddleNameProvider()
	{
		$faker = Factory::create();

		return array(
			array($faker->firstName),
			array('Test Middle'),
			array(''),
			array(null),
		);
	}

	public function testCreateApplicantWithAddress()
	{
		$faker = Factory::create();
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$params = array(
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => $faker->email,
			'addresses' => array(
				array(
					'building_number' => $faker->numberBetween(10, 10000),
					'street' => $faker->streetName,
					'town' => $faker->city,
					'postcode' => 12345,
					'country' => 'USA',
					'state' => $faker->stateAbbr,
					'start_date' => $faker->date('Y-m-d')
				)
			)
		);

		$applicant = $client->createApplicant($params);
		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
	}

	/**
	 * @expectedException \Favor\Onfido\Exception\ApplicantNotFoundException
	 */
	public function testApplicantRetrievalUnknownId()
	{
		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$applicant = $client->retrieveApplicant('testIDNoasdf');
	}

	public function testCreateRetrieveApplicant()
	{
		$faker = Factory::create();
		$title = 'Mr';
		$first_name = 'Lebron';
		$last_name = 'Jordan';
		$middle_name = $faker->firstName;
		$email = strtolower($faker->email);
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

		$client = new RestClient(self::ONFIDO_TOKEN, false);

		// Create the applicant on Onfido
		$applicant = $client->createApplicant($params);

		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
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

		$this->assertInstanceOf('Favor\Onfido\Applicant', $applicant);
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

	/**
	 * @expectedException \Favor\Onfido\Exception\InvalidRequestException
	 *
	 * Identity check requires at least one address and a date of birth
	 */
	public function testRunIdentityCheckMissingData()
	{
		$faker = Factory::create();

		$first_name = $faker->firstName;
		$last_name = $faker->lastName;

		$params = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $faker->email
		);

		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$applicant = $client->createApplicant($params);

		$client->runIdentityCheck($applicant->getId());
	}


	public function testRunIdentityCheck()
	{
		$faker = Factory::create();

		$first_name = $faker->firstName;
		$last_name = $faker->lastName;

		$params = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'dob' => $faker->date('Y-m-d'),
			'email' => $faker->email,
			'country' => 'USA',
			'addresses' => array(
				array(
					'building_number' => $faker->numberBetween(10, 10000),
					'street' => $faker->streetName,
					'town' => $faker->city,
					'postcode' => 12345,
					'country' => 'USA',
					'state' => $faker->stateAbbr,
					'start_date' => $faker->date('Y-m-d')
				)
			),
			'id_numbers' => array(
				array(
					'type' => 'ssn',
					'value' => '433-54-3937'
				)
			)
		);

		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$applicant = $client->createApplicant($params);

		$identityCheckReport = $client->runIdentityCheck($applicant->getId());
		$this->assertInstanceOf('Favor\Onfido\Report\IdentityReport', $identityCheckReport);
	}

	/**
	 * @expectedException \Favor\Onfido\Exception\DuplicateApplicantCreationException
	 */
	public function testCreateApplicantTwice()
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

		$client = new RestClient(self::ONFIDO_TOKEN, false);
		$applicant = $client->createApplicant($params);
		$applicant2 = $client->createApplicant($params);
	}
}
