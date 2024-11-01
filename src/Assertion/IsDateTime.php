<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use DateTime;
use Exception;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsDateTime extends Assertion
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        // European format : 31/12/2024 23:59:59
        //                   dd/mm/yyyy hh:mm:ss
        $regex = '/^'
            . '(0[1-9]|[12][0-9]|3[01])\/' // 1 - 31
            . '(0[1-9]|1[0-2])\/' // 1 - 12
            . '\d{4}'
            . ' '
            . '(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])'
            . '$/';

        if (preg_match($regex, $this->getValue()) === 1) {
            return true;
        }

        // Alternative format = '2024.12.31 23:59:59'
        //                       YYYY.mm.dd hh:mm:ss
        $regex = '/^'
            . '\d{4}\.'
            . '(0[1-9]|1[0-2])\.' // 1 - 12
            . '(0[1-9]|[12][0-9]|3[01])' // 1 - 31
            . ' '
            . '(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])'
            . '$/';

        if (preg_match($regex, $this->getValue()) === 1) {
            return true;
        }

        // ISO 8601 = '2024-12-31 23:59:59'
        // US format = '12/31/2024 11:59:59 PM'
        // Abbreviated month name = '31-Dec-2024 23:59:59'
        // Full month name = 'December 31, 2024 23:59:59'
        try {
            new DateTime($this->getValue());

            return true;
        } catch (Exception) {
            return false;
        }
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid date and time");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid date and time",
        );
    }
}
