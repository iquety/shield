<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use ArrayAccess;
use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Stringable;

class NotContains extends Assertion
{
    /** @param array<mixed>|string $value */
    public function __construct(
        mixed $value,
        float|int|string $needle,
    ) {
        $this->setValue($value);

        $this->setAssertValue($needle);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if ($value instanceof ArrayAccess) {
            return $this->isValidInAcessible($value, $this->getAssertValue());
        }

        if (is_object($value) === true && ! $value instanceof Stringable) {
            return $this->isValidInStdClass($value, $this->getAssertValue());
        }

        if (is_bool($value) === true || is_null($value) === true) {
            return true;
        }

        if (is_array($this->getValue()) === true) {
            return $this->isValidInArray($this->getValue(), $this->getAssertValue());
        }

        return str_contains((string)$value, $this->getAssertValue()) === false;
    }

    private function isValidInAcessible(ArrayAccess $list, mixed $element): bool
    {
        $list = (array)$list;

        // o primeiro nível é o nome da classe serializada
        // "ArrayAccess@anonymous/application/tests/Assertions/ContainsTest.php:84$21values"
        $normalizedList = current($list);

        return $this->isValidInArray($normalizedList, $element);
    }

    private function isValidInStdClass(object $list, mixed $element): bool
    {
        $normalizedList = (array)$list;

        return $this->isValidInArray($normalizedList, $element);
    }

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
