<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class IsTime extends Assertion
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
            || $value === null
            || empty(trim($value)) === true
        ) {
            return false;
        }

        // ISO 8601 format : 23:59:59
        //                   hh:mm:ss
        $regex = '/^'
            . '(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])'
            . '$/';

        if (preg_match($regex, $value) === 1) {
            return true;
        }

        // US format = 11:59:59 PM
        //             hh:mm:ss AM/PM
        $regex = '/^'
            . '(0[0-9]|1[0-1]):([0-5][0-9]):([0-5][0-9]) ([AaPp][Mm])'
            . '$/';

        if (preg_match($regex, $value) === 1) {
            return true;
        }

        return false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid time");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid time",
        );
    }
}
