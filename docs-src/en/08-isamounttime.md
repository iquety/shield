# IsAmountTime

--page-nav--

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

--page-nav--
