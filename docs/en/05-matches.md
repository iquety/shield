# Matches

[◂ EndsWith](05-endswith.md) | [Documentation Summary](index.md) | [NotContains ▸](05-notcontains.md)
-- | -- | --

The full value matches or contains a portion of the regular expression.

| Full type                            |
|:--                                   |
| string                               |
| Stringable                           |
| array with string values ​​            |
| ArrayAccess with string values ​​      |
| Iterator with string values ​​         |
| IteratorAggregate with string values ​​|
| stdClass with string values          ​​|

Arguments with unsupported values ​​will throw an `InvalidArgumentException` exception.

```php

// text contains the pattern
new Matches('Lionheart', '/ear/');
new Matches('123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/');

// text value of the object of type \Stringable contains the pattern
new Matches(new CustomStringable('Heart'), '/ear/');

// array contains an element that matches the pattern
new Matches(['Heart', 'Hello World', 'Lion'], '/World/');

// object of type \ArrayAccess contains an element that matches the pattern
new Matches(new CustomArrayAccess(['Hello World', 'Lion']), '/World/');

// object of type \Iterator contains an element that matches the pattern
new Matches(new ArrayIterator(['Hello World', 'Lion']), '/World/');

// object of type \IteratorAggregate contains an element that matches the pattern
new Matches(new ArrayObject(['Hello World', 'Lion']), '/World/');

// object of type \stdClass contains a property
// with the value corresponding to the pattern
$stdObject = new stdClass();
$stdObject->one = 'Hello World';
$stdObject->two = 'Lion';

new Matches($stdObject, '/World/');
```

[◂ EndsWith](05-endswith.md) | [Documentation Summary](index.md) | [NotContains ▸](05-notcontains.md)
-- | -- | --
