<?php

namespace Favor\Onfido\Test;

use Favor\Onfido\Applicant;
use Favor\Onfido\Address;
use Faker\Factory;

class ApplicantTest extends \PHPUnit_Framework_TestCase
{
	public function testIdGetterSetter()
	{
		$applicant = new Applicant();
		$id = 'test-id-1234';
		$this->assertNull($applicant->getId());
		$applicant->setId($id);
		$this->assertEquals($id, $applicant->getId());
	}

	public function testCreatedAtGetterSetter()
	{
		$timestamp = '2015-09-10T17:16:43Z';
		$applicant = new Applicant();
		$this->assertNull($applicant->getCreatedAt());
		$applicant->setCreatedAt($timestamp);
		$this->assertEquals('2015-09-10T17:16:43Z', $applicant->getCreatedAt());
	}

	public function testHrefGetterSetter()
	{
		$href = 'http://google.com';
		$applicant = new Applicant();
		$this->assertNull($applicant->getHref());
		$applicant->setHref($href);
		$this->assertEquals($href, $applicant->getHref());
	}

	/**
	 * @dataProvider validTitleProvider
	 */
	public function testValidTitles($title)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getTitle());
		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());
	}

	public function validTitleProvider()
	{
		return array(
			array('Mr'),
			array('Ms'),
			array('Mrs'),
			array('Miss'),
			array(null)
		);
	}

	/**
	 * @dataProvider invalidTitleProvider
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidTitles($title)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getTitle());
		$applicant->setTitle($title);
	}

	public function invalidTitleProvider()
	{
		return array(
			array('Mr.'),
			array('Ms.'),
			array('Mrs.'),
		);
	}

	public function testFirstNameGetterSetter()
	{
		$name = 'Tester';
		$applicant = new Applicant();
		$this->assertNull($applicant->getFirstName());
		$applicant->setFirstName($name);
		$this->assertEquals($name, $applicant->getFirstName());
	}

	public function testMiddleNameGetterSetter()
	{
		$name = 'Te';
		$applicant = new Applicant();
		$this->assertNull($applicant->getMiddleName());
		$applicant->setMiddleName($name);
		$this->assertEquals($name, $applicant->getMiddleName());
	}

	public function testLastNameGetterSetter()
	{
		$name = 'Testerston';
		$applicant = new Applicant();
		$this->assertNull($applicant->getLastName());
		$applicant->setLastName($name);
		$this->assertEquals($name, $applicant->getLastName());
	}

	public function testEmailGetterSetter()
	{
		$email = 'test@gmail.com';
		$applicant = new Applicant();
		$this->assertNull($applicant->getEmail());
		$applicant->setEmail($email);
		$this->assertEquals($email, $applicant->getEmail());
	}

	/**
	 * @dataProvider validGendersProvider
	 */
	public function testValidGenders($gender)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getGender());
		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());
	}

	public function validGendersProvider()
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
	 * @dataProvider invalidGendersProvider
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidGenders($gender)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getGender());
		$applicant->setGender($gender);
	}

	public function invalidGendersProvider()
	{
		return array(
			array('m'),
			array('M'),
			array('f'),
			array('F')
		);
	}

	public function testValidDateOfBirth()
	{
		$timestamp = '2015-09-10';
		$applicant = new Applicant();
		$this->assertNull($applicant->getDob());
		$applicant->setDob($timestamp);
		$this->assertEquals('2015-09-10', $applicant->getDob());
	}

	/**
	 * @dataProvider validPhoneNumbersProvider
	 */
	public function testValidPhoneNumbers($phone_number)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getTelephone());
		$applicant->setTelephone($phone_number);
		$this->assertEquals($phone_number, $applicant->getTelephone());
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

	public function testCountryGetterSetter()
	{
		$country = 'USA';
		$applicant = new Applicant();
		$this->assertNull($applicant->getCountry());
		$applicant->setCountry($country);
		$this->assertEquals($country, $applicant->getCountry());
	}

	/**
	 * @dataProvider validMobileNumbersProvider
	 */
	public function testValidMobileNumbers($phone_number)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getMobile());
		$applicant->setMobile($phone_number);
		$this->assertEquals($phone_number, $applicant->getMobile());
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

	public function testJsonSerialization()
	{
		$faker = Factory::create();

		$title = 'Mr';
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$middle_name = $faker->firstName;
		$email = $faker->email;
		$gender = 'Male';
		$dob = '1441923403';
		$telephone = '11234567890';
		$mobile = '10987654321';
		$country = 'usa';

		$building_number = $faker->numberBetween(10, 10000);
		$street = $faker->streetName;
		$town = $faker->city;
		$state = $faker->stateAbbr;
		$postcode = 12345;
		$address_start_date = $faker->date('Y-m-d');

		$applicant = new Applicant();
		$applicant->setTitle($title);
		$applicant->setFirstName($first_name);
		$applicant->setMiddleName($middle_name);
		$applicant->setLastName($last_name);
		$applicant->setEmail($email);
		$applicant->setGender($gender);
		$applicant->setDob($dob);
		$applicant->setTelephone($telephone);
		$applicant->setMobile($mobile);
		$applicant->setCountry($country);
		$applicant->setIdNumbers(
			array(
				array(
					'type' => 'ssn',
					'value' => '123-45-6789'
				)
			)
		);

		$address = new Address();
		$address->setBuildingNumber($building_number);
		$address->setStreet($street);
		$address->setTown($town);
		$address->setState($state);
		$address->setPostcode($postcode);
		$address->setStartDate($address_start_date);
		$applicant->addAddress($address);

		$applicant_json = json_encode($applicant);

		$expected_json = '{
			"id": null,
			"created_at": null,
			"href": null,
			"title": "Mr",
			"first_name": "' . $first_name . '",
			"middle_name": "' . $middle_name .'",
			"last_name": "' . $last_name . '",
			"gender": "Male",
			"dob": "1441923403",
			"telephone": "11234567890",
			"mobile": "10987654321",
			"country": "usa",
			"id_numbers":[
				{
					"type": "ssn",
					"value": "123-45-6789"
				}
			],
			"addresses":[
				{
					"flat_number": null,
					"building_name": null,
					"building_number": ' . $building_number . ',
					"street": "' . $street . '",
					"sub_street": null,
					"state": "' . $state . '",
					"town": "' . $town . '",
					"postcode": 12345,
					"country": null,
					"start_date": "' . $address_start_date . '",
					"end_date": null
				}
			]
		}';
		$this->assertJsonStringEqualsJsonString($expected_json, $applicant_json);
	}

	public function testToArray()
	{
		$applicant = new Applicant();
		$applicant->setTitle('Mr');
		$applicant->setFirstName('Tester');
		$applicant->setMiddleName('Miles');
		$applicant->setLastName('Testerston');
		$applicant->setEmail('test@testmail.com');
		$applicant->setGender('male');
		$applicant->setDob('1987/11/11');
		$applicant->setTelephone('1234567890');
		$applicant->setCountry('usa');
		$applicant->setIdNumbers(
			array(
				array(
					'type' => 'ssn',
					'value' => '123-45-6789'
				)
			)
		);

		$address = new Address();
		$address->setBuildingNumber('20');
		$address->setStreet('Lavaca');
		$address->setTown('San Diego');
		$address->setState('CA');
		$address->setPostcode('78702');
		$address->setStartDate('1990/12/25');
		$applicant->addAddress($address);

		$expected = array(
            'id' => null,
            'created_at' => null,
            'href' => null,
			'title' => 'Mr',
			'first_name' => 'Tester',
			'middle_name' => 'Miles',
			'last_name' => 'Testerston',
			'email' => 'test@testmail.com',
			'gender' => 'male',
			'dob' => '1987/11/11',
			'telephone' => '1234567890',
			'mobile' => null,
			'country' => 'usa',
			'id_numbers' => array(
				array(
					'type' => 'ssn',
					'value' => '123-45-6789'
				)
			),
			'addresses' => array(
				array(
                    'flat_number' => null,
                    'building_name' => null,
					'building_number' => '20',
					'street' => 'Lavaca',
                    'sub_street' => null,
					'state' => 'CA',
					'town' => 'San Diego',
					'postcode' => '78702',
                    'country' => null,
					'start_date' => '1990/12/25',
					'end_date' => null
				)
			)
		);

		$actual = $applicant->toArray();
		$this->assertEquals($expected, $actual);
	}
}
