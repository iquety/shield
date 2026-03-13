<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class IsFalse extends Assertion
{
    // TODO
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if ($value === '' || $value === []) {
            return true;
        }

        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if (is_string($value) === true) {
            $value = trim($value);
        }

        return $value === false
            || $value === 'false'
            || $value === 0
            || $value === '0'
            || $value === 'off';
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            'Value must be false'
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be false"
        );
    }
}
