<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class EndsWith extends Assertion
{
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

        if (is_array($value) === true) {
            return $this->isValidInArray();
        }

        return str_ends_with($value, (string)$this->getAssertValue());
    }

    private function isValidInArray(): bool
    {
        $array = $this->getValue();

        return $this->getAssertValue() === array_pop($array);
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must end with '%s'",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must end with '%s'",
            $this->getAssertValue()
        ));
    }
}
