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

// objeto do tipo \stdClass com 3 propriedades públicas tem no máximo 3 elementos
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new MaxLength($stdObject, 3);
```

--page-nav--
