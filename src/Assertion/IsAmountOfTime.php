<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsAmountOfTime extends Assertion
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        // 150:59:59
        // *:mm:ss
        $regex = '/^'
            . '(\d*)'
            . ':([0-5][0-9])'
            . ':([0-5][0-9])'
            . '$/';

        if (preg_match($regex, $this->getValue()) === 1) {
            return true;
        }

        return false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid amount of time");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid amount of time",
        );
    }
}
