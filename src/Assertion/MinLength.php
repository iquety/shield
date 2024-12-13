<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class MinLength extends Assertion
{
    /** @param array<int|string,mixed>|float|int|string $value */
    public function __construct(
        mixed $value,
        float|int $minLength,
    ) {
        $this->setValue($value);

        $this->setAssertValue($minLength);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if (is_object($value) === true) {
            return false;
        }

        if (is_array($value) === true) {
            return $this->isValidArray($value, $this->getAssertValue());
        }

        if (is_string($value) === true) {
            return $this->isValidString($value, $this->getAssertValue());
        }

        return $this->isValidNumber($value, $this->getAssertValue());
    }

    /** @param array<int|string,mixed> $value */
    private function isValidArray(array $value, float|int $length): bool
    {
        return count($value) >= (int)$length;
    }

    private function isValidNumber(float|int $value, float|int $minLength): bool
    {
        return $value >= $minLength;
    }

    private function isValidString(string $value, float|int $minLength): bool
    {
        return mb_strlen($value) >= (int)$minLength;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must be greater than %s characters",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must be greater than %s characters",
            $this->getAssertValue()
        ));
    }
}
