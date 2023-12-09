<?php

declare(strict_types=1);

namespace Iquety\Shield;

abstract class CommonAssertion extends Assertion
{
    protected function populate(
        mixed $actual,
        string $errorMessage = '',
        string $identity = '',
        string $exceptionType = ''
    ): void {
        $this->setActual($actual);

        $errorMessage === '' || $this->setErrorMessage($errorMessage);
        $identity === '' || $this->setIdentity($identity);
        $exceptionType === '' || $this->setExceptionType($exceptionType);
    }
}
