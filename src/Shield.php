<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Exception;
use Iquety\Shield\Assertion;

/**
 * -> Assertions
 * EqualTo: Value must be equal to {{ assert-value }}
 * NotEqualTo: Value must be different from {{ assert-value }}
 * IsEmail: Value must be a valid email
 * IsEmpty: Value must be empty
 * IsNotEmpty: Value must not be empty
 * IsFalse: Value must be false
 * IsTrue: Value must be true
 * IsNull: Value must be null
 * IsNotNull: Value must not be null
 * MaxLength: Value must be less than {{ assert-value }} characters
 * MinLength: Value must be greater than {{ assert-value }} characters
 * Length: Value must be length {{ assert-value }}
 * GreaterThan: Value must be greater than {{ assert-value }}
 * LessThan: Value must be less than {{ assert-value }}
 * GreaterThanOrEqualTo: Value must be greater or equal to {{ assert-value }}
 * LessThanOrEqualTo: Value must be less or equal to {{ assert-value }}
 * Contains: Value must contain {{ assert-value }}
 * NotContains: Value must not contain {{ assert-value }}
 * StartsWith: Value must start with {{ assert-value }}
 * EndsWith: Value must end with {{ assert-value }}
 * Matches: Value must match {{ assert-value }}
 * NotMatches: Value must not match {{ assert-value }}
 * IsDate: Value must be a valid date
 * IsDateTime: Value must be a valid date and time
 * IsTime: Value must be a valid time
 * IsAmountOfTime: Value must be a valid amount of time
 * IsCreditCard: Value must be a valid credit card
 * IsUrl: Value must be a valid URL
 * IsIp: Value must be a valid IP address
 * IsMacAddress: Value must be a valid MAC address
 * IsPostalCode: Value must be a valid postal code
 * IsPhoneNumber: Value must be a valid phone number
 * IsGuid: Value must be a valid GUID
 * IsAlpha: Value must contain only letters
 * IsAlphaNumeric: Value must contain only letters and numbers
 * IsBase64: Value must be a valid base64 string
 * IsHexadecimal: Value must be a valid hexadecimal number
 * IsHexColor: Value must be a valid hexadecimal color
 * 
 * -> Named assertions
 * EqualTo: Value of the field 'name' must be equal to {{ assert-value }}
 * NotEqualTo: Value of the field 'name' must be different from {{ assert-value }}
 * IsEmail: Value of the field 'name' must be a valid email
 * IsEmpty: Value of the field 'name' must be empty
 * IsNotEmpty: Value of the field 'name' must not be empty
 * IsFalse: Value of the field 'name' must be false
 * IsTrue: Value of the field 'name' must be true
 * IsNull: Value of the field 'name' must be null
 * IsNotNull: Value of the field 'name' must not be null
 * MaxLength: Value of the field 'name' must be less than {{ assert-value }} characters
 * MinLength: Value of the field 'name' must be greater than {{ assert-value }} characters
 * Length: Value of the field 'name' field must be length {{ assert-value }}
 * GreaterThan: Value of the field 'name' must be greater than {{ assert-value }}
 * LessThan: Value of the field 'name' must be less than {{ assert-value }}
 * GreaterThanOrEqualTo: Value of the field 'name' must be greater or equal to {{ assert-value }}
 * LessThanOrEqualTo: Value of the field 'name' must be less or equal to {{ assert-value }}
 * Contains: Value of the field 'name' must contain {{ assert-value }}
 * NotContains: Value of the field 'name' must not contain {{ assert-value }}
 * StartsWith: Value of the field 'name' must start with {{ assert-value }}
 * EndsWith: Value of the field 'name' must end with {{ assert-value }}
 * Matches: Value of the field 'name' must match {{ assert-value }}
 * NotMatches: Value of the field 'name' must not match {{ assert-value }}
 * IsDate: Value of the field 'name' must be a valid date
 * IsDateTime: Value of the field 'name' must be a valid date and time
 * IsTime: Value of the field 'name' must be a valid time
 * IsAmountOfTime: Value of the field 'name' must be a valid amount of time
 * - IsCreditCard: Value of the field 'name' must be a valid credit card
 * - IsUrl: Value of the field 'name' must be a valid URL
 * - IsIp: Value of the field 'name' must be a valid IP address
 * - IsMacAddress: Value of the field 'name' must be a valid MAC address
 * - IsPostalCode: Value of the field 'name' must be a valid postal code
 * - IsPhoneNumber: Value of the field 'name' must be a valid phone number
 * - IsGuid: Value of the field 'name' must be a valid GUID
 * - IsAlpha: Value of the field 'name' must contain only letters
 * - IsAlphaNumeric: Value of the field 'name' must contain only letters and numbers
 * - IsBase64: Value of the field 'name' must be a valid base64 string
 * - IsHexadecimal: Value of the field 'name' must be a valid hexadecimal number
 * - IsHexColor: Value of the field 'name' must be a valid hexadecimal color
 */
class Shield
{
    /** @var array<int,Field> */
    private array $fieldList = [];

    /** @var array<int,Assertion> */
    private array $assertionList = [];

    /** @var array<int|string,array<int,string>|string> */
    private array $errorList = [];

    public function field(string $name): Field
    {
        $index = count($this->fieldList);

        $this->fieldList[$index] = new Field($name);

        return $this->fieldList[$index];
    }

    public function assert(Assertion $assertion): Assertion
    {
        $index = count($this->assertionList);

        $this->assertionList[$index] = $assertion;

        return $this->assertionList[$index];
    }

    public function hasErrors(): bool
    {
        return $this->getErrorList() !== [];
    }

    /** @return array<int|string,array<int,string>|string> */
    public function getErrorList(): array
    {
        if ($this->errorList === []) {
            $this->proccess();
        }

        return $this->errorList;
    }

    public function validOrThrow(string $exceptionType = AssertionException::class): void
    {
        if ($this->hasErrors() === true) {
            $exception = new $exceptionType(
                'The value was not successfully asserted'
            );

            $this->populateErrors($exception);

            throw $exception;
        }
    }

    private function proccess(): void
    {
        $list = [];

        foreach ($this->fieldList as $field) {
            $name = $field->getName();

            if (isset($list[$name]) === false) {
                $list[$name] = [];
            }

            $this->appendErrors($list[$name], $field->getErrorList());
        }

        $this->errorList = $list;

        foreach ($this->assertionList as $assertion) {
            if ($assertion->isValid() === false) {
                $this->errorList[] = $assertion->makeMessage();
            }
        }
    }

    /**
     * @param array<string,> $list
     * @param array<int,Assertion> $assertionList
     */
    private function appendErrors(array &$list, array $assertionList): void
    {
        foreach ($assertionList as $assertion) {
            $list[] = $assertion->makeMessage();
        }
    }

    private function populateErrors(Exception &$exception): void
    {
        if ($exception instanceof AssertionException === false) {
            return;
        }

        $exception->extractErrorsFrom($this);
    }
}
