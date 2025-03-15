# IsDate

[◂ IsAmountTime](07-isamounttime.md) | [Documentation Summary](index.md) | [IsDateTime ▸](07-isdatetime.md)
-- | -- | --

The supported date formats are:

| Type                                   | Format                                    |
|:--                                     |:--                                        |
| ISO 8601 format                        | yyyy-mm-dd *(e.g. 2024-12-31)*            |
| Alternate ISO format                   | yyyy.mm.dd *(e.g. 2024.31.12)*            |
| American format                        | dd-mm-yyyy *(e.g. 12/31/2024)*            |
| American format with abbreviated month | dd-Month-yyyy *(e.g. 31-Dec-2024 )*       |
| Full month                             | Month dd, yyyy *(e.g. December 31, 2024)* |
| Brazilian date                         | dd/mm/yyyy *(e.g.: 12/31/2024)*           |

```php
// ISO 8601 format
new IsDate('2024-12-31');

// alternative ISO format
new IsDate('2024.12.31');

// American format
new IsDate('12/31/2024');

// American format with abbreviated month in full
new IsDate('31-Dec-2024');

// textual format with full month
new IsDate('December 31, 2024');

// usual Brazilian format
new IsDate('12/31/2024');
```

[◂ IsAmountTime](07-isamounttime.md) | [Documentation Summary](index.md) | [IsDateTime ▸](07-isdatetime.md)
-- | -- | --
