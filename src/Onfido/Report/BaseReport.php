<?php

namespace Onfido\Report;

abstract class BaseReport
{
	protected $id;
	protected $href;
	protected $name;
	protected $created_at;
	protected $status;
	protected $result;
	protected $properties;

	public function __construct($id, $href, $name, $created_at, $status)
	{
		$this->id = $id;
		$this->href = $href;
		$this->name = $name;
		$this->created_at = $created_at;
		$this->status = $status;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getHref()
	{
		return $this->href;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setResult($result)
	{
		$this->result = $result;
	}

	public function getResult()
	{
		return $this->result;
	}


}
