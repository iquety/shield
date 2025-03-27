# Length

[◂ Length](07-length.md) | [Documentation Summary](index.md) | [Length ▸](07-minlength.md)
-- | -- | --

The value has the maximum expected length.

```php
// string 'heart' contains a maximum of 5 characters
new MaxLength('heart', 5);

// integer 9 has a maximum value of 9
new MaxLength(9, 9);

// decimal 9.1 has a maximum value of 9.2
new MaxLength(9.1, 9.2);

// array with 3 elements has a maximum of 3 elements
new MaxLength([1, 2, 3], 3);

// \Countable object with 3 elements has a maximum of 3 elements
new MaxLength(new ArrayObject([1, 2, 3]), 3);
new MaxLength(new ArrayIterator([1, 2, 3]), 3);

// object of type \stdClass with 3 public properties has at most 3 elements
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
$stdObject->three = 'Legal';
new MaxLength($stdObject, 3);
```

[◂ Length](07-length.md) | [Documentation Summary](index.md) | [Length ▸](07-minlength.md)
-- | -- | --
