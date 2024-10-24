<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class NotEqualTo extends Assertion
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
            return $this->getValue() != $this->getAssertValue();
        }

        return $this->getValue() !== $this->getAssertValue();
    }

    public function getDefaultMessage(): Message
    {
        return new Message("The values ​​must be different");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "The '{{ field }}' field value must be different from '%s'",
            $this->stringfy($this->getAssertValue())
        ));
    }
}
