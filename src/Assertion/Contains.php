<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class Contains extends Assertion
{
    /** @param array<int|string,mixed>|string $value */
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
            return false;
        }

        if (is_array($this->getValue()) === true) {
            return $this->isValidInArray();
        }

        return str_contains((string)$this->getValue(), (string)$this->getAssertValue()) === true;
    }

    private function isValidInArray(): bool
    {
        return array_search($this->getAssertValue(), $this->getValue(), true) !== false;
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
