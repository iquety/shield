<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use DateTime;
use Exception;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsTime extends Assertion
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        // ISO 8601 format : 23:59:59
        //                   hh:mm:ss
        $regex = '/^'
            . '(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])'
            . '$/';

        if (preg_match($regex, $this->getValue()) === 1) {
            return true;
        }

        // US format = 11:59:59 PM
        //             hh:mm:ss AM/PM
        $regex = '/^'
            . '(0[0-9]|1[0-1]):([0-5][0-9]):([0-5][0-9]) ([AaPp][Mm])'
            . '$/';

        if (preg_match($regex, $this->getValue()) === 1) {
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
