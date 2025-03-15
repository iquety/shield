# EndsWith

[◂ Contains](05-contains.md) | [Documentation Summary](index.md) | [Matches ▸](05-matches.md)
-- | -- | --

The full value ends with the partial value.

```php
// string ends with the word 'text'
new EndsWith('My text', 'text');

// string ends with the number 456
new EndsWith('123456', 456);

// number ends with the string 456
new EndsWith(12.3456, '456');

// number ends with the number 456
new EndsWith(123456, 456);

// last element of the Array is 'text'
new EndsWith(['My', 'text'], 'text');

// textual value of the object of type \Stringable ends with the word 'text'
new EndsWith(new MyStringable('My text'), 'text');

// last element of the \IteratorAggregate object is 'text'
new EndsWith(new ArrayObject(['My', 'text']), 'text');

// last element of the \Iterator object is 'text'
new EndsWith(new ArrayIterator(['My', 'text']), 'text');

// last property of the \stdClass object has the value 'text'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
new EndsWith($stdObject, 'text');
```

[◂ Contains](05-contains.md) | [Documentation Summary](index.md) | [Matches ▸](05-matches.md)
-- | -- | --
