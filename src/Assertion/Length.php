<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Countable;
use InvalidArgumentException;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class Length extends Assertion
{
    public function __construct(mixed $value, int $length)
    {
        $this->setValue($value);

        $this->setAssertValue($length);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if ($value instanceof Stringable) {
            $value = (string)$value;
        }

        if (is_string($value) === true) {
            return $this->isValidString($value, $this->getAssertValue());
        }

        if (is_array($value) === true) {
            return $this->isValidArray($value, $this->getAssertValue());
        }

        if ($value instanceof Countable) {
            return $this->isValidCountable($value, $this->getAssertValue());
        }

        throw new InvalidArgumentException("The value is not valid");
    }

    private function isValidCountable(Countable $value, int $length): bool
    {
        return $value->count() === $length;
    }

    /** @param array<int|string,mixed> $value */
    private function isValidArray(array $value, int $length): bool
    {
        return count($value) === $length;
    }

    private function isValidString(string $value, int $length): bool
    {
        return mb_strlen($value) === $length;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must have length %s",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the '{{ field }}' field must have length %s",
            $this->getAssertValue()
        ));
    }
}
