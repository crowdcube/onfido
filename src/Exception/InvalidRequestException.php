<?php

namespace Favor\Onfido\Exception;

class InvalidRequestException extends \Exception
{
	protected $fieldErrors;

	public function __construct($fieldErrors, $message = null, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->fieldErrors;
	}

	public function getFieldErrors()
	{
		return $this->fieldErrors;
	}

}
