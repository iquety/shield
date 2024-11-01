<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsCep extends Assertion
{    
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        // Brazilian CEP format: 5 digits, a hyphen, and 3 digits (e.g., 12345-678)
        return preg_match('/^\d{5}-\d{3}$/', $this->getValue()) === 1;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid CEP");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid CEP",
        );
    }
}
