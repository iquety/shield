# GreaterThanOrEqualTo

[◂ GreaterThan](06-greaterthan.md) | [Documentation Summary](index.md) | [Length ▸](06-length.md)
-- | -- | --

The value is greater than or equal to what is expected.

```php
// string 'heart' contains 5 or more characters
new GreaterThanOrEqualTo('heart', 5);

// integer 9 is greater than or equal to 8
new GreaterThanOrEqualTo(9, 8);

// decimal 9.1 is greater than or equal to 9
new GreaterThanOrEqualTo(9.1, 9);

// decimal 9.9 is greater than or equal to 9.8
new GreaterThanOrEqualTo(9.9, 9.8);

// array contains 2 or more elements
new GreaterThanOrEqualTo([1, 2, 3], 2);

// object \Countable contains 2 or more elements
new GreaterThanOrEqualTo(new ArrayObject([1, 2, 3]), 2); new GreaterThanOrEqualTo(new ArrayIterator([1, 2, 3]), 2);

// object of type \stdClass contains 2 or more public properties
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
$stdObject->three = 'Cool';
new GreaterThanOrEqualTo($stdObject, 2);
```

[◂ GreaterThan](06-greaterthan.md) | [Documentation Summary](index.md) | [Length ▸](06-length.md)
-- | -- | --
