<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\AssertionSearch;
use Iquety\Shield\Message;

class Contains extends AssertionSearch
{
    /** @param array<int|string,mixed>|string $value */
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

        return str_contains($value, (string)$needle) === true;
    }

    /** @param array<string,mixed> $list */
    protected function isValidInArray(array $list, mixed $element): bool
    {
        return array_search($element, $list, true) !== false;
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
