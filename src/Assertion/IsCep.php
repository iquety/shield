<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class IsCep extends Assertion
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

        $size = mb_strlen((string)$value);

        if (is_string($value) === true && $size === 9) {
            // Brazilian CEP format: 5 digits, a hyphen, and 3 digits (e.g., 12345-678)
            return preg_match('/^\d{5}-\d{3}$/', trim($value)) === 1;
        }

        if (is_numeric($value) && $size === 8) {
            return true;
        }

        return false;
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
