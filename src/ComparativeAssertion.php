<?php

declare(strict_types=1);

namespace Iquety\Shield;

abstract class ComparativeAssertion extends Assertion
{
    protected function populate(
        mixed $actual,
        mixed $comparison,
        string $errorMessage = '',
        string $identity = '',
        string $exceptionType = ''
    ): void {
        $this->setActual($actual);
        $this->setComparison($comparison);

        $errorMessage === '' || $this->setErrorMessage($errorMessage);
        $identity === '' || $this->setIdentity($identity);
        $exceptionType === '' || $this->setExceptionType($exceptionType); // faz sentido???
    }
}
