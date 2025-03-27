<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use InvalidArgumentException;
use Iquety\Shield\AssertionSearch;
use Iquety\Shield\Message;

class Matches extends AssertionSearch
{
    /** @param array<mixed>|string $value */
    public function __construct(mixed $value, mixed $pattern)
    {
        $this->setValue($value);

        $this->setAssertValue($pattern);
    }

    protected function isMatches(string $value, mixed $needle): bool
    {
        return preg_match($needle, $value) === 1;
    }

    /** @param array<string,mixed> $list */
    protected function isValidInArray(array $list, mixed $element): bool
    {
        // padrões são sempre strings
        if (is_string($element) === false) {
            throw new InvalidArgumentException('Regular expressions must be string');
        }

        foreach ($list as $item) {
            if (is_string($item) === false) {
                continue;
            }

            $matched = $this->isMatches((string)$item, $element);

            if ($matched === true) {
                return true;
            }
        }

        return false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must match %s",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must match %s",
            $this->getAssertValue()
        ));
    }
}
