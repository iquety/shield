# NotMatches

--page-nav--

O valor completo não corresponde ou não contém um trecho da expressão regular.

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
// texto não contém o padrão
new NotMatches('Coração de Leão', '/life/');
new NotMatches('123-456-7890', '/(\d{3})-(\d{3})-(\d{9})/');

// valor textual do objeto do tipo \Stringable não contém o padrão
new NotMatches(new CustomStringable('Coração'), '/life/');

// array não contém um elemento que corresponde ao padrão
new NotMatches(['Coração', 'Hello World', 'Leão'], '/life/');

// objeto do tipo \ArrayAccess não contém um elemento que corresponde ao padrão
new NotMatches(new CustomArrayAccess(['Hello World', 'Leão']), '/life/');

// objeto do tipo \Iterator não contém um elemento que corresponde ao padrão
new NotMatches(new ArrayIterator(['Hello World', 'Leão']), '/life/');

// objeto do tipo \IteratorAggregate não contém um elemento que corresponde ao padrão
new NotMatches(new ArrayObject(['Hello World', 'Leão']), '/life/');

// objeto do tipo \stdClass não contém uma propriedade
// com o valor correpondente ao padrão
$stdObject = new stdClass();
$stdObject->one = 'Hello World';
$stdObject->two = 'Leão';
new NotMatches($stdObject, '/life/');
```

--page-nav--
