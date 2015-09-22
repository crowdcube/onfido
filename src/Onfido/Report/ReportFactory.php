<?php

namespace Onfido\Report;

use Onfido\Report\IdentityReport;

/**
 * A factory to create reports from the JSON returned from the Onfido API.
 */
class ReportFactory
{
	/**
	 * Creates a Onfido\Report\BaseReport instance using the supplied data.
	 * 
	 * @throws \InvalidArgumentException if the key 'name' does not exits in $data or is
	 * not a supported report type.
	 * 
	 * @param array $data An array containing the data to populate the report.
	 * @return \Onfido\Report\BaseReport
	 */
	public function createReport(array $data)
	{
		if (array_key_exists('name', $data) === false)
		{
			throw new \InvalidArgumentException('Could not create report of unknown type.');
		}

		$report = null;

		$id         = array_key_exists('id', $data)         ? $data['id']         : null;
		$href       = array_key_exists('href', $data)       ? $data['href']       : null;
		$name       = array_key_exists('name', $data)       ? $data['name']       : null;
		$created_at = array_key_exists('created_at', $data) ? $data['created_at'] : null;
		$status     = array_key_exists('status', $data)     ? $data['status']     : null;
		$result      = array_key_exists('result', $data)     ? $data['result']     : null;

		switch ($data['name']) {
			case 'identity':
				$report = $this->createIdentityReport($id, $href, $name, $created_at, $status, $data);
				break;
			default:
				throw new \InvalidArgumentException('Could not create report of unknown type.');
				break;
		}

		if (!is_null($result))
		{
			$report->setResult($result);
		}

		if (array_key_exists('properties', $data))
		{
			$report->setProperties($data['properties']);
		}

		return $report;
	}

	private function createIdentityReport($id, $href, $name, $created_at, $status, $data)
	{
		$report = new IdentityReport($id, $href, $name, $created_at, $status);

		if (array_key_exists('breakdown', $data))
		{
			$report->setSocialSecurityResult($data['breakdown']['ssn']['result']);
			$report->setMortalityResult($data['breakdown']['mortality']['result']);
			$report->setDateOfBirthMatchResult($data['breakdown']['date_of_birth']['result']);

			if (array_key_exists('address', $data['breakdown']))
			{
				$report->setAddressResult($data['breakdown']['address']['result']);
			}
		}

		return $report;
	}
}
