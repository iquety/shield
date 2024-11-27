<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class EndsWith extends Assertion
{
    /** @param array<int|string,mixed>|string $value */
    public function __construct(
        array|string $value,
        float|int|string $needle,
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    public function isValid(): bool
    {
        if (is_array($this->getValue()) === true) {
            return $this->isValidInArray();
        }

        return str_ends_with($this->getValue(), (string)$this->getAssertValue());
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
