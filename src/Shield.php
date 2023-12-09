<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Exception;

class Shield
{
    private ?Assertion $last = null;

    private array $assertionList = [];

    private array $errorList = [];

    public function assert(Assertion $assertion): self
    {
        $this->errorList = [];

        $this->last = $assertion;

        $this->assertionList[] = $this->last;

        return $this;
    }

    public function identity(string $identity): self
    {
        $this->last->setIdentity($identity);

        return $this;
    }

    public function orThrow(string $exceptionType): self
    {
        $this->last->setExceptionType($exceptionType);

        return $this;
    }

    public function hasErrors(): bool
    {
        return $this->getErrorList() !== [];
    }

    /** @return array<int,Assertion> */
    public function getErrorList(): array
    {
        if ($this->errorList !== []) {
            return $this->errorList;
        }

        foreach ($this->assertionList as $assert) {
            if ($assert->isValid() === false) {
                $this->errorList[] = $assert;
            }
        }

        return $this->errorList;
    }

    public function validOrThrow(string $defaultExceptionType = Exception::class): void
    {
        if ($this->hasErrors() === true) {
            $list = $this->getErrorList();

            $assert = $list[0];

            $assertExceptionType = $assert->getExceptionType();

            $exceptionType = $assertExceptionType !== Exception::class
                ? $assertExceptionType
                : $defaultExceptionType;

            throw new $exceptionType($assert->getErrorMessage());
        }
    }
}
