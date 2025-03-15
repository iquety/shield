<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class NotMatches extends Assertion
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
            return true;
        }

        if (is_array($value) === true) {
            return $this->isValidInArray();
        }

        if (is_null($this->getValue()) === true) {
            return $this->isMatches('null', $this->getAssertValue()) === false
                && $this->isMatches('NULL', $this->getAssertValue()) === false;
        }

        return $this->isMatches((string)$value, $this->getAssertValue()) === false;
    }

    private function isMatches(string $value, string $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }


    private function isValidInArray(): bool
    {
        $array = $this->getValue();

        $notMatched = true;

        foreach ($array as $item) {
            if ($this->isMatches((string)$item, $this->getAssertValue()) === true) {
                $notMatched = false;
            }
        }

        return $notMatched;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must not match %s",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must not match %s",
            $this->getAssertValue()
        ));
    }
}
