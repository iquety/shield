<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Iquety\Shield\Message;
use ReflectionObject;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
abstract class Assertion
{
    private string $fieldName = '';

    private mixed $value = '';

    private mixed $assertValue = '';

    private ?Message $message = null;

    abstract public function isValid(): bool;

    abstract public function getDefaultMessage(): Message;

    abstract public function getDefaultNamedMessage(): Message;

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getAssertValue(): mixed
    {
        return $this->assertValue;
    }

    public function setFieldName(string $name): void
    {
        $this->fieldName = $name;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function setAssertValue(mixed $value): void
    {
        $this->assertValue = $value;
    }

    public function makeMessage(): string
    {
        if ($this->message === null) {
            return $this->makeDefaultMessage();
        }

        return $this->message->make(
            $this->getFieldName(),
            $this->stringfy($this->getValue()),
            $this->stringfy($this->getAssertValue())
        );
    }

    protected function stringfy(mixed $value): string
    {
        if (is_bool($value) && $value === true) {
            return 'true';
        }

        if (is_bool($value) && $value === false) {
            return 'false';
        }

        if ($value === null) {
            return 'null';
        }

        if (is_object($value) === true) {
            return $this->extractObjectState($value);
        }

        if (is_array($value) === true) {
            return $this->extractArrayState($value);
        }

        return (string) $value;
    }

    private function extractObjectState(object $object): string
    {
        $state = [];

        $reflector = new ReflectionObject($object);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);

            $state[$property->getName()] = $property->getValue($object);
        }

        return sprintf(
            '%s:%s',
            $object::class,
            str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($state))
        );
    }

    /** @param array<int|string,mixed> $list */
    private function extractArrayState(array $list): string
    {
        $state = [];

        foreach ($list as $name => $value) {
            $state[$name] = $value;
        }

        return str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($state));
    }

    private function makeDefaultMessage(): string
    {
        if ($this->getFieldName() !== '') {
            return $this->getDefaultNamedMessage()->make(
                $this->getFieldName(),
                $this->stringfy($this->getValue()),
                $this->stringfy($this->getAssertValue())
            );
        }

        return $this->getDefaultMessage()->make(
            '',
            $this->stringfy($this->getValue()),
            $this->stringfy($this->getAssertValue())
        );
    }

    public function message(string $pattern): void
    {
        $this->message = new Message($pattern);
    }
}
