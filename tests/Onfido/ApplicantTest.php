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
		$token = "test_R6me4f2LQnkSHHbSh9UpckuZg4LGcOsK";
		$first_name = 'testFirst';
		$last_name = 'testLast';
		$email = 'testEmail@gmail.com';
		$dob = '2010-02-24';

		$applicant = new Applicant($first_name, $last_name, $email, $dob);
		$this->assertEquals($first_name, $applicant->getFirstName());
		$this->assertEquals($last_name, $applicant->getLastName());
		$this->assertEquals($email, $applicant->getEmail());
		$this->assertEquals($dob, $applicant->getDob());

		$applicant->save($token);
	}
}
