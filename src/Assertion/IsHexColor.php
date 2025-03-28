<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class IsHexColor extends Assertion
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

        if (
            is_bool($value) === true
            || is_object($value) === true
            || is_array($value) === true
        ) {
            return false;
        }

        $pattern = '/^#([A-Fa-f0-9]{8}|[A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';

        return preg_match($pattern, (string)$value) === 1;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid hexadecimal color");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid hexadecimal color",
        );
    }
}
