# Contains

[◂ EqualTo](04-notequalto.md) | [Documentation Summary](index.md) | [EndsWith ▸](05-endswith.md)
-- | -- | --

The full value contains the partial value.

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
// string contains the word 'text'
new Contains('My text', 'text');

// Objects of type \Stringable contain the word 'text'
new Contains(new Exception('My text'), 'text');

// Array contains the element 'text'
new Contains(['My', 'text'], 'text');

// Objects of type \ArrayAccess contain the element 'text'
new Contains(new CustomArrayAccess(['My', 'text']), 'text');

// Objects of type \Iterator contain the element 'text'
new Contains(new ArrayIterator(['My', 'text']), 'text');

// Objects of type \IteratorAggregate contain the element 'text'
new Contains(new ArrayObject(['My', 'text']), 'text');

// Objects of type \stdClass contain a public property with the value 'text'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'text';

new Contains($stdObject, 'text');
```

[◂ EqualTo](04-notequalto.md) | [Documentation Summary](index.md) | [EndsWith ▸](05-endswith.md)
-- | -- | --
