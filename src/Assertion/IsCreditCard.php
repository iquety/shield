<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsCreditCard extends Assertion
{    
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        // validar tempo
        return preg_match($this->getAssertValue(), $this->getValue()) === false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid credit card");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid credit card",
        );
    }
}
