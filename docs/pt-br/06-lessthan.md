# LessThan

[◂ Length](06-length.md) | [Sumário da Documentação](indice.md) | [LessThanOrEqualTo ▸](06-lessthanorequalto.md)
-- | -- | --

O valor é menor que o esperado.

```php
// string 'coração' contém menos de 8 caracteres
new LessThan('coração', 8);

// inteiro 8 é menor que 9
new LessThan(8, 9);

// decimal 9.1 é menor que 9.2
new LessThan(9.1, 9.2);

// array com 3 elementos é menor que 4
new LessThan([1, 2, 3], 4);

// objeto \Countable com 3 elementos é menor que 4
new LessThan(new ArrayObject([1, 2, 3]), 4);
new LessThan(new ArrayIterator([1, 2, 3]), 4);

// objeto do tipo \stdClass com 3 propriedades públicas é menor que 4
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new LessThan($stdObject, 4);
```

[◂ Length](06-length.md) | [Sumário da Documentação](indice.md) | [LessThanOrEqualTo ▸](06-lessthanorequalto.md)
-- | -- | --
