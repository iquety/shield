<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\AssertionSearch;
use Iquety\Shield\Message;

class StartsWith extends AssertionSearch
{
    public function __construct(
        mixed $value,
        null|bool|float|int|string $needle
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    protected function isMatches(string $value, mixed $needle): bool
    {
        if ($needle === null) {
            $needle = 'null';
        }

        if ($needle === false) {
            $needle = 'false';
        }

        if ($needle === true) {
            $needle = 'true';
        }

        return str_starts_with($value, (string)$needle);
    }

    /** @param array<string,mixed> $list */
    protected function isValidInArray(array $list, mixed $element): bool
    {
        if ($list === []) {
            return false;
        }

        return $element === $list[array_key_first($list)];
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
