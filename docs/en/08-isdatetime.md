# IsDateTime

[◂ IsDate](08-isdate.md) | [Documentation Summary](index.md) | [IsTime ▸](08-istime.md)
-- | -- | --

The supported date formats.

| Name                     | Format                                              | Type               |
|:--                       |:--                                                  | :--                |
| ISO 8601 format          | yyyy-mm-dd *(e.g. 2024-12-31 23:59:59)*             | string, Stringable |
| Alternate ISO format     | yyyy.mm.dd *(e.g. 2024.31.12 23:59:59)*             | string, Stringable |
| US format                | dd-mm-yyyy *(e.g. 12/31/2024 23:59:59)*             | string, Stringable |
| Abbreviated month format | dd-Month-yyyy *(e.g. 31-Dec-2024 23:59:59)*         | string, Stringable |
| Full month               | Month dd, yyyy *(e.g.: December 31, 2024 23:59:59)* | string, Stringable |
| Brazilian date           | dd/mm/yyyy *(e.g.: 12/31/2024 23:59:59)*            | string, Stringable |

```php
// ISO 8601 format
new IsDateTime('2024-12-31 23:59:59');

// alternative ISO format
new IsDateTime('2024.12.31 23:59:59');

// American format
new IsDateTime('12/31/2024 23:59:59');

// American format with abbreviated month in full
new IsDateTime('31-Dec-2024 23:59:59');

// text format with full month
new IsDateTime('December 31, 2024 23:59:59');

// usual Brazilian format
new IsDateTime('12/31/2024 23:59:59');

// Stringable object
new IsDateTime(new CustomStringable('12/31/2024 23:59:59'));
```

[◂ IsDate](08-isdate.md) | [Documentation Summary](index.md) | [IsTime ▸](08-istime.md)
-- | -- | --
