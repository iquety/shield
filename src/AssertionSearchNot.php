<?php

declare(strict_types=1);

namespace Iquety\Shield;

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
        $value = $this->normalize($this->getValue());

        if (is_object($value) === true) {
            return true;
        }

        if (is_array($value) === true) {
            return $this->isValidInArray($value, $this->getAssertValue());
        }

        if (is_bool($value) === true && $value === true) {
            return $this->isMatches('true', $this->getAssertValue()) === false
                && $this->isMatches('TRUE', $this->getAssertValue()) === false;
        }

        if (is_bool($value) === true && $value === false) {
            return $this->isMatches('false', $this->getAssertValue()) === false
                && $this->isMatches('FALSE', $this->getAssertValue()) === false;
        }

        if (is_null($this->getValue()) === true) {
            return $this->isMatches('null', $this->getAssertValue()) === false
                && $this->isMatches('NULL', $this->getAssertValue()) === false;
        }

        $assertValue = $this->normalize($this->getAssertValue());

        return $this->isMatches((string)$value, $assertValue) === false;
    }
}
