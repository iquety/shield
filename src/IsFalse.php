<?php

declare(strict_types=1);

namespace Iquety\Shield;

class IsFalse extends CommonAssertion
{
    public function __construct(
        private mixed $actual,
        private string $errorMessage = '',
        private string $identity = ''
    ) {
        $this->populate($actual, $errorMessage, $identity);
    }

    public function isValid(): bool
    {
        return $this->getActual() === false;
    }
}
