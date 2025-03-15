# Length

[◂ GreaterThanOrEqualTo](06-greaterthanorequalto.md) | [Documentation Summary](index.md) | [LessThan ▸](06-lessthan.md)
-- | -- | --

The value has the expected length.

```php
// string 'heart' contains 5 characters
new Length('heart', 5);

// integer 9 has length 9
new Length(9, 9);

// decimal 9.1 has length 9.1
new Length(9.1, 9.1);

// array with 3 elements has length 3
new Length([1, 2, 3], 3);

// \Countable object with 3 elements has length 3
new Length(new ArrayObject([1, 2, 3]), 3);
new Length(new ArrayIterator([1, 2, 3]), 3);

// object of type \stdClass with 3 public properties has length 3
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
$stdObject->three = 'Cool';
new Length($stdObject, 3);
```

[◂ GreaterThanOrEqualTo](06-greaterthanorequalto.md) | [Documentation Summary](index.md) | [LessThan ▸](06-lessthan.md)
-- | -- | --
