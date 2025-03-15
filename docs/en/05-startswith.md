# StartsWith

[◂ NotMatches](05-notmatches.md) | [Documentation Summary](index.md) | [GreaterThan ▸](06-greaterthan.md)
-- | -- | --

The full value starts with the partial value.

```php
// string starts with the word 'My'
new StartsWith('My text', 'My');

// string starts with the number 123
new StartsWith('123456', 123);

// number starts with the string 12.3
new StartsWith(12.3456, '12.3');

// number starts with the number 123
new StartsWith(123456, 123);

// first element of the Array is 'text'
new StartsWith(['My', 'text'], 'My');

// textual value of the object of type \Stringable starts with the word 'My'
new StartsWith(new MyStringable('My text'), 'My');

// first element of the \IteratorAggregate object is 'My'
new StartsWith(new ArrayObject(['My', 'text']), 'My');

// first element of the \Iterator object is 'My'
new StartsWith(new ArrayIterator(['My', 'text']), 'My');

// last property of the \stdClass object has the value 'My'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
new StartsWith($stdObject, 'My');
```

[◂ NotMatches](05-notmatches.md) | [Documentation Summary](index.md) | [GreaterThan ▸](06-greaterthan.md)
-- | -- | --
