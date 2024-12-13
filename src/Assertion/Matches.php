<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class Matches extends Assertion
{
    /** @param array<mixed>|string $value */
    public function __construct(
        mixed $value,
        string $pattern
    ) {
        $this->setValue($value);

        $this->setAssertValue($pattern);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if (is_object($value) === true) {
            return false;
        }

        if (is_array($this->getValue()) === true) {
            return $this->isValidInArray();
        }

        return $this->isMatches((string)$this->getValue(), $this->getAssertValue());
    }

    private function isMatches(string $value, string $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }

    private function isValidInArray(): bool
    {
        $array = $this->getValue();

        foreach ($array as $item) {
            $matched = $this->isMatches((string)$item, $this->getAssertValue());

            if ($matched === true) {
                return true;
            }
        }

        return false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must match %s",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must match %s",
            $this->getAssertValue()
        ));
    }
}
