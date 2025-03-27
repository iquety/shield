# Length

[◂ Length](07-maxlength.md) | [Documentation Summary](index.md) | [IsAmountTime ▸](08-isamounttime.md)
-- | -- | --

The value has the minimum expected length.

```php
// string 'heart' contains at least 1 characters
new MinLength('heart', 1);

// integer 9 has at least the value 9
new MinLength(9, 9);

// decimal 9.1 has at least the value 9
new MinLength(9.1, 9);

// array with 3 elements has at least 2 elements
new MinLength([1, 2, 3], 2);

// \Countable object with 3 elements has at least 2 elements
new MinLength(new ArrayObject([1, 2, 3]), 2);
new MinLength(new ArrayIterator([1, 2, 3]), 2);

// object of type \stdClass with 3 public properties has at least 2 elements
$stdObject = new stdClass(); $stdObject->one = 'My';
$stdObject->two = 'Text';
$stdObject->three = 'Cool';
new MinLength($stdObject, 2);
```

[◂ Length](07-maxlength.md) | [Documentation Summary](index.md) | [IsAmountTime ▸](08-isamounttime.md)
-- | -- | --
