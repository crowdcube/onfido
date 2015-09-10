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

	public function testCreateWithGenderM()
	{
		$applicant = $this->getSUT();
		$gender = 'M';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());
	}

	public function testCreateWithGenderLittleM()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('m');
	}

	public function testCreateWithGenderMale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('Male');
	}

	public function testCreateWithGenderLittleMale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('male');
	}

	public function testCreateWithGenderF()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('F');
	}

	public function testCreateWithGenderLittleF()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('f');
	}

	public function testCreateWithGenderFemale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('Female');
	}

	public function testCreateWithGenderLittleFemale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('female');
	}

	public function testCreateWithGenderTestGener()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('testGender');
	}

	public function testCreateWithCountryUSA()
	{
		$applicant = $this->getSUT();
		$country = 'usa';

		$applicant->setCountry($country);
		$this->assertEquals($country, $applicant->getCountry());
	}

	public function testCreateWithCountryUSAEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('usa');
		$applicant->setEmail($faker->email);
	}

		public function testCreateWithCountryBigUSAEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('USA');
		$applicant->setEmail($faker->email);
	}

	public function testCreateWithCountryUSAPeriodsEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('U.S.A.');
		$applicant->setEmail($faker->email);
	}

	public function testCreateWithCountryUSEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('US');
		$applicant->setEmail($faker->email);
	}

	public function testCreateWithCountrySmallGBR()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('gbr');
	}

	public function testCreateWithCountryBigGBR()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('GBR');
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithCountryBigGBRPeriods()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('G.B.R.');
	}

	public function testCreateWithCountrySmallCAN()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('can');
	}

	public function testCreateWithCountryBigCAN()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('CAN');
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithCountryCANPeriods()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('C.A.N.');
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
