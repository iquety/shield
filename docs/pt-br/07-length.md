# Length

[◂ LessThanOrEqualTo](06-lessthanorequalto.md) | [Sumário da Documentação](indice.md) | [MaxLength ▸](07-maxlength.md)
-- | -- | --

O valor possui o tamanho esperado.

| Tipos verificáveis |
|:--                 |
| string             |
| Stringable         |
| array              |
| Countable          |
| stdClass           |

```php
// string 'coração' contém 7 caracteres
new Length('coração', 7);

// array com 3 elementos tem o tamanho 3
new Length([1, 2, 3], 3);

// objeto \Countable com 3 elementos tem o tamanho 3
new Length(new CustomCountable([1, 2, 3]), 3);
```

[◂ LessThanOrEqualTo](06-lessthanorequalto.md) | [Sumário da Documentação](indice.md) | [MaxLength ▸](07-maxlength.md)
-- | -- | --
