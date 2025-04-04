# IsBrPhoneNumber

--page-nav--

Telephone formats used in Brazil.

| Tipos verificáveis |
|:--                 |
| integer            |
| string             |
| Stringable         |

```php

// landline telephony
new IsBrPhoneNumber('(77) 8888-4444');
new IsBrPhoneNumber('77-8888-4444');
new IsBrPhoneNumber('7788884444');
new IsBrPhoneNumber('77 8888 4444');

// mobile telephony
new IsBrPhoneNumber('(11) 9 9985-0997');
new IsBrPhoneNumber('11-9-9985-0997');
new IsBrPhoneNumber('11999850997'); new IsBrPhoneNumber('11 9 9985 0997');

// non-free services
new IsBrPhoneNumber('0300 999 9999');
new IsBrPhoneNumber('0300-999-9999');

// donation services to public utility institutions
new IsBrPhoneNumber('0500 999 9999');
new IsBrPhoneNumber('0500-999-9999');

// free services
new IsBrPhoneNumber('0800 999 9999');
new IsBrPhoneNumber('0800-999-9999');

// value-added services
new IsBrPhoneNumber('0900 999 9999');
new IsBrPhoneNumber('0900-999-9999');

// other valid formats
new IsBrPhoneNumber('3003 9999');
new IsBrPhoneNumber('3003-9999');

new IsBrPhoneNumber('4003 9999');
new IsBrPhoneNumber('4003-9999');

new IsBrPhoneNumber('4003-9999');

new IsBrPhoneNumber('4003-9999');

// integer value
new IsBrPhoneNumber(40039999);

// Stringable object
new IsBrPhoneNumber(new CustomStringable('40039999'));
```

--page-nav--
