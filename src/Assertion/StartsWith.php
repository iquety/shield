<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class StartsWith extends Assertion
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
        return str_starts_with($this->getValue(), $this->getAssertValue());
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must start with '%s'",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must start with '%s'",
            $this->getAssertValue()
        ));
    }
}
