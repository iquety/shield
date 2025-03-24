<?php

declare(strict_types=1);

namespace Iquety\Shield;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
abstract class AssertionSearch extends Assertion
{
    use HasValueNormalizer;

    abstract protected function isMatches(string $value, mixed $needle): bool;

    /** @param array<string,mixed> $list */
    abstract protected function isValidInArray(array $list, mixed $element): bool;

    /** @SuppressWarnings(PHPMD.CyclomaticComplexity) */
    public function isValid(): bool
    {
        $value = $this->normalize($this->getValue());

        if (is_array($value) === true) {
            return $this->isValidInArray($value, $this->getAssertValue());
        }

        if ($value === null) {
            return $this->isMatches('null', $this->getAssertValue()) === true
                || $this->isMatches('NULL', $this->getAssertValue()) === true;
        }

        if (is_bool($value) === true && $value === true) {
            return $this->isMatches('true', $this->getAssertValue()) === true
                || $this->isMatches('TRUE', $this->getAssertValue()) === true;
        }

        if (is_bool($value) === true && $value === false) {
            return $this->isMatches('false', $this->getAssertValue()) === true
                || $this->isMatches('FALSE', $this->getAssertValue()) === true;
        }

        $assertValue = $this->normalize($this->getAssertValue());

        return $this->isMatches((string)$value, $assertValue) === true;
    }
}
