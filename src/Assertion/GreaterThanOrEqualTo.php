<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class GreaterThanOrEqualTo extends Assertion
{
    public function __construct(
        float|int|string $value,
        float|int $length,
    ) {
        $this->setValue($value);

        $this->setAssertValue($length);
    }

    public function isValid(): bool
    {
        if (is_string($this->getValue()) === true) {
            return $this->isValidString($this->getValue(), $this->getAssertValue());
        }

        return $this->isValidNumber($this->getValue(), $this->getAssertValue());
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
