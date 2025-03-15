# GreaterThan

--page-nav--

The value is larger than expected.

```php
// string 'heart' contains more than 4 characters
new GreaterThan('heart', 4);

// integer 9 is greater than 8
new GreaterThan(9, 8);

// decimal 9.1 is greater than 9
new GreaterThan(9.1, 9);

// decimal 9.9 is greater than 9.8
new GreaterThan(9.9, 9.8);

// array contains more than 2 elements
new GreaterThan([1, 2, 3], 2);

// object \Countable contains more than 2 elements
new GreaterThan(new ArrayObject([1, 2, 3]), 2);
new GreaterThan(new ArrayIterator([1, 2, 3]), 2);

// object of type \stdClass contains more than 2 public properties
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
$stdObject->three = 'Cool';
new GreaterThan($stdObject, 2);
```

--page-nav--
