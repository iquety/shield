<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use DateTime;
use Exception;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsDate extends Assertion
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
            || $value === null
            || empty(trim($value)) === true
        ) {
            return false;
        }

        // European format = 31/12/2024
        //                   dd/mm/yyyy
        $regex = '/^'
            . '(0[1-9]|[12][0-9]|3[01])\/' // 1 - 31
            . '(0[1-9]|1[0-2])\/' // 1 - 12
            . '\d{4}'
            . '$/';

        if (preg_match($regex, (string)$value) === 1) {
            return true;
        }

        // Alternative format = 2024.12.31
        //                      YYYY.mm.dd
        $regex = '/^'
            . '\d{4}\.'
            . '(0[1-9]|1[0-2])\.' // 1 - 12
            . '(0[1-9]|[12][0-9]|3[01])' // 1 - 31
            . '$/';

        if (preg_match($regex, (string)$value) === 1) {
            return true;
        }

        // ISO 8601 = '2024-12-31'
        // US format = '12/31/2024'
        // Abbreviated month name = '31-Dec-2024'
        // Full month name = 'December 31, 2024'
        try {
            new DateTime((string)$value);

            return true;
        } catch (Exception) {
            return false;
        }
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid date");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid date",
        );
    }
}
