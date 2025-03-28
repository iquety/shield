# IsDate

--page-nav--

The supported date formats.

| Name                                   | Format                                    | Type               | 
|:--                                     |:--                                        | :--                |
| ISO 8601 format                        | yyyy-mm-dd *(e.g. 2024-12-31)*            | string, Stringable |
| Alternate ISO format                   | yyyy.mm.dd *(e.g. 2024.31.12)*            | string, Stringable |
| American format                        | dd-mm-yyyy *(e.g. 12/31/2024)*            | string, Stringable |
| American format with abbreviated month | dd-Month-yyyy *(e.g. 31-Dec-2024 )*       | string, Stringable |
| Full month                             | Month dd, yyyy *(e.g. December 31, 2024)* | string, Stringable |
| Brazilian date                         | dd/mm/yyyy *(e.g.: 12/31/2024)*           | string, Stringable |

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

// Stringable object
new IsDate(new CustomStringable('12/31/2024'));
```

--page-nav--
