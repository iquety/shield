<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsAlphaNumeric extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if (
            is_bool($value) === true
            || is_object($value) === true
            || is_array($value) === true
        ) {
            return false;
        }
        
        if (is_numeric($value) === true) {
            return true;
        }

        return preg_match(
            '/^[a-zA-Z0-9áéíóúÁÉÍÓÚàèìòùÀÈÌÒÙãõÃÕçÇ\s]+$/',
            (string)$value
        ) === 1;
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
