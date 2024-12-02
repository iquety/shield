<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ReflectionObject;
use Tests\TestCase;

class AssertionCase extends TestCase
{
    protected function makeObjectMessage(object $object): string
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

    /** @return array<int,mixed> */
    protected function makeArrayMessage(array $value): string
    {
        return str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($value));
    }

    protected function makeMessageValue(mixed $value): string
    {
        switch(gettype($value)) {
            case 'array':
                $messageValue = $this->makeArrayMessage($value);

                break;
            case 'object':
                $messageValue = $this->makeObjectMessage($value);

                break;
            default:
                $messageValue = (string)$value;
        };

        return $messageValue;
    }
}
