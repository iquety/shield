<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class MinLength extends Assertion
{
    public function __construct(
        float|int|string $value,
        int $minLength,
    ) {
        $this->setValue($value);

        $this->setAssertValue($minLength);
    }

    public function isValid(): bool
    {
        if (is_string($this->getValue()) === true) {
            return $this->isValidString($this->getValue(), $this->getAssertValue());
        }

        return $this->isValidNumber($this->getValue(), $this->getAssertValue());
    }

    private function isValidNumber(float|int $value, int $minLength): bool
    {
        return $value >= $minLength;
    }

    private function isValidString(string $value, int $minLength): bool
    {
        return mb_strlen($value) >= $minLength;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "The value must have a minimum of %s characters",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "The value of the field '{{ field }}' must have a minimum of %s characters",
            $this->getAssertValue()
        ));
    }
}
