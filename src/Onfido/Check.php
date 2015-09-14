<?php

namespace Onfido;

class Check
{
	protected $id;
	protected $created_at;
	protected $href;
	protected $type;
	protected $status;
	protected $result;
	protected $reports = [];

	public function __construct($id, $created_at, $href, $type, $status, $result)
	{
		$this->id = $id;
		$this->created_at = $created_at;
		$this->href = $href;
		$this->type = $type;
		$this->status = $status;
		$this->result = $result;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getHref()
	{
		return $this->href;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getResult()
	{
		return $this->result;
	}

	public function getReports()
	{
		return $this->reports;
	}

	public function addReport(Report $report)
	{
		
	}

}
