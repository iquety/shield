<?php

declare(strict_types=1);

namespace Iquety\Shield;

class MinLength extends ComparativeAssertion
{
    public function __construct(
        private float|int|string $actual,
        private int $minLength,
        private string $errorMessage = '',
        private string $identity = ''
    ) {
        $this->populate($actual, $minLength, $errorMessage, $identity);
    }

    public function isValid(): bool
    {
        $value = $this->getActual();
        $minLength = $this->getComparison();

        if (is_string($value) === true) {
            return $this->isValidString($value, $minLength);
        }

        return $this->isValidNumber($value, $minLength);
    }

    private function isValidNumber(float|int $value, int $minLength): bool
    {
        return $value >= $minLength;
    }

    private function isValidString(string $value, int $minLength): bool
    {
        return mb_strlen($value) >= $minLength;
    }
}
