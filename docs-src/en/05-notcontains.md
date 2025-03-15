# NotContains

--page-nav--

The full value does not contain the partial value.

```php
// string does not contain the word 'cool'
new Contains('My text', 'cool');

// string does not contain the number 777
new Contains('123456', 777);

// number does not contain the string 77.3
new Contains(12.3456, '77.3');

// number does not contain the number 777
new Contains(123456, 777);

// Array does not contain the element 'cool'
new Contains(['My', 'text'], 'cool');

// Objects of type \Stringable do not contain the word 'cool'
new Contains(new Exception('My text'), 'cool');

// Objects of type \IteratorAggregate do not contain the element 'cool'
new Contains(new ArrayObject(['My', 'text']), 'cool');

// Objects of type \Iterator do not contain the element 'cool'
new Contains(new ArrayIterator(['My', 'text']), 'cool');

// Objects of type \stdClass do not contain a public property with the value 'cool'
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
new Contains($stdObject, 'cool');
```

--page-nav--
