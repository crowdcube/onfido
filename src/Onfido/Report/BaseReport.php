<?php

namespace Favor\Onfido\Report;

abstract class BaseReport
{
	protected $id;
	protected $href;
	protected $name;
	protected $created_at;
	protected $status;
	protected $result;
	protected $properties;

	/**
	 * Base constructor for BaseReport.
	 * @param string $id         The ID of the report.
	 * @param string $href       The URL of the report.
	 * @param string $name       The name (type) of the report.
	 * @param string $created_at The timestampe of when the report was created.
	 * @param string $status     The status of the report.
	 */
	public function __construct($id, $href, $name, $created_at, $status)
	{
		$this->id = $id;
		$this->href = $href;
		$this->name = $name;
		$this->created_at = $created_at;
		$this->status = $status;
	}

	/**
	 * Gets the unique identifier for the report.
	 * @return null|string The ID of the report.
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Gets the URL to access the report, relative to the API host.
	 * @return null|string The URL of the report.
	 */
	public function getHref()
	{
		return $this->href;
	}

	/**
	 * Gets the name (type) of the report, e.g. 'identity'.
	 * @return null|string The name of the report.
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Gets the timestamp of when the report was created.
	 * @return null|string The timestamp of when the report was created.
	 */
	public function getCreatedAt()
	{
		return $this->created_at;
	}

	/**
	 * The run status of the report.
	 * @return null|string The status of the report.
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/** 
	 * Sets the result of the report.
	 * @param string $result The result of the report.
	 */
	public function setResult($result)
	{
		$this->result = $result;
	}

	/**
	 * Get the result of the report, if it is finished.
	 * @return string The result of the report.
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * Sets the properties used by the report.
	 * @param array $properties The properties used by the report.
	 */
	public function setProperties(array $properties)
	{
		$this->properties = $properties;
	}

	/**
	 * Gets any properties used for the report.
	 * @return array The properties used for the report.
	 */
	public function getProperties()
	{
		return $this->properties;
	}
}
