<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\AssertionSearch;
use Iquety\Shield\Message;

class EndsWith extends AssertionSearch
{
    public function __construct(mixed $value, mixed $needle)
    {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    protected function isMatches(string $value, mixed $needle): bool
    {
        return str_ends_with($value, (string)$needle);
    }

    /** @param array<string,mixed> $list */
    protected function isValidInArray(array $list, mixed $element): bool
    {
        if ($list === []) {
            return false;
        }

        return $element === $list[array_key_last($list)];
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
