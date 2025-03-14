<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\HasValueNormalizer;
use Iquety\Shield\Message;

class StartsWith extends Assertion
{
    use HasValueNormalizer;

    public function __construct(
        mixed $value,
        null|bool|float|int|string $needle
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    public function isValid(): bool
    {
        $value = $this->normalize($this->getValue());

        if (is_array($value) === true) {
            return $this->isValidInArray($value, $this->getAssertValue());
        }

        if (is_bool($value) === true || is_null($value) === true) {
            return false;
        }

        return str_starts_with((string)$value, (string)$this->getAssertValue());

        // $value = $this->getValue();

        // if (
        //     is_object($value) === true
        //     || is_bool($value) === true
        //     || is_null($value) === true
        // ) {
        //     return false;
        // }

        // if (is_array($value) === true) {
        //     return $this->isValidInArray();
        // }

        // return str_starts_with($value, (string)$this->getAssertValue());
    }

    /** @param array<string,mixed> $list */
    private function isValidInArray(array $list, mixed $element): bool
    {
        if ($list === []) {
            return false;
        }
        
        return $element === $list[array_key_first($list)];
    }

    // private function isValidInArray(): bool
    // {
    //     $array = $this->getValue();

    //     return $this->getAssertValue() === array_shift($array);
    // }

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
