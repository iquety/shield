# MinLength

[◂ MaxLength](07-maxlength.md) | [Documentation Summary](index.md) | [IsAmountTime ▸](08-isamounttime.md)
-- | -- | --

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

[◂ MaxLength](07-maxlength.md) | [Documentation Summary](index.md) | [IsAmountTime ▸](08-isamounttime.md)
-- | -- | --
