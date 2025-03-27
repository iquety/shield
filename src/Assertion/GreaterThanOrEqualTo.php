<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Countable;
use InvalidArgumentException;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class GreaterThanOrEqualTo extends Assertion
{
    /** @param array<int|string,mixed>|float|int|string $value */
    public function __construct(
        mixed $value,
        float|int $length,
    ) {
        $this->setValue($value);

        $this->setAssertValue($length);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if (is_numeric($value) === true) {
            return $this->isValidNumber((float)$value, $this->getAssertValue());
        }

        if (is_array($value) === true) {
            return $this->isValidArray($value, $this->getAssertValue());
        }

        if ($value instanceof Countable) {
            return $this->isValidCountable($value, $this->getAssertValue());
        }

        throw new InvalidArgumentException("The value is not valid");
    }

    private function isValidCountable(Countable $value, float|int $length): bool
    {
        return $value->count() >= (int)$length;
    }

    /** @param array<int|string,mixed> $value */
    private function isValidArray(array $value, float|int $length): bool
    {
        return count($value) >= (int)$length;
    }

    private function isValidNumber(float|int $value, float|int $length): bool
    {
        return $value >= $length;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must be greater or equal to %s characters",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must be greater or equal to %s characters",
            $this->getAssertValue()
        ));
    }
}
