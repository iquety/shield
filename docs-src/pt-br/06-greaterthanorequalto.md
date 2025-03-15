# GreaterThanOrEqualTo

--page-nav--

O valor é maior ou igual do que o esperado.

```php
// string 'coração' contém 7 caracteres ou mais
new GreaterThanOrEqualTo('coração', 7);

// inteiro 9 é maior ou igual a 8
new GreaterThanOrEqualTo(9, 8);

// decimal 9.1 é maior ou igual a 9
new GreaterThanOrEqualTo(9.1, 9);

// decimal 9.9 é maior ou igual a 9.8
new GreaterThanOrEqualTo(9.9, 9.8);

// array contém 2 elementos ou mais
new GreaterThanOrEqualTo([1, 2, 3], 2);

// objeto \Countable contém 2 elementos ou mais
new GreaterThanOrEqualTo(new ArrayObject([1, 2, 3]), 2);
new GreaterThanOrEqualTo(new ArrayIterator([1, 2, 3]), 2);

// objeto do tipo \stdClass contém 2 propriedades públicas ou mais
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new GreaterThanOrEqualTo($stdObject, 2);
```

--page-nav--
