# IsTime

--page-nav--

Formato de horas, minutos e segundos com limite de 24 horas:

| Tipos verificáveis |
|:--                 |
| string             |
| Stringable         |

```php
// mínimo de horas permidido
new IsTime('00:00:00');

// máximo de horas permitido
new IsTime('23:59:59');

// objeto Stringable
new IsTime(new CustomStringable('23:59:59'));
```

--page-nav--
