<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\AssertionSearchNot;
use Iquety\Shield\Message;

class NotContains extends AssertionSearchNot
{
    /** @param array<mixed>|string $value */
    public function __construct(mixed $value, mixed $needle)
    {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    protected function isMatches(string $value, mixed $needle): bool
    {
        return str_contains($value, (string)$needle) === false;
    }

    /** @param array<string,mixed> $list */
    protected function isValidInArray(array $list, mixed $element): bool
    {
        return array_search($element, $list, true) === false;
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
