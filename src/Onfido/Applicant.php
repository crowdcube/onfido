<?php

namespace Onfido;

use InvalidArgumentException;
use Onfido\Address;

class Applicant implements \JsonSerializable
{
    protected static $allowed_titles = ['Mr', 'Ms', 'Mrs', 'Miss'];
    protected static $allowed_genders = ['male', 'Male', 'female', 'Female'];

    protected $id;
    protected $created_at; // Unix timestamp
    protected $href;
    protected $title;
    protected $first_name;
    protected $middle_name;
    protected $last_name;
    protected $email;
    protected $gender;
    protected $dob; // Unix timestamp
    protected $telephone;
    protected $mobile;
    protected $country;
    protected $id_numbers = [];
    protected $addresses = []; // array of Onfido\Address instances

    /**
     * Gets the Onfido ID for the applicant.
     *
     * @return null|string The ID of the applicant.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the Onfido ID for the applicant instance.
     *
     * @param string $id The Onfido ID of the applicant.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the creation timestamp for the applicant.
     *
     * @param string $format The creation timestamp for the applicant.
     *
     * @return null|string The date and time of creation of the applicant.
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Sets the creation timestamp for the applicant.
     *
     * @param string $timestamp The timestamp representing the creation date and time of the applicant's file.
     */
    public function setCreatedAt($timestamp)
    {
        $this->created_at = $timestamp;
    }

    /**
     * The URL representing the applicant in Onfido.
     *
     * @return null|string The URL for the applicant.
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Sets the URL that represents the applicant in Onfido.
     *
     * @param string $href The URL for the applicant.
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * Gets the title of the applicant, e.g. 'Mr', 'Ms', etc.
     *
     * @return null|string The title of the applicant.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title of the applicant.
     *
     * Valid titles are 'Mr', 'Ms', 'Mrs', and 'Miss'
     *
     * @throws \InvalidArgumentException if the title is not supported by Onfido.
     *
     * @param string $title The applicant's title
     */
    public function setTitle($title)
    {
        if (in_array($title, self::$allowed_titles) === false)
        {
            throw new \InvalidArgumentException('The title: "' . $title . '" is not supported.');
        }

        $this->title = $title;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setMiddleName($middle_name)
    {
        $this->middle_name = $middle_name;
    }

    public function getMiddleName()
    {
        return $this->middle_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets the gender of the applicant.
     *
     * Valid values are 'male', 'Male', 'female', or 'Female'.
     *
     * @throws \InvalidArgumentException if the gender is not supported by Onfido.
     *
     * @param string $gender The gender of the applicant
     */
    public function setGender($gender)
    {
        if (in_array($gender, self::$allowed_genders) === false)
        {
            throw new \InvalidArgumentException('The gender: "' . $gender . '" is not supported.');
        }

        $this->gender = $gender;
    }

    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Sets the birthdate of the applicant.
     *
     * @param string $dob The timestamp of the applicant's birthdate.
     */
    public function setDob($timestamp)
    {
        $this->dob = $timestamp;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the country for the applicant.
     *
     * Must be a three letter ISO country code.
     * https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3
     *
     * @param string $country The country of residence for the applicant.
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getIdNumbers()
    {
        return $this->id_numbers;
    }

    public function setIdNumbers($id_numbers)
    {
        $this->id_numbers = $id_numbers;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }

    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'created_at' => $this->getCreatedAt(),
            'href' => $this->href,
            'title' => $this->title,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'telephone' => $this->telephone,
            'mobile' => $this->mobile,
            'country' => $this->country,
            'id_numbers' => $this->id_numbers,
            'addresses' => $this->addresses
        );
    }
}