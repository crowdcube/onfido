<?php

namespace Onfido\Test;

use Onfido\Applicant;

class ApplicantTest extends \PHPUnit_Framework_TestCase
{
	public function testSavingApplicant()
	{
		$faker = \Faker\Factory::create();

		$first_name = $faker->firstName;
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
	}

	public function testCreateWithMiddleName()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$middle_name = $faker->firstName;

		$applicant->setMiddleName($middle_name);
		$this->assertEquals($middle_name, $applicant->getMiddleName());
	}

	public function testCreateWithMiddleNameEmptyString()
	{
		$applicant = $this->getSUT();
		$applicant->setMiddleName('');
	}

	public function testCreateWithMiddleNameWithSpace()
	{
		$applicant = $this->getSUT();
		$applicant->setMiddleName('Test Middle');
	}

	public function testCreateWithEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$email = $faker->email;

		$applicant->setEmail($email);
		$this->assertEquals($email, $applicant->getEmail());
	}

	public function testCreateWithEmailNull()
	{
		$applicant = $this->getSUT();
		$applicant->setEmail(null);
	}

	public function testCreateWithEmailEmptyString()
	{
		$applicant = $this->getSUT();
		$applicant->setEmail('');
	}
	
	public function testCreateWithBirthdayFourYearTwoMonthTwoDayDashes()
	{
		$faker = \Faker\Factory::create();
		$dob = $faker->date('Y-m-d');
		
		$applicant = $this->getSUT();
		$applicant->setDob($dob);

		$this->assertEquals($dob, $applicant->getDob());
	}

	public function testCreateWithBirthdayFourYearTwoMonthTwoDaySlashes()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setDob($faker->date('Y/m/d'));
	}

	public function testCreateWithBirthdayTwoYearTwoMonthNoLeadingZerosTwoDayDashes()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setDob($faker->date('y-9-d'));
	}

	public function testCreateWithBirthdayFourYearTwoMonthOneDayDashes()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setDob($faker->date('Y-m-4'));
	}

	public function testCreateWithPhoneNoSpaces()
	{
		$applicant = $this->getSUT();
		$applicant->setTelephone('1234567890');
		$this->assertEquals('1234567890', $applicant->getTelephone());	}

	public function testCreateWithPhoneDashes()
	{
		$applicant = $this->getSUT();
		$applicant->setTelephone('123-456-7890');
	}

	public function testCreateWithAreaCodeParens()
	{
		$applicant = $this->getSUT();
		$applicant->setTelephone('(123) 456-7890');
	}

	public function testCreateWithPhoneCountryCode()
	{
		$applicant = $this->getSUT();
		$applicant->setTelephone('11234567890');
	}

	public function testCreateWithPhoneCountryCodePlusSign()
	{
		$applicant = $this->getSUT();
		$applicant->setTelephone('+11234567890');
	}

	public function testCreateWithPhoneCountryCodePlusSignSpaces()
	{
		$applicant = $this->getSUT();
		$applicant->setTelephone('+1 123 456 7890');
	}

	public function testCreateWithMobileNoSpaces()
	{
		$applicant = $this->getSUT();
		$applicant->setMobile('1234567890');
		$this->assertEquals('1234567890', $applicant->getMobile());	}

	public function testCreateWithMobileDashes()
	{
		$applicant = $this->getSUT();
		$applicant->setMobile('123-456-7890');
	}

	public function testCreateWithMobileAreaCodeParens()
	{
		$applicant = $this->getSUT();
		$applicant->setMobile('(123) 456-7890');
	}

	public function testCreateWithMobileCountryCode()
	{
		$applicant = $this->getSUT();
		$applicant->setMobile('11234567890');
	}

	public function testCreateWithMobileCountryCodePlusSign()
	{
		$applicant = $this->getSUT();
		$applicant->setMobile('+11234567890');
	}

	public function testCreateWithMobileCountryCodePlusSignSpaces()
	{
		$applicant = $this->getSUT();
		$applicant->setMobile('+1 123 456 7890');
	}


	private function getSUT()
	{
		$faker = \Faker\Factory::create();
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);
		return $applicant;
	}
}
