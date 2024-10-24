<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Exception;
use Iquety\Shield\Assertion;

/**
 * -> Assertions
 * EqualTo: Value must be equal to {{ value }}
 * NotEqualTo: Value must be different from {{ value }}
 * IsEmail: Value must be a valid email
 * IsEmpty: Value must be empty
 * IsNotEmpty: Value must not be empty
 * IsFalse: Value must be false
 * IsTrue: Value must be true
 * IsNull: Value must be null
 * IsNotNull: Value must not be null
 * MaxLength: Value must be less than {{ value }} characters
 * MinLength: Value must be greater than {{ value }} characters
 *
 * -> Named assertions
 * EqualTo: Value of the field 'name' must be equal to {{ value }}
 * NotEqualTo: Value of the field 'name' must be different from {{ value }}
 * IsEmail: Value of the field 'name' must be a valid email
 * IsEmpty: Value of the field 'name' must be empty
 * IsNotEmpty: Value of the field 'name' must not be empty
 * IsFalse: Value of the field 'name' must be false
 * IsTrue: Value of the field 'name' must be true
 * IsNull: Value of the field 'name' must be null
 * IsNotNull: Value of the field 'name' must not be null
 * MaxLength: Value of the field 'name' must be less than {{ value }} characters
 * MinLength: Value of the field 'name' must be greater than {{ value }} characters
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
