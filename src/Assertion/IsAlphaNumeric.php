<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsAlphaNumeric extends Assertion
{    
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        // validar
        return preg_match($this->getAssertValue(), $this->getValue()) === false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must contain only letters and numbers");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must contain only letters and numbers",
        );
    }
}