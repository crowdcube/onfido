<?php

namespace Favor\Onfido\Test\Report;

use Favor\Onfido\Report\ReportFactory;

class ReportFactoryTest extends \PHPUnit_Framework_TestCase
{
	public function testIdentityReportCreation()
	{
		$factory = new ReportFactory();
		$report = $factory->createReport(array('name' => 'identity'));
		$this->assertInstanceOf('Favor\Onfido\Report\IdentityReport', $report);
	}
}
