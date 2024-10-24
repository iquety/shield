<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Exception;
use Iquety\Shield\Assertion;

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

    private function populateErrors(Exception &$exception): void
    {
        if ($exception instanceof AssertionException === false) {
            return;
        }

        $exception->extractErrorsFrom($this);
    }
}
