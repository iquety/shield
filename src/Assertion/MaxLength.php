<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Countable;
use InvalidArgumentException;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class MaxLength extends Assertion
{
    /** @param array<int|string,mixed>|string $value */
    public function __construct(mixed $value, int $maxLength)
    {
        $this->setValue($value);

        $this->setAssertValue($maxLength);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

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

    private function isValidCountable(Countable $value, float|int $length): bool
    {
        return $value->count() <= (int)$length;
    }

    /** @param array<int|string,mixed> $value */
    private function isValidArray(array $value, float|int $length): bool
    {
        return count($value) <= (int)$length;
    }

    private function isValidString(string $value, float|int $maxLength): bool
    {
        return mb_strlen($value) <= (int)$maxLength;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must be less than %s characters",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must be less than %s characters",
            $this->getAssertValue()
        ));
    }
}
