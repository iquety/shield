<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class EqualTo extends Assertion
{
    public function __construct(
        mixed $value,
        mixed $comparison,
    ) {
        $this->setValue($value);

        $this->setAssertValue($comparison);
    }

    public function isValid(): bool
    {
        if (
            is_object($this->getValue())
            && is_object($this->getAssertValue())
        ) {
            return $this->getValue() == $this->getAssertValue();
        }

        return $this->getValue() === $this->getAssertValue();
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "Value must be equal to '{{ assert-value }}'"
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must be equal to '%s'",
            $this->stringfy($this->getAssertValue())
        ));
    }
}
