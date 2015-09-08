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
	public function testSavingApplicantNullLastName()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = null;

		$applicant = new Applicant($first_name, $last_name);
		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMrNoPeriod()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$title = 'Mr';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->setTitle($title);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithTitleMrWithPeriod()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$title = 'Mr.';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->setTitle($title);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMsNoPeriod()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$title = 'Ms';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->setTitle($title);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	/**
	 * @expectedException Onfido\Exception\InvalidRequestException
	 */
	public function testCreateApplicantWithTitleMsPeriod()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$title = 'Ms.';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->setTitle($title);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMrsNoPeriod()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$title = 'Mrs';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->setTitle($title);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMrsPeriod()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$title = 'Mrs';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->setTitle($title);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

	public function testCreateApplicantWithTitleMiss()
	{
		$faker = \Faker\Factory::create();

		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = $faker->firstName;
		$last_name = $faker->lastName;
		$title = 'Miss';

		$applicant = new Applicant($first_name, $last_name);
		$applicant->setTitle($title);

		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($title, $applicant->getTitle());

		$applicant->save($token);
	}

}
