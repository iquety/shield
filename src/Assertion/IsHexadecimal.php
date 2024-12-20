<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsHexadecimal extends Assertion
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        return preg_match('/^[0-9a-fA-F]+$/', $this->getValue()) === 1;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid hexadecimal number");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid hexadecimal number",
        );
    }
}
