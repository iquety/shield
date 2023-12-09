<?php

declare(strict_types=1);

namespace Iquety\Shield;

use DateTime;
use DateTimeImmutable;

class NotEqualTo extends ComparativeAssertion
{
    public function __construct(
        private mixed $actual,
        private mixed $comparison,
        private string $errorMessage = '',
        private string $identity = ''
    ) {
        $this->populate($actual, $comparison, $errorMessage, $identity);
    }

    public function isValid(): bool
    {
        if (
            $this->getActual() instanceof DateTime ||
            $this->getActual() instanceof DateTimeImmutable
        ) {
            return $this->getActual() != $this->getComparison();
        }

        return $this->getActual() !== $this->getComparison();
    }
}
