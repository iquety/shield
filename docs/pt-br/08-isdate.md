# IsDate

[◂ IsAmountTime](08-isamounttime.md) | [Sumário da Documentação](indice.md) | [IsDateTime ▸](08-isdatetime.md)
-- | -- | --

Os formatos de data suportados são:

| Tipo                                | Formato                                 |
|:--                                  |:--                                      |
| Formato ISO 8601                    | aaaa-mm-dd *(ex.: 2024-12-31)*          |
| Formato ISO alternativo             | aaaa.mm.dd *(ex.: 2024.31.12)*          |
| Formato americano                   | dd-mm-aaaa *(ex.: 12/31/2024)*          |
| Formato americano com mês abreviado | dd-Mes-aaaa *(ex.: 31-Dec-2024 )*       |
| Mês completo                        | Mês dd, aaaa *(ex.: December 31, 2024)* |
| Data brasileira                     | dd/mm/aaaa *(ex.: 12/31/2024)*          |

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
```

[◂ IsAmountTime](08-isamounttime.md) | [Sumário da Documentação](indice.md) | [IsDateTime ▸](08-isdatetime.md)
-- | -- | --
