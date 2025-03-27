# MaxLength

--page-nav--

O valor possui o tamanho máximo esperado.

| Tipos verificáveis |
|:--                 |
| string             |
| Stringable         |
| array              |
| Countable          |
| stdClass           |

```php
// string 'coração' contém no máximo 7 caracteres
new MaxLength('coração', 7);

// array com 3 elementos tem no máximo 3 elementos
new MaxLength([1, 2, 3], 3);

// objeto \Countable com 3 elementos tem no máximo 3 elementos
new MaxLength(new CustomCountable([1, 2, 3]), 3);
```

--page-nav--
