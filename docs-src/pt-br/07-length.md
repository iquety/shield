# Length

--page-nav--

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

// objeto do tipo \stdClass com 3 propriedades públicas tem o tamanho 3
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new Length($stdObject, 3);
```

--page-nav--
