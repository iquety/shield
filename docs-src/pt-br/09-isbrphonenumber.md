# IsTime

--page-nav--

Formatos de telefones utilizados no Brasil:

```php

// telefonia fixa
new IsBrPhoneNumber('(77) 8888-4444');
new IsBrPhoneNumber('77-8888-4444');
new IsBrPhoneNumber('7788884444');
new IsBrPhoneNumber('77 8888 4444');

// telefonia móvel
new IsBrPhoneNumber('(11) 9 9985-0997');
new IsBrPhoneNumber('11-9-9985-0997');
new IsBrPhoneNumber('11999850997');
new IsBrPhoneNumber('11 9 9985 0997');

// serviços não gratuitos
new IsBrPhoneNumber('0300 999 9999');
new IsBrPhoneNumber('0300-999-9999');

// serviços de doação a instituições de utilidade pública
new IsBrPhoneNumber('0500 999 9999');
new IsBrPhoneNumber('0500-999-9999');

// serviços gratuitos
new IsBrPhoneNumber('0800 999 9999');
new IsBrPhoneNumber('0800-999-9999');

// serviços de valor adicionado
new IsBrPhoneNumber('0900 999 9999');
new IsBrPhoneNumber('0900-999-9999');

// outros formatos válidos
new IsBrPhoneNumber('3003 9999');
new IsBrPhoneNumber('3003-9999');

new IsBrPhoneNumber('4003 9999');
new IsBrPhoneNumber('4003-9999');

new IsBrPhoneNumber('4003 9999');
new IsBrPhoneNumber('4003-9999');
```

--page-nav--
