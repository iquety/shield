<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsEmpty extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        return empty($this->getValue()) === true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(
            "Value must be empty"
        );
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be empty"
        );
    }
}
