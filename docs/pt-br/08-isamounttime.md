# IsAmountTime

[◂ MinLength](07-minlength.md) | [Sumário da Documentação](indice.md) | [IsDate ▸](08-isdate.md)
-- | -- | --

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

[◂ MinLength](07-minlength.md) | [Sumário da Documentação](indice.md) | [IsDate ▸](08-isdate.md)
-- | -- | --
