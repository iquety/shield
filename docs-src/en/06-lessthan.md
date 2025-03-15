# LessThan

--page-nav--

The value is smaller than expected.

```php
// string 'heart' contains less than 6 characters
new LessThan('heart', 6);

// integer 8 is smaller than 9
new LessThan(8, 9);

// decimal 9.1 is smaller than 9.2
new LessThan(9.1, 9.2);

// array with 3 elements is smaller than 4
new LessThan([1, 2, 3], 4);

// \Countable object with 3 elements is smaller than 4
new LessThan(new ArrayObject([1, 2, 3]), 4);
new LessThan(new ArrayIterator([1, 2, 3]), 4);

// object of type \stdClass with 3 public properties is smaller than 4
$stdObject = new stdClass();
$stdObject->one = 'My';
$stdObject->two = 'Text';
$stdObject->three = 'Cool';
new LessThan($stdObject, 4);
```

--page-nav--
