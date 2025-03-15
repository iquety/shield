# Length

--page-nav--

O valor possui o tamanho mínimo esperado.

```php
// string 'coração' contém no mínimo 1 caracteres
new MinLength('coração', 1);

// inteiro 9 tem no mínimo o valor 9
new MinLength(9, 9);

// decimal 9.1 tem no mínimo o valor 9
new MinLength(9.1, 9);

// array com 3 elementos tem no mínimo 2 elementos
new MinLength([1, 2, 3], 2);

// objeto \Countable com 3 elementos tem no mínimo 2 elementos
new MinLength(new ArrayObject([1, 2, 3]), 2);
new MinLength(new ArrayIterator([1, 2, 3]), 2);

// objeto do tipo \stdClass com 3 propriedades públicas tem no mínimo 2 elementos
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new MinLength($stdObject, 2);
```

--page-nav--
