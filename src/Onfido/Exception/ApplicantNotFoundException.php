<?php

namespace Onfido\Exception;

class ApplicantNotFoundException extends \Exception
{
	protected $user_id;

	public function __construct($user_id, $message = null, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->user_id = $user_id;
	}

	public function getUserId()
	{
		return $this->user_id;
	}
}
