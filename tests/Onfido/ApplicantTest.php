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
}
