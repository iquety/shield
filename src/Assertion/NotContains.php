<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\AssertionSearchNot;
use Iquety\Shield\Message;

class NotContains extends AssertionSearchNot
{
    /** @param array<mixed>|string $value */
    public function __construct(
        mixed $value,
        null|bool|float|int|string $needle
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    // public function isValid(): bool
    // {
    //     $value = $this->normalize($this->getValue());

    //     if (is_array($value) === true) {
    //         return $this->isValidInArray($value, $this->getAssertValue());
    //     }

    //     if (is_null($value) === true) {
    //         return $this->isMatches('null', $this->getAssertValue()) === false
    //             && $this->isMatches('NULL', $this->getAssertValue()) === false;
    //     }

    //     if (is_bool($value) === true && $value === true) {
    //         return $this->isMatches('true', $this->getAssertValue()) === false
    //             && $this->isMatches('TRUE', $this->getAssertValue()) === false;
    //     }

    //     if (is_bool($value) === true && $value === false) {
    //         return $this->isMatches('false', $this->getAssertValue()) === false
    //             && $this->isMatches('FALSE', $this->getAssertValue()) === false;
    //     }

    //     return $this->isMatches((string)$value, $this->getAssertValue()) === false;
    // }

    protected function isMatches(string $value, mixed $needle): bool
    {
        if ($needle === null) {
            $needle = 'null';
        }

        if ($needle === false) {
            $needle = 'false';
        }

        if ($needle === true) {
            $needle = 'true';
        }

        return str_contains($value, (string)$needle) === true;
    }

    /** @param array<string,mixed> $list */
    protected function isValidInArray(array $list, mixed $element): bool
    {
        return array_search($element, $list, true) === false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must not contain %s",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must not contain %s",
            $this->getAssertValue()
        ));
    }
}
