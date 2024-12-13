<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsAlpha extends Assertion
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        return preg_match(
            '/^[a-zA-ZáéíóúÁÉÍÓÚàèìòùÀÈÌÒÙãõÃÕçÇ\s]+$/',
            $this->getValue()
        ) === 1;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must contain only letters");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must contain only letters",
        );
    }
}
