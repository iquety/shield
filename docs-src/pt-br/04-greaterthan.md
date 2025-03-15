# GreaterThan

--page-nav--

O valor é maior do que o esperado.

```php
// string 'coração' contém mais de 6 caracteres
new GreaterThan('coração', 6);

// inteiro 9 é maior que 8
new GreaterThan(9, 8);

// decimal 9.1 é maior que 9
new GreaterThan(9.1, 9);

// decimal 9.9 é maior que 9.8
new GreaterThan(9.9, 9.8);

// array contém mais de 2 elementos
new GreaterThan([1, 2, 3], 2);

// objeto \Countable contém mais de 2 elementos
new GreaterThan(new ArrayObject([1, 2, 3]), 2);
new GreaterThan(new ArrayIterator([1, 2, 3]), 2);

// objeto do tipo \stdClass contém mais de 2 propriedades públicas
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new GreaterThan($stdObject, 2);
```

--page-nav--
