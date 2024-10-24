<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsFalse extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        return $this->getValue() === false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "The value is not false"
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "The value of field '{{ field }}' is not false"
        );
    }
}
