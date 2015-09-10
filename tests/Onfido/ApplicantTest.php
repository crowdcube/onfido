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

	private function getSUT()
	{
		$faker = \Faker\Factory::create();
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);
		return $applicant;
	}
}
