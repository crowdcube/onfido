<?php

namespace Onfido\Test\Report;

use Onfido\Report\ReportFactory;

class ReportFactoryTest extends \PHPUnit_Framework_TestCase
{
	public function testIdentityReportCreation()
	{
		$factory = new ReportFactory();
		$report = $factory->createReport(array('name' => 'identity'));
		$this->assertInstanceOf('Onfido\Report\IdentityReport', $report);
	}
}
