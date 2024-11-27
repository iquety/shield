<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class GreaterThanOrEqualTo extends Assertion
{
    /** @param array<int|string,mixed>|float|int|string $value */
    public function __construct(
        array|float|int|string $value,
        float|int $length,
    ) {
        $this->setValue($value);

        $this->setAssertValue($length);
    }

    public function isValid(): bool
    {
        if (is_array($this->getValue()) === true) {
            return $this->isValidArray($this->getValue(), $this->getAssertValue());
        }

        if (is_string($this->getValue()) === true) {
            return $this->isValidString($this->getValue(), $this->getAssertValue());
        }

        return $this->isValidNumber($this->getValue(), $this->getAssertValue());
    }

    /** @param array<int|string,mixed> $value */
    private function isValidArray(array $value, float|int $length): bool
    {
        return count($value) >= (int)$length;
    }

    private function isValidNumber(float|int $value, float|int $length): bool
    {
        return $value >= $length;
    }

    private function isValidString(string $value, float|int $length): bool
    {
        return mb_strlen($value) >= (int)$length;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must be greater or equal to %s characters",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must be greater or equal to %s characters",
            $this->getAssertValue()
        ));
    }
}
