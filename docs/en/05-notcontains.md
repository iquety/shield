# NotContains

[◂ Matches](05-matches.md) | [Documentation Summary](index.md) | [NotMatches ▸](05-notmatches.md)
-- | -- | --

The full value does not contain the partial value.

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
// text does not contain the word 'legal'
new NotContains('My text', 'legal');

// Objects of type \Stringable do not contain the word 'legal'
new NotContains(new Exception('My text'), 'legal');

// Array does not contain the element 'legal'
new NotContains(['My', 'text'], 'legal');

// Objects of type \ArrayAccess contain the element 'legal'
new NotContains(new CustomArrayAccess(['My', 'text']), 'legal');

// Objects of type \Iterator do not contain the element 'legal'
new NotContains(new ArrayIterator(['My', 'text']), 'legal');

// Objects of type \IteratorAggregate do not contain the element 'legal'
new NotContains(new ArrayObject(['My', 'text']), 'legal');

// Objects of type \stdClass do not contain a public property with the value 'legal'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'text';

new NotContains($stdObject, 'legal');
```

[◂ Matches](05-matches.md) | [Documentation Summary](index.md) | [NotMatches ▸](05-notmatches.md)
-- | -- | --
