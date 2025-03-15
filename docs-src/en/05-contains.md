# Contains

--page-nav--

The full value contains the partial value.

```php
// string contains the word 'text'
new Contains('My text', 'text');

// string contains the number 123
new Contains('123456', 123);

// number contains the string 12.3
new Contains(12.3456, '12.3');

// number contains the number 123
new Contains(123456, 123);

// Array contains the element 'text'
new Contains(['My', 'text'], 'text');

// Objects of type \Stringable contain the word 'text'
new Contains(new Exception('My text'), 'text');

// Objects of type \IteratorAggregate contain the element 'text'
new Contains(new ArrayObject(['My', 'text']), 'text');

// Objects of type \Iterator contain the element 'text'
new Contains(new ArrayIterator(['My', 'text']), 'text');

// Objects of type \stdClass contain a public property with the value 'text'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
new Contains($stdObject, 'text');
```

--page-nav--
