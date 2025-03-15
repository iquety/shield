# IsDateTime

[◂ IsDate](07-isdate.md) | [Sumário da Documentação](indice.md) | [IsTime ▸](07-istime.md)
-- | -- | --

Os formatos de data suportados são:

| Tipo                       | Formato                                          |
|:--                         |:--                                               |
| Formato ISO 8601           | aaaa-mm-dd *(ex.: 2024-12-31 23:59:59)*          |
| Formato ISO alternativo    | aaaa.mm.dd *(ex.: 2024.31.12 23:59:59)*          |
| Formato americano          | dd-mm-aaaa *(ex.: 12/31/2024 23:59:59)*          |
| Formato  com mês abreviado | dd-Mes-aaaa *(ex.: 31-Dec-2024 23:59:59)*        |
| Mês completo               | Mês dd, aaaa *(ex.: December 31, 2024 23:59:59)* |
| Data brasileira            | dd/mm/aaaa *(ex.: 12/31/2024 23:59:59)*          |

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
```

[◂ IsDate](07-isdate.md) | [Sumário da Documentação](indice.md) | [IsTime ▸](07-istime.md)
-- | -- | --
