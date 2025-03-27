# Matches

--page-nav--

O valor completo corresponde ou contém um trecho da expressão regular.

| Tipo completo                        |
|:--                                   |
| string                               |
| Stringable                           |
| array com valores string             |
| ArrayAccess com valores string       |
| Iterator com valores string          |
| IteratorAggregate com valores string |
| stdClass com valores string          |

Argumentos com valores não suportados lançarão uma exceção do tipo `InvalidArgumentException`.

```php

// texto contém o padrão
new Matches('Coração de Leão', '/oraç/');
new Matches('123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/');

// valor textual do objeto do tipo \Stringable contém o padrão
new Matches(new CustomStringable('Coração'), '/oraç/');

// array contém um elemento que corresponde ao padrão
new Matches(['Coração', 'Hello World', 'Leão'], '/World/');

// objeto do tipo \ArrayAccess contém um elemento que corresponde ao padrão
new Matches(new CustomArrayAccess(['Hello World', 'Leão']), '/World/');

// objeto do tipo \Iterator contém um elemento que corresponde ao padrão
new Matches(new ArrayIterator(['Hello World', 'Leão']), '/World/');

// objeto do tipo \IteratorAggregate contém um elemento que corresponde ao padrão
new Matches(new ArrayObject(['Hello World', 'Leão']), '/World/');

// objeto do tipo \stdClass contém uma propriedade
// com o valor correpondente ao padrão
$stdObject = new stdClass();
$stdObject->one = 'Hello World';
$stdObject->two = 'Leão';
new Matches($stdObject, '/World/');
```

--page-nav--
