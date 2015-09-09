<?php

namespace Onfido;

class Address implements \JsonSerializable
{
    protected $flat_number;
    protected $building_name;
    protected $building_number;
    protected $street;
    protected $sub_street;
    protected $state;
    protected $town;
    protected $postcode;
    protected $country;
    protected $start_date; // 'Y-m-d' format
    protected $end_date; // 'Y-m-d' format

    public function getFlatNumber()
    {
        return $this->flat_number;
    }

    public function setFlatNumber($flat_number)
    {
        $this->flat_number = $flat_number;
    }

    public function getBuildingName()
    {
        return $this->building_name;
    }

    public function setBuildingName($building_name)
    {
        $this->building_name = $building_name;
    }

    public function getBuildingNumber()
    {
        return $this->building_number;
    }

    public function setBuildingNumber($building_number)
    {
        $this->building_number = $building_number;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getSubStreet()
    {
        return $this->sub_street;
    }

    public function setSubStreet($sub_street)
    {
        $this->sub_street = $sub_street;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getTown()
    {
        return $this->town;
    }

    public function setTown($town)
    {
        $this->town = $town;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function jsonSerialize()
    {
        return array(
            'flat_number'     => $this->flat_number,
            'building_name'   => $this->building_name,
            'building_number' => $this->building_number,
            'street'          => $this->street,
            'sub_street'      => $this->sub_street,
            'state'           => $this->state,
            'town'            => $this->town,
            'postcode'        => $this->postcode,
            'country'         => $this->country,
            'start_date'      => $this->start_date,
            'end_date'        => $this->end_date
        );
    }
}
