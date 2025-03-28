<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsTrue extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if (is_string($value) === true) {
            $value = trim($value);
        }

        return $value === true
            || $value === 'true'
            || $value === 1
            || $value === '1'
            || $value === 'on';
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "Value must be true"
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be true"
        );
    }
}
