<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\AssertionSearchNot;
use Iquety\Shield\Message;

class NotMatches extends AssertionSearchNot
{
    /** @param array<mixed>|string $value */
    public function __construct(
        mixed $value,
        string $pattern
    ) {
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
        $notMatched = true;

        foreach ($list as $item) {
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
