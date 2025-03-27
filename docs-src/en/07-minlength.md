# MinLength

--page-nav--

The value has the minimum expected length.

| Verifiable types |
|:--               |
| string           |
| Stringable       |
| array            |
| Countable        |
| stdClass         |

```php
// string 'heart' contains at least 1 character
new MinLength('heart', 1);

// array with 3 elements has at least 2 elements
new MinLength([1, 2, 3], 2);

// \Countable object with 3 elements has at least 2 elements
new MinLength(new CustomCountable([1, 2, 3]), 2);
```

--page-nav--
