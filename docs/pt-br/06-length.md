# Length

[◂ GreaterThanOrEqualTo](06-greaterthanorequalto.md) | [Sumário da Documentação](indice.md) | [LessThan ▸](06-lessthan.md)
-- | -- | --

O valor possui o tamanho esperado.

```php
// string 'coração' contém 7 caracteres
new Length('coração', 7);

// inteiro 9 tem o tamanho 9
new Length(9, 9);

// decimal 9.1 tem o tamanho 9.1
new Length(9.1, 9.1);

// array com 3 elementos tem o tamanho 3
new Length([1, 2, 3], 3);

// objeto \Countable com 3 elementos tem o tamanho 3
new Length(new ArrayObject([1, 2, 3]), 3);
new Length(new ArrayIterator([1, 2, 3]), 3);

// objeto do tipo \stdClass com 3 propriedades públicas tem o tamanho 3
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
$stdObject->three = 'Legal';
new Length($stdObject, 3);
```

[◂ GreaterThanOrEqualTo](06-greaterthanorequalto.md) | [Sumário da Documentação](indice.md) | [LessThan ▸](06-lessthan.md)
-- | -- | --
