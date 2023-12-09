<?php

declare(strict_types=1);

namespace Iquety\Shield;

class MaxLength extends ComparativeAssertion
{
    public function __construct(
        private float|int|string $actual,
        private int $maxLength,
        private string $errorMessage = '',
        private string $identity = ''
    ) {
        $this->populate($actual, $maxLength, $errorMessage, $identity);
    }

    public function isValid(): bool
    {
        $value = $this->getActual();
        $maxLength = $this->getComparison();

        if (is_string($value) === true) {
            return $this->isValidString($value, $maxLength);
        }

        return $this->isValidNumber($value, $maxLength);
    }

    private function isValidNumber(float|int $value, int $maxLength): bool
    {
        return $value <= $maxLength;
    }

    private function isValidString(string $value, int $maxLength): bool
    {
        return mb_strlen($value) <= $maxLength;
    }
}
