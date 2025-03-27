<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use InvalidArgumentException;
use Iquety\Shield\AssertionSearchNot;
use Iquety\Shield\Message;

class NotMatches extends AssertionSearchNot
{
    /** @param array<mixed>|string $value */
    public function __construct(mixed $value, mixed $pattern)
    {
        $this->setValue($value);

        $this->setAssertValue($pattern);
    }

    protected function isMatches(string $value, mixed $needle): bool
    {
        return preg_match($needle, $value) === 0;
    }

    /** @param array<string,mixed> $list */
    protected function isValidInArray(array $list, mixed $element): bool
    {
        // padrões são sempre strings
        if (is_string($element) === false) {
            throw new InvalidArgumentException('Regular expressions must be string');
        }

        $notMatched = true;

        foreach ($list as $item) {
            if (is_string($item) === false) {
                continue;
            }

            if ($this->isMatches((string)$item, $element) === true) {
                $notMatched = false;
            }
        }

        return $notMatched;
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
