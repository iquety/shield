# MinLength

[◂ MaxLength](07-maxlength.md) | [Sumário da Documentação](indice.md) | [IsAmountTime ▸](08-isamounttime.md)
-- | -- | --

O valor possui o tamanho mínimo esperado.

| Tipos verificáveis |
|:--                 |
| string             |
| Stringable         |
| array              |
| Countable          |
| stdClass           |

```php
// string 'coração' contém no mínimo 1 caracteres
new MinLength('coração', 1);

// array com 3 elementos tem no mínimo 2 elementos
new MinLength([1, 2, 3], 2);

// objeto \Countable com 3 elementos tem no mínimo 2 elementos
new MinLength(new CustomCountable([1, 2, 3]), 2);
```

[◂ MaxLength](07-maxlength.md) | [Sumário da Documentação](indice.md) | [IsAmountTime ▸](08-isamounttime.md)
-- | -- | --
