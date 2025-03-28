<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Countable;
use InvalidArgumentException;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class IsEmpty extends Assertion
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

        if ($value instanceof Countable) {
            return $value->count() === 0;
        }

        if (is_object($value) === true) {
            throw new InvalidArgumentException("The value is not valid");
        }

        if (is_array($value) === true) {
            return count($value) === 0;
        }

        if (
            $value === false || $value === null
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
