# IsAmountTime

[◂ MinLength](07-minlength.md) | [Documentation Summary](index.md) | [IsDate ▸](08-isdate.md)
-- | -- | --

Hours, minutes and seconds format without 24-hour limit.

| Verifiable types |
|:--               |
| integer          |
| string           |
| Stringable       |

```php
// minimum hours allowed
new IsAmountTime('00:00:00');

// maximum hours allowed
new IsAmountTime('99:59:59');

// Stringable object
new IsAmountTime(new CustomStringable('99:59:59'));
```

[◂ MinLength](07-minlength.md) | [Documentation Summary](index.md) | [IsDate ▸](08-isdate.md)
-- | -- | --
