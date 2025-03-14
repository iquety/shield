<?php

declare(strict_types=1);

namespace Iquety\Shield;

use ArrayAccess;
use Iterator;
use IteratorAggregate;
use Stringable;

trait HasValueNormalizer
{
    protected function normalize(mixed $value): mixed
    {
        if ($value instanceof Stringable) {
            return (string)$value;
        }

        if ($value instanceof IteratorAggregate) {
            return iterator_to_array($value->getIterator());
        }
        
        if ($value instanceof Iterator) {
            return iterator_to_array($value);
        }

        if ($value instanceof ArrayAccess) {
            $list = (array)$value;    

            // o primeiro nível é o nome da classe serializada
            // "ArrayAccess@anonymous/application/tests/Assertions/ContainsTest.php:84$21values"
            return current($list);
        }

        // stdClass
        if (is_object($value) === true) {
            return (array)$value;
        }

        return $value;
    }
}
