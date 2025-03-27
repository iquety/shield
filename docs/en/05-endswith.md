# EndsWith

[◂ Contains](05-contains.md) | [Documentation Summary](index.md) | [Matches ▸](05-matches.md)
-- | -- | --

The full value ends with the partial value.

| Full type         | Partial type                    |
|:--                |:--                              |
| string            | string                          |
| Stringable        | string                          |
| array             | string, int, float, true, false |
| ArrayAccess       | string, int, float, true, false |
| Iterator          | string, int, float, true, false |
| IteratorAggregate | string, int, float, true, false |
| stdClass          | string, int, float, true, false |

Arguments with unsupported values ​​will throw an `InvalidArgumentException` exception.

```php
// string ends with the word 'text'
new EndsWith('My text', 'text');

// textual value of the \Stringable object ends with the word 'text'
new EndsWith(new CustomStringable('My text'), 'text');

// last element of the Array is 'text'
new EndsWith(['My', 'text'], 'text');

// last element of the \ArrayAccess object is 'text'
new Contains(new CustomArrayAccess(['My', 'text']), 'text');

// last element of the \Iterator object is 'text'
new EndsWith(new ArrayIterator(['My', 'text']), 'text');

// last element of the \IteratorAggregate object is 'text'
new EndsWith(new ArrayObject(['My', 'text']), 'text');

// last property of the \stdClass object has the value 'text'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'text';

new EndsWith($stdObject, 'text');
```

[◂ Contains](05-contains.md) | [Documentation Summary](index.md) | [Matches ▸](05-matches.md)
-- | -- | --
