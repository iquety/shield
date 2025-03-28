# IsDate

[◂ IsAmountTime](08-isamounttime.md) | [Sumário da Documentação](indice.md) | [IsDateTime ▸](08-isdatetime.md)
-- | -- | --

Os formatos de data suportados.

| Nome                                | Formato                                 | Tipo               |
|:--                                  |:--                                      |:--                 |
| Formato ISO 8601                    | aaaa-mm-dd *(ex.: 2024-12-31)*          | string, Stringable |
| Formato ISO alternativo             | aaaa.mm.dd *(ex.: 2024.31.12)*          | string, Stringable |
| Formato americano                   | dd-mm-aaaa *(ex.: 12/31/2024)*          | string, Stringable |
| Formato americano com mês abreviado | dd-Mes-aaaa *(ex.: 31-Dec-2024 )*       | string, Stringable |
| Mês completo                        | Mês dd, aaaa *(ex.: December 31, 2024)* | string, Stringable |
| Data brasileira                     | dd/mm/aaaa *(ex.: 12/31/2024)*          | string, Stringable |

```php
// formato ISO 8601
new IsDate('2024-12-31');

// formato ISO alternativo
new IsDate('2024.12.31');

// formato americano
new IsDate('12/31/2024');

// formato americano com mês abreviado por extenso
new IsDate('31-Dec-2024');

// formato textual com mês completo
new IsDate('December 31, 2024');

// formato usual do Brasil
new IsDate('12/31/2024');

// objeto Stringable
new IsDate(new CustomStringable('12/31/2024'));
```

[◂ IsAmountTime](08-isamounttime.md) | [Sumário da Documentação](indice.md) | [IsDateTime ▸](08-isdatetime.md)
-- | -- | --
