# NotMatches

--page-nav--

The full value does not match or does not contain a regular expression excerpt.

| Full type                            |
|:--                                   |
| string                               |
| Stringable                           |
| array with string values ​​            |
| ArrayAccess with string values ​​      |
| Iterator with string values ​         ​|
| IteratorAggregate with string values ​​|
| stdClass with string values ​​         |

Arguments with unsupported values ​​will throw an `InvalidArgumentException` exception.

```php
// text does not contain the pattern
new NotMatches('Lionheart', '/life/');
new NotMatches('123-456-7890', '/(\d{3})-(\d{3})-(\d{9})/');

// textual value of object of type \Stringable does not contain pattern
new NotMatches(new CustomStringable('Heart'), '/life/');

// array does not contain an element that matches pattern
new NotMatches(['Heart', 'Hello World', 'Lion'], '/life/');

// object of type \ArrayAccess does not contain an element that matches pattern
new NotMatches(new CustomArrayAccess(['Hello World', 'Lion']), '/life/');

// object of type \Iterator does not contain an element that matches pattern
new NotMatches(new ArrayIterator(['Hello World', 'Lion']), '/life/');

// object of type \IteratorAggregate does not contain an element that matches pattern
new NotMatches(new ArrayObject(['Hello World', 'Lion']), '/life/');

// object of type \stdClass does not contain a property
// with the value corresponding to the pattern
$stdObject = new stdClass();
$stdObject->one = 'Hello World';
$stdObject->two = 'Lion';

new NotMatches($stdObject, '/life/');
```

--page-nav--
