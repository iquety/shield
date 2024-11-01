<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsMacAddress extends Assertion
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        if (
            strpos($this->getValue(), ':') !== false
            && strpos($this->getValue(), '-') !== false
        ) {
            return false;
        }

        return preg_match(
            '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            $this->getValue()
        ) === 1;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid MAC address");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid MAC address",
        );
    }
}
