<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class IsMacAddress extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if (empty($value) === true) {
            return true;
        }

        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if (
            is_bool($value) === true
            || is_object($value) === true
            || is_array($value) === true
        ) {
            return false;
        }

        if (
            str_contains((string) $value, ':')
            && str_contains((string) $value, '-')
        ) {
            return false;
        }

        return preg_match(
            '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            (string) $value
        ) === 1;
    }

    public function getDefaultMessage(): Message
    {
        return new Message('Value must be a valid MAC address');
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid MAC address",
        );
    }
}
