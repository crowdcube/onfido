<?php

namespace Favor\Onfido\Report;

class IdentityReport extends BaseReport
{
	protected $ssn_result;
	protected $dob_match_result;
	protected $mortality_result;
	protected $address_result;

	public function setAddressResult($result)
	{
		$this->address_result = $result;
	}

	public function getAddressResult()
	{
		return $this->address_result;
	}

	public function setDateOfBirthMatchResult($result)
	{
		$this->dob_match_result = $result;
	}

	public function getDateOfBirthMatchResult()
	{
		return $this->dob_match_result;
	}

	public function setMortalityResult($result)
	{
		$this->mortality_result = $result;
	}

	public function getMortalityResult()
	{
		return $this->mortality_result;
	}

	public function setSocialSecurityResult($result)
	{
		$this->ssn_result = $result;
	}

	public function getSocialSecurityResult()
	{
		return $this->ssn_result;
	}
}
