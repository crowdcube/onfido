<?php

namespace Onfido\Test;

use Onfido\Address;
use Faker\Factory;

class AddressTest extends \PHPUnit_Framework_TestCase
{

	public function testFlatNumberGetterSetter()
	{
		$faker = Factory::create();
		$flat_number = $faker->numberBetween(0, 10000);
		$address = $this->getSUT();
		$this->assertNull($address->getFlatNumber());
		$address->setFlatNumber($flat_number);
		$this->assertEquals($flat_number, $address->getFlatNumber());
	}

	public function testBuildingNameGetterSetter()
	{
		$faker = Factory::create();
		$building_name = $faker->secondaryAddress;
		$address = $this->getSUT();
		$this->assertNull($address->getBuildingName());
		$address->setBuildingName($building_name);
		$this->assertEquals($building_name, $address->getBuildingName());
	}

	public function testBuildingNumberGetterSetter()
	{
		$faker = Factory::create();
		$building_number = $faker->buildingNumber;
		$address = $this->getSUT();
		$this->assertNull($address->getBuildingNumber());
		$address->setBuildingNumber($building_number);
		$this->assertEquals($building_number, $address->getBuildingNumber());
	}

	public function testStreetGetterSetter()
	{
		$faker = Factory::create();
		$street = $faker->streetName;
		$address = $this->getSUT();
		$this->assertNull($address->getStreet());
		$address->setStreet($street);
		$this->assertEquals($street, $address->getStreet());
	}

	public function testSubStreetGetterSetter()
	{
		$faker = Factory::create();
		$sub_street = $faker->secondaryAddress;
		$address = $this->getSUT();
		$this->assertNull($address->getSubStreet());
		$address->setSubStreet($sub_street);
		$this->assertEquals($sub_street, $address->getSubStreet());
	}

	public function testStateGetterSetter()
	{
		$faker = Factory::create();
		$state = $faker->stateAbbr;
		$address = $this->getSUT();
		$this->assertNull($address->getState());
		$address->setState($state);
		$this->assertEquals($state, $address->getState());
	}

	public function testTownGetterSetter()
	{
		$faker = Factory::create();
		$town = $faker->city;
		$address = $this->getSUT();
		$this->assertNull($address->getTown());
		$address->setTown($town);
		$this->assertEquals($town, $address->getTown());
	}

	public function testPostcodeGetterSetter()
	{
		$faker = Factory::create();
		$postcode = $faker->postcode;
		$address = $this->getSUT();
		$this->assertNull($address->getPostcode());
		$address->setPostcode($postcode);
		$this->assertEquals($postcode, $address->getPostcode());
	}

	public function testCountryGetterSetter()
	{
		$country = 'USA';
		$address = $this->getSUT();
		$this->assertNull($address->getCountry());
		$address->setCountry($country);
		$this->assertEquals($country, $address->getCountry());
	}

	public function testStartDateGetterSetter()
	{
		$faker = Factory::create();
		$start_date = $faker->date;
		$address = $this->getSUT();
		$this->assertNull($address->getStartDate());
		$address->setStartDate($start_date);
		$this->assertEquals($start_date, $address->getStartDate());
	}

	public function testEndDateGetterSetter()
	{
		$faker = Factory::create();
		$end_date = $faker->date;
		$address = $this->getSUT();
		$this->assertNull($address->getEndDate());
		$address->setEndDate($end_date);
		$this->assertEquals($end_date, $address->getEndDate());
	}

	public function testJsonSerialize()
	{
		$address = $this->getSUT();
		$json = json_encode($address);

		$expected = json_encode(array(
			'flat_number'     => null,
			'building_name'   => null,
			'building_number' => null,
			'street'          => null,
			'sub_street'      => null,
			'state'           => null,
			'town'            => null,
			'postcode'        => null,
			'country'         => null,
			'start_date'      => null,
			'end_date'        => null
		));

		$this->assertJsonStringEqualsJsonString($expected, $json);

		$address = $this->getSUT();

		$faker = Factory::create();
		$flat_number = $faker->numberBetween(0, 10000);
		$building_name = $faker->secondaryAddress;
		$building_number = $faker->buildingNumber;
		$street = $faker->streetName;
		$sub_street = $faker->secondaryAddress;
		$state = $faker->stateAbbr;
		$town = $faker->city;
		$postcode = $faker->postcode;
		$country = 'USA';
		$start_date = $faker->date;
		$end_date = $faker->date;

		$address->setFlatNumber($flat_number);
		$address->setBuildingName($building_name);
		$address->setBuildingNumber($building_number);
		$address->setStreet($street);
		$address->setSubStreet($sub_street);
		$address->setState($state);
		$address->setTown($town);
		$address->setPostcode($postcode);
		$address->setCountry($country);
		$address->setStartDate($start_date);
		$address->setEndDate($end_date);

		$json = json_encode($address);
		$expected = json_encode(array(
			'flat_number'     => $flat_number,
			'building_name'   => $building_name,
			'building_number' => $building_number,
			'street'          => $street,
			'sub_street'      => $sub_street,
			'state'           => $state,
			'town'            => $town,
			'postcode'        => $postcode,
			'country'         => $country,
			'start_date'      => $start_date,
			'end_date'        => $end_date
		));

		$this->assertJsonStringEqualsJsonString($expected, $json);
	}

	private function getSUT()
	{
		return new Address();
	}
}
