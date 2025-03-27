# StartsWith

--page-nav--

O valor completo começa com o valor parcial.

| Tipo completo     | Tipo parcial                    |
|:--                |:--                              |
| string            | string                          |
| Stringable        | string                          |
| array             | string, int, float, true, false |
| ArrayAccess       | string, int, float, true, false |
| Iterator          | string, int, float, true, false |
| IteratorAggregate | string, int, float, true, false |
| stdClass          | string, int, float, true, false |

Argumentos com valores não suportados lançarão uma exceção do tipo `InvalidArgumentException`.

```php
// string começa com a palavra 'Meu'
new StartsWith('Meu texto', 'Meu');

// valor textual do objeto do tipo \Stringable começa com a palavra 'Meu'
new StartsWith(new CustomStringable('Meu texto'), 'Meu');

// primeiro elemento do Array é 'Meu'
new StartsWith(['Meu', 'texto'], 'Meu');

// primeiro elemento do objeto do tipo \ArrayAccess é 'Meu'
new Contains(new CustomArrayAccess(['Meu', 'texto']), 'Meu');

// primeiro elemento do objeto do tipo \Iterator é 'Meu'
new StartsWith(new ArrayIterator(['Meu', 'texto']), 'Meu');

// primeiro elemento do objeto do tipo \IteratorAggregate é 'Meu'
new StartsWith(new ArrayObject(['Meu', 'texto']), 'Meu');

// primeira propriedade do objeto \stdClass possui o valor 'Meu'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new StartsWith($stdObject, 'Meu');
```

--page-nav--
