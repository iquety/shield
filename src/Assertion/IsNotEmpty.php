<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Countable;
use InvalidArgumentException;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsNotEmpty extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if ($value instanceof Countable) {
            return $value->count() > 0;
        }

        if (is_object($value) === true) {
            throw new InvalidArgumentException("The value is not valid");
        }

        if (is_array($value) === true) {
            return count($value) > 0;
        }

        if (is_bool($value) === true) {
            return $value === true;
        }

        if (is_string($value) === true) {
            return $this->stringIsNotEmpty($value);
        }

        if (is_numeric($value) === true) {
            return $value > 0;
        }

        return $value !== null;
    }

    private function stringIsNotEmpty(string $value): bool
    {
        $value = trim($value);

        return empty($value) === false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "Value must not be empty"
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must not be empty"
        );
    }
}
