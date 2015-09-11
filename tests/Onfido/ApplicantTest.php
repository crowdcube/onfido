<?php

namespace Onfido\Test;

use Onfido\Applicant;

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

	/**
	 * @expectedException \InvalidArgumentException
	 * @dataProvider invalidCreationDateProvider
	 */
	public function testInvalidCreatedAtDates($date)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getCreatedAt());
		$applicant->setCreatedAt($date);
	}

	public function invalidCreationDateProvider()
	{
		return array(
			array('2015/09/10'),
			array('2015-09-10'),
			array(null),
			array('')
		);
	}

	public function testCreatedAtGetterSetter()
	{
		$timestamp = 1441923403;
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
			array('Miss')
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
			array('Female')
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

	/**
	 * @dataProvider invalidDatesOfBirthProvider
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidDatesOfBirth($dob)
	{
		$applicant = new Applicant();
		$this->assertNull($applicant->getDob());
		$applicant->setDob($dob);
	}

	public function invalidDatesOfBirthProvider()
	{
		return array(
			array('2015/09/10'),
			array('2015-09-10'),
			array(null),
			array('')
		);
	}

	public function testValidDateOfBirth()
	{
		$timestamp = 1441923403;
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
}
