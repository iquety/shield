<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class IsEmail extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if ($value instanceof Stringable) {
            $value = (string)$value;
        }

        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        return true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "Value must be a valid email"
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must be a valid email"
        ));
    }
}
