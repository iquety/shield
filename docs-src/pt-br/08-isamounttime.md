# IsAmountTime

--page-nav--

Formato de horas, minutos e segundos sem limite de 24 horas:

| Tipos verificáveis |
|:--                 |
| string             |
| Stringable         |

```php
// mínimo de horas permidido
new IsAmountTime('00:00:00');

// máximo de horas permitido
new IsAmountTime('99:59:59');

// objeto Stringable
new IsAmountTime(new CustomStringable('99:59:59'));
```

--page-nav--
