<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\HasValueNormalizer;
use Iquety\Shield\Message;

class NotContains extends Assertion
{
    use HasValueNormalizer;
    
    /** @param array<mixed>|string $value */
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
            return true;
        }

        return str_contains((string)$value, (string)$this->getAssertValue()) === false;

        // $value = $this->getValue();

        // if ($value instanceof ArrayAccess) {
        //     return $this->isValidInAcessible($value, $this->getAssertValue());
        // }

        // if (is_object($value) === true && ! $value instanceof Stringable) {
        //     return $this->isValidInStdClass($value, $this->getAssertValue());
        // }

        // if (is_bool($value) === true || is_null($value) === true) {
        //     return true;
        // }

        // if (is_array($this->getValue()) === true) {
        //     return $this->isValidInArray($this->getValue(), $this->getAssertValue());
        // }

        // return str_contains((string)$value, $this->getAssertValue()) === false;
    }

    // /** @param ArrayAccess<string,mixed> $list */
    // private function isValidInAcessible(ArrayAccess $list, mixed $element): bool
    // {
    //     $list = (array)$list;

    //     // o primeiro nível é o nome da classe serializada
    //     // "ArrayAccess@anonymous/application/tests/Assertions/ContainsTest.php:84$21values"
    //     $normalizedList = current($list);

    //     return $this->isValidInArray($normalizedList, $element);
    // }

    // private function isValidInStdClass(object $list, mixed $element): bool
    // {
    //     $normalizedList = (array)$list;

    //     return $this->isValidInArray($normalizedList, $element);
    // }

    /** @param array<string,mixed> $list */
    private function isValidInArray(array $list, mixed $element): bool
    {
        return array_search($element, $list, true) === false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message(sprintf(
            "Value must not contain %s",
            $this->getAssertValue()
        ));
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(sprintf(
            "Value of the field '{{ field }}' must not contain %s",
            $this->getAssertValue()
        ));
    }
}
