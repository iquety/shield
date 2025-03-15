# LessThanOrEqualTo

--page-nav--

O valor é menor ou igual ao esperado.

```php
// string 'coração' contém 8 caracteres ou menos
new LessThanOrEqualTo('coração', 8);

// inteiro 8 é menor ou iqual a 9
new LessThanOrEqualTo(8, 9);

// decimal 9.1 é menor ou igual a 9.2
new LessThanOrEqualTo(9.1, 9.2);

// array com 3 elementos é menor ou igual a 4
new LessThanOrEqualTo([1, 2, 3], 4);

// objeto \Countable com 3 elementos é menor ou igual a 4
new LessThanOrEqualTo(new ArrayObject([1, 2, 3]), 4);
new LessThanOrEqualTo(new ArrayIterator([1, 2, 3]), 4);

// objeto do tipo \stdClass com 3 propriedades públicas é menor ou igual a 4
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new LessThanOrEqualTo($stdObject, 4);
```

--page-nav--
