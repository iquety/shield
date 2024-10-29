<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsIp extends Assertion
{    
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        if (filter_var($this->getValue(), FILTER_VALIDATE_IP) === false) {
            return false;
        }

        return true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid IP address");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid IP address",
        );
    }
}
