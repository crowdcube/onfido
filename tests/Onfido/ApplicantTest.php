<?php

namespace Onfido\Test;

use Onfido\Applicant;

class ApplicantTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException Onfido\Exception\ApplicantNotFoundException
	 */
	public function testLoadApplicantUnknownId()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$applicant = Applicant::load($token, 'testID');
	}

	public function testSavingApplicant()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantNullFirstName()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = null;
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantEmptyStringFirstName()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = '';
		$last_name = $faker->lastName;

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantNullLastName()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = null;

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testSavingApplicantLastNameEmptyString()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = '';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMrNoPeriod()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		
		$applicant = $this->getSUT();
		$title = 'Mr';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithTitleMrWithPeriod()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$title = 'Mr.';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMsNoPeriod()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$title = 'Ms';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithTitleMsPeriod()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$title = 'Ms.';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMrsNoPeriod()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$title = 'Mrs';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMrsPeriod()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$title = 'Mrs';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMiss()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$title = 'Miss';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithTitleEmptyString()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$title = '';

		$applicant->setTitle($title);
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithMiddleName()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$middle_name = $faker->firstName;

		$applicant->setMiddleName($middle_name);
		$this->assertEquals($middle_name, $applicant->getMiddleName());

		$applicant->save($token);
	}

	public function testCreateApplicantWithMiddleNameEmptyString()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$middle_name = '';

		$applicant->setMiddleName($middle_name);
		$this->assertEquals($middle_name, $applicant->getMiddleName());

		$applicant->save($token);
	}

	public function testCreateApplicantWithMiddleNameWithSpace()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$middle_name = '';

		$applicant->setMiddleName($middle_name);
		$this->assertEquals($middle_name, $applicant->getMiddleName());

		$applicant->save($token);
	}

	public function testCreateApplicantWithEmail()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$email = $faker->email;

		$applicant->setEmail($email);
		$this->assertEquals($email, $applicant->getEmail());

		$applicant->save($token);
	}

	public function testCreateApplicantWithEmailNull()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$applicant = $this->getSUT();
		$email = null;

		$applicant->setEmail($email);
		$this->assertEquals($email, $applicant->getEmail());

		$applicant->save($token);
	}

	public function testCreateApplicantWithEmailEmptyString()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$applicant = $this->getSUT();
		$email = '';

		$applicant->setEmail($email);
		$this->assertEquals($email, $applicant->getEmail());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithGenderM()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'M';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithGenderLittleM()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'm';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	public function testCreateApplicantWithGenderMale()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'Male';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	public function testCreateApplicantWithGenderLittleMale()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'male';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithGenderF()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'F';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithGenderLittleF()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'f';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	public function testCreateApplicantWithGenderFemale()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'Female';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	public function testCreateApplicantWithGenderLittleFemale()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'female';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithGenderTestGener()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$gender = 'testGender';

		$applicant->setGender($gender);
		$this->assertEquals($gender, $applicant->getGender());

		$applicant->save($token);
	}

	/**
	 * If saving an applicant in the USA, an email address is required.
	 * 
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithCountryUSA()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$applicant = $this->getSUT();
		$country = 'usa';

		$applicant->setCountry($country);
		$this->assertEquals($country, $applicant->getCountry());

		$applicant->save($token);
	}

	public function testCreateApplicantWithCountryUSAEmail()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$email = $faker->email;
		$country = 'usa';

		$applicant->setCountry($country);
		$applicant->setEmail($email);
		$this->assertEquals($country, $applicant->getCountry());

		$applicant->save($token);
	}

		public function testCreateApplicantWithCountryBigUSAEmail()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$email = $faker->email;
		$country = 'USA';

		$applicant->setCountry($country);
		$applicant->setEmail($email);
		$this->assertEquals($country, $applicant->getCountry());

		$applicant->save($token);
	}

	public function testCreateApplicantWithCountryUSAPeriodsEmail()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$email = $faker->email;
		$country = 'U.S.A.';

		$applicant->setCountry($country);
		$applicant->setEmail($email);
		$this->assertEquals($country, $applicant->getCountry());

		$applicant->save($token);
	}

	public function testCreateApplicantWithCountryUSEmail()
	{
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";

		$faker = \Faker\Factory::create();

		$applicant = $this->getSUT();
		$email = $faker->email;
		$country = 'US';

		$applicant->setCountry($country);
		$applicant->setEmail($email);
		$this->assertEquals($country, $applicant->getCountry());

		$applicant->save($token);
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
