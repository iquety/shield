<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\HasValueNormalizer;
use Iquety\Shield\Message;

class Contains extends Assertion
{
    use HasValueNormalizer;

    /** @param array<int|string,mixed>|string $value */
    public function __construct(
        mixed $value,
        null|bool|float|int|string $needle
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    public function isValid(): bool
    {
        $value = $this->normalize($this->getValue());

        if (is_array($value) === true) {
            return $this->isValidInArray($value, $this->getAssertValue());
        }

        if (is_bool($value) === true || is_null($value) === true) {
            return false;
        }

        return str_contains((string)$value, (string)$this->getAssertValue()) === true;
    }

    /** @param array<string,mixed> $list */
    private function isValidInArray(array $list, mixed $element): bool
    {
        return array_search($element, $list, true) !== false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must contain %s",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must contain %s",
            $this->getAssertValue()
        ));
    }
}
