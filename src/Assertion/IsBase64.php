<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsBase64 extends Assertion
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        return preg_match('/^[A-Za-z0-9+\/=]*$/', $this->getValue()) === 1;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid base64 string");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid base64 string",
        );
    }
}
