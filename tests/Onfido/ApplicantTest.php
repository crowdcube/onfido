<?php

namespace Onfido\Test;

use Onfido\Applicant;

class ApplicantTest extends \PHPUnit_Framework_TestCase
{

	const ONFIDO_TOKEN = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

	/**
	 * @expectedException Onfido\Exception\ApplicantNotFoundException
	 */
	public function testLoadApplicantUnknownId()
	{
		$applicant = Applicant::load(self::ONFIDO_TOKEN, 'testID');
	}

	public function testSavingApplicant()
	{
		$faker = \Faker\Factory::create();

		$first_name = $faker->firstName;
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantNullFirstName()
	{
		$faker = \Faker\Factory::create();

		$first_name = null;
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantEmptyStringFirstName()
	{
		$faker = \Faker\Factory::create();

		$first_name = '';
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantNullLastName()
	{
		$faker = \Faker\Factory::create();

		$first_name = $faker->firstName;
		$last_name = null;

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantLastNameEmptyString()
	{
		$faker = \Faker\Factory::create();

		$first_name = $faker->firstName;
		$last_name = '';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithTitleMrNoPeriod()
	{
		$applicant = $this->getSUT();
		$title = 'Mr';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithTitleMrWithPeriod()
	{
		$applicant = $this->getSUT();
		$applicant->setTitle('Mr.');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithTitleMsNoPeriod()
	{
		$applicant = $this->getSUT();
		$applicant->setTitle('Ms');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithTitleMsPeriod()
	{
		$applicant = $this->getSUT();
		$applicant->setTitle('Ms.');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithTitleMrsNoPeriod()
	{
		$applicant = $this->getSUT();
		$applicant->setTitle('Mrs');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithTitleMrsPeriod()
	{
		$applicant = $this->getSUT();
		$applicant->setTitle('Mrs');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithTitleMiss()
	{
		$applicant = $this->getSUT();
		$applicant->setTitle('Miss');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithTitleEmptyString()
	{
		$applicant = $this->getSUT();
		$applicant->setTitle('');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithMiddleName()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$middle_name = $faker->firstName;

		$applicant->setMiddleName($middle_name);
		$this->assertEquals($middle_name, $applicant->getMiddleName());

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithMiddleNameEmptyString()
	{
		$applicant = $this->getSUT();
		$applicant->setMiddleName('');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithMiddleNameWithSpace()
	{
		$applicant = $this->getSUT();
		$applicant->setMiddleName('Test Middle');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$email = $faker->email;

		$applicant->setEmail($email);
		$this->assertEquals($email, $applicant->getEmail());

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithEmailNull()
	{
		$applicant = $this->getSUT();
		$applicant->setEmail(null);

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithEmailEmptyString()
	{
		$applicant = $this->getSUT();
		$applicant->setEmail('');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithGenderM()
	{
		$applicant = $this->getSUT();
		$gender = 'M';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithGenderLittleM()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('m');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithGenderMale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('Male');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithGenderLittleMale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('male');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithGenderF()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('F');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithGenderLittleF()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('f');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithGenderFemale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('Female');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithGenderLittleFemale()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('female');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithGenderTestGener()
	{
		$applicant = $this->getSUT();
		$applicant->setGender('testGender');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * If saving an applicant in the USA, an email address is required.
	 * 
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithCountryUSA()
	{
		$applicant = $this->getSUT();
		$country = 'usa';

		$applicant->setCountry($country);
		$this->assertEquals($country, $applicant->getCountry());

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithCountryUSAEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('usa');
		$applicant->setEmail($faker->email);

		$applicant->save(self::ONFIDO_TOKEN);
	}

		public function testCreateWithCountryBigUSAEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('USA');
		$applicant->setEmail($faker->email);

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithCountryUSAPeriodsEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('U.S.A.');
		$applicant->setEmail($faker->email);

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithCountryUSEmail()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setCountry('US');
		$applicant->setEmail($faker->email);

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithCountrySmallGBR()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('gbr');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithCountryBigGBR()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('GBR');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithCountryBigGBRPeriods()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('G.B.R.');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithCountrySmallCAN()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('can');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithCountryBigCAN()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('CAN');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateWithCountryCANPeriods()
	{
		$applicant = $this->getSUT();
		$applicant->setCountry('C.A.N.');

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithBirthdayFourYearTwoMonthTwoDayDashes()
	{
		$faker = \Faker\Factory::create();
		$dob = $faker->date('Y-m-d');
		
		$applicant = $this->getSUT();
		$applicant->setDob($dob);

		$this->assertEquals($dob, $applicant->getDob());

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithBirthdayFourYearTwoMonthTwoDaySlashes()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setDob($faker->date('Y/m/d'));

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithBirthdayTwoYearTwoMonthNoLeadingZerosTwoDayDashes()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setDob($faker->date('y-9-d'));

		$applicant->save(self::ONFIDO_TOKEN);
	}

	public function testCreateWithBirthdayFourYearTwoMonthOneDayDashes()
	{
		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$applicant->setDob($faker->date('Y-m-4'));

		$applicant->save(self::ONFIDO_TOKEN);
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
