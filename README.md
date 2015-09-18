# Onfido
A Composer library for Onfido's REST API

## Requirements
PHP 5.5

## Installation
1) Add to Composer file
```json
{
    "require": {
        "favor/onfido": "dev-master"
    }
}
```

2) Install
```
composer install
```

## Use
Almost all calls will go through the Onfido client to generate and update content.

```php
$client = new Onfido\Client(ONFIDO_TOKEN);
```

### Applicants
Applicants are the subjects of checks and reports in Onfido.

#### Create
The only required fields when creating an applicant are `first_name` and `last_name`.

```php
$params = array(
    'title' => 'Mr',
    'first_name' => 'Tester',
    'middle_name' => 'Test',
    'last_name' => 'McTesterson',
    'email' => 'test@mail.com',
    'gender' => 'male',
    'dob' => '1990-11-23',
    'telephone' => '123-456-7890',
    'mobile' => '987-654-3210',
    'country' => 'usa',
    'addresses' => array(
        array(
            'flat_number' => '13',
            'building_number' => '2411',
            'street' => 'Main Avenue',
            'sub_street' => null,
            'state' => 'TX',
            'town' => 'Austin',
            'postcode' => '78702',
            'country' => 'usa',
            'start_date' => '1999-02-28',
            'end_date' => null
        )
    ),
    'id_numbers' => array(
        array(
            'type' => 'ssn',
            'value' => '433-54-3937'
        )
    )
);

$applicant = $client->createApplicant($params);
```

#### Retrieve
```php
$applicant = $client->retrieveApplicant('1030303-123123-123123');
```

### Checks
All checks require the existence of an applicant in the Onfido system.

#### Identity Check

##### Create
Identity checks that are run on U.S. residents require the applicant record to have an e-mail address, date of birth, and a social security number.
```php
$identity_report = $client->runIdentityCheck('1030303-123123-123123');
```
