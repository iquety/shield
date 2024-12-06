<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class NotMatches extends Assertion
{
    /** @param array<mixed>|string $value */
    public function __construct(
        array|string $value,
        string $pattern
    ) {
        $this->setValue($value);

        $this->setAssertValue($pattern);
    }

    public function isValid(): bool
    {
        if (is_array($this->getValue()) === true) {
            return $this->isValidInArray();
        }

        return $this->isMatches($this->getValue(), $this->getAssertValue()) === false;
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
