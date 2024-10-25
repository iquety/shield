<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class NotContains extends Assertion
{
    public function __construct(
        string $value,
        string $needle,
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    public function isValid(): bool
    {
        return str_contains($this->getValue(), $this->getAssertValue()) === false;
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
