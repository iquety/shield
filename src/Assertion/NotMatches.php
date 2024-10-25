<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class NotMatches extends Assertion
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
        return preg_match($this->getAssertValue(), $this->getValue()) !== 1;
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
