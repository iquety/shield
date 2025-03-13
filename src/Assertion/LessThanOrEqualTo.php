<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Countable;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class LessThanOrEqualTo extends Assertion
{
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

        if ($value instanceof Countable) {
            return $this->isValidCountable($value, $this->getAssertValue());
        }

        if (is_object($value) === true) {
            return false;
        }

        if (is_array($value) === true) {
            return $this->isValidArray($value, $this->getAssertValue());
        }

        if (is_string($value) === true) {
            return $this->isValidString($value, $this->getAssertValue());
        }

        return $this->isValidNumber($value, $this->getAssertValue());
    }

    private function isValidCountable(Countable $value, float|int $length): bool
    {
        return $value->count() <= (int)$length;
    }

    /** @param array<int|string,mixed> $value */
    private function isValidArray(array $value, float|int $length): bool
    {
        return count($value) <= (int)$length;
    }

    private function isValidNumber(float|int $value, float|int $length): bool
    {
        return $value <= $length;
    }

    private function isValidString(string $value, float|int $length): bool
    {
        return mb_strlen($value) <= (int)$length;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must be less or equal to %s characters",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must be less or equal to %s characters",
            $this->getAssertValue()
        ));
    }
}
