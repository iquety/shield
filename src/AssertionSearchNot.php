<?php

declare(strict_types=1);

namespace Iquety\Shield;

use InvalidArgumentException;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
abstract class AssertionSearchNot extends Assertion
{
    use HasValueNormalizer;

    abstract protected function isMatches(string $value, mixed $needle): bool;

    /** @param array<string,mixed> $list */
    abstract protected function isValidInArray(array $list, mixed $element): bool;

    /** @SuppressWarnings(PHPMD.CyclomaticComplexity) */
    public function isValid(): bool
    {
        // | string            | string                          |
        // | Stringable        | string                          |
        // | array             | string, int, float, true, false |
        // | ArrayAccess       | string, int, float, true, false |
        // | Iterator          | string, int, float, true, false |
        // | IteratorAggregate | string, int, float, true, false |
        // | stdClass          | string, int, float, true, false |

        // transforma ArrayAccess, Iterator, IteratorAggregate e stdClass em arrays
        // mantém como estão os outros valores
        $value = $this->normalize($this->getValue());

        if (is_string($value) === true) {
            $assertValue = $this->normalize($this->getAssertValue());

            return $this->isValidString($value, $assertValue);
        }

        if (is_array($value) === true) {
            return $this->isValidList($value, $this->getAssertValue());
        }

        throw new InvalidArgumentException("The value is not valid");
    }

    private function isValidString(string $value, mixed $needle): bool
    {
        if (is_string($needle) === false) {
            throw new InvalidArgumentException(
                "Value needle is not a valid search value for a string"
            );
        }

        return $this->isMatches($value, $needle) === true;
    }

    /** @param array<string,mixed> $value */
    private function isValidList(array $value, mixed $needle): bool
    {
        if ($needle === null) {
            throw new InvalidArgumentException(
                "Null is not a valid search value for a list"
            );
        }

        return $this->isValidInArray($value, $needle);
    }
}
