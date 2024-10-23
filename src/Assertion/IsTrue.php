<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsTrue extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        return $this->getValue() === true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "The value is not true"
        );
    }
    
    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "The value of field '{{ field }}' is not true"
        );
    }
}
