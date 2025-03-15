# LessThanOrEqualTo

--page-nav--

The value is less than or equal to the expected value.

```php
// string 'heart' contains 6 or fewer characters
new LessThanOrEqualTo('heart', 6);

// integer 8 is less than or equal to 9
new LessThanOrEqualTo(8, 9);

// decimal 9.1 is less than or equal to 9.2
new LessThanOrEqualTo(9.1, 9.2);

// array with 3 elements is less than or equal to 4
new LessThanOrEqualTo([1, 2, 3], 4);

// \Countable object with 3 elements is less than or equal to 4
new LessThanOrEqualTo(new ArrayObject([1, 2, 3]), 4);
new LessThanOrEqualTo(new ArrayIterator([1, 2, 3]), 4);

// object of type \stdClass with 3 public properties is less than or equal to 4
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
$stdObject->three = 'Legal';
new LessThanOrEqualTo($stdObject, 4);
```

--page-nav--
