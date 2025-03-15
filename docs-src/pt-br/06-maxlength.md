# Length

--page-nav--

O valor possui o tamanho máximo esperado.

```php
// string 'coração' contém no máximo 7 caracteres
new MaxLength('coração', 7);

// inteiro 9 tem no máximo o valor 9
new MaxLength(9, 9);

// decimal 9.1 tem no máximo o valor 9.2
new MaxLength(9.1, 9.2);

// array com 3 elementos tem no máximo 3 elementos
new MaxLength([1, 2, 3], 3);

// objeto \Countable com 3 elementos tem no máximo 3 elementos
new MaxLength(new ArrayObject([1, 2, 3]), 3);
new MaxLength(new ArrayIterator([1, 2, 3]), 3);

// objeto do tipo \stdClass com 3 propriedades públicas tem no máximo 3 elementos
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new MaxLength($stdObject, 3);
```

--page-nav--
