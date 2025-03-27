# MinLength

--page-nav--

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

// objeto do tipo \stdClass com 3 propriedades públicas tem no mínimo 2 elementos
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new MinLength($stdObject, 2);
```

--page-nav--
