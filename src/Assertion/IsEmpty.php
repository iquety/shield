<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Countable;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsEmpty extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if ($value instanceof Countable) {
            return $value->count() === 0;
        }

        if (is_array($value) === true) {
            return count($value) === 0;
        }

        if (
            $value === false
            || is_object($value) === true
            || is_null($value) === true
        ) {
            return true;
        }

        if (is_string($value) === true) {
            $value = trim($value);
        }

        return empty($value) === true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "Value must be empty"
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be empty"
        );
    }
}
