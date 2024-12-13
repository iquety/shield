<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsAlphaNumeric extends Assertion
{
    public function __construct(float|int|string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        if (is_numeric($this->getValue()) === true) {
            return true;
        }

        return preg_match(
            '/^[a-zA-Z0-9áéíóúÁÉÍÓÚàèìòùÀÈÌÒÙãõÃÕçÇ\s]+$/',
            $this->getValue()
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
