# MaxLength

--page-nav--

The value has the maximum expected length.

| Verifiable types |
|:--               |
| string           |
| Stringable       |
| array            |
| Countable        |
| stdClass         |

```php
// string 'heart' contains at most 7 characters
new MaxLength('heart', 7);

// array with 3 elements has at most 3 elements
new MaxLength([1, 2, 3], 3);

// \Countable object with 3 elements has at most 3 elements
new MaxLength(new CustomCountable([1, 2, 3]), 3);
```

--page-nav--
