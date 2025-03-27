# Length

--page-nav--

The value has the expected length.

| Verifiable types |
|:--               |
| string           |
| Stringable       |
| array            |
| Countable        |
| stdClass         |

```php
// string 'heart' contains 7 characters
new Length('heart', 7);

// array with 3 elements has length 3
new Length([1, 2, 3], 3);

// \Countable object with 3 elements has length 3
new Length(new CustomCountable([1, 2, 3]), 3);
```

--page-nav--
