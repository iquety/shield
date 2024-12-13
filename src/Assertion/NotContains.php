<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class NotContains extends Assertion
{
    /** @param array<mixed>|string $value */
    public function __construct(
        mixed $value,
        float|int|string $needle,
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
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

        return str_contains($value, $this->getAssertValue()) === false;
    }

    private function isValidInArray(): bool
    {
        $finded = array_search($this->getAssertValue(), $this->getValue(), true) !== false;

        return $finded === false;
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
