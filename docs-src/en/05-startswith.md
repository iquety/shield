# StartsWith

--page-nav--

The full value starts with the partial value.

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
// string starts with the word 'My'
new StartsWith('My text', 'My');

// textual value of object of type \Stringable starts with the word 'My'
new StartsWith(new CustomStringable('My text'), 'My');

// first element of the Array is 'My'
new StartsWith(['My', 'text'], 'My');

// first element of the object of type \ArrayAccess is 'My'
new Contains(new CustomArrayAccess(['My', 'text']), 'My');

// first element of the object of type \Iterator is 'My'
new StartsWith(new ArrayIterator(['My', 'text']), 'My');

// first element of the object of type \IteratorAggregate is 'My'
new StartsWith(new ArrayObject(['My', 'text']), 'My');

// first property of the object \stdClass has the value 'My'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';

new StartsWith($stdObject, 'My');
```

--page-nav--
