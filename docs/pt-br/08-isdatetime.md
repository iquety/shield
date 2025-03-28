# IsDateTime

[◂ IsDate](08-isdate.md) | [Sumário da Documentação](indice.md) | [IsTime ▸](08-istime.md)
-- | -- | --

Os formatos de data suportados são:

| Nome                       | Formato                                          | Tipo               |
|:--                         |:--                                               | :--                |
| Formato ISO 8601           | aaaa-mm-dd *(ex.: 2024-12-31 23:59:59)*          | string, Stringable |
| Formato ISO alternativo    | aaaa.mm.dd *(ex.: 2024.31.12 23:59:59)*          | string, Stringable |
| Formato americano          | dd-mm-aaaa *(ex.: 12/31/2024 23:59:59)*          | string, Stringable |
| Formato  com mês abreviado | dd-Mes-aaaa *(ex.: 31-Dec-2024 23:59:59)*        | string, Stringable |
| Mês completo               | Mês dd, aaaa *(ex.: December 31, 2024 23:59:59)* | string, Stringable |
| Data brasileira            | dd/mm/aaaa *(ex.: 12/31/2024 23:59:59)*          | string, Stringable |

```php
// formato ISO 8601
new IsDateTime('2024-12-31 23:59:59');

// formato ISO alternativo
new IsDateTime('2024.12.31 23:59:59');

// formato americano
new IsDateTime('12/31/2024 23:59:59');

// formato americano com mês abreviado por extenso
new IsDateTime('31-Dec-2024 23:59:59');

// formato textual com mês completo
new IsDateTime('December 31, 2024 23:59:59');

// formato usual do Brasil
new IsDateTime('12/31/2024 23:59:59');

// objeto Stringable
new IsDateTime(new CustomStringable('12/31/2024 23:59:59'));
```

[◂ IsDate](08-isdate.md) | [Sumário da Documentação](indice.md) | [IsTime ▸](08-istime.md)
-- | -- | --
