# EndsWith

[◂ Contains](05-contains.md) | [Sumário da Documentação](indice.md) | [Matches ▸](05-matches.md)
-- | -- | --

O valor completo termina com o valor parcial.

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
// string terminam com a palavra 'texto'
new EndsWith('Meu texto', 'texto');

// valor textual do objeto do tipo \Stringable termina com a palavra 'texto'
new EndsWith(new CustomStringable('Meu texto'), 'texto');

// último elemento do Array é 'texto'
new EndsWith(['Meu', 'texto'], 'texto');

// último elemento do objeto do tipo \ArrayAccess é 'texto'
new Contains(new CustomArrayAccess(['Meu', 'texto']), 'texto');

// último elemento do objeto do tipo \Iterator é 'texto'
new EndsWith(new ArrayIterator(['Meu', 'texto']), 'texto');

// último elemento do objeto do tipo \IteratorAggregate é 'texto'
new EndsWith(new ArrayObject(['Meu', 'texto']), 'texto');

// última propriedade do objeto \stdClass possui o valor 'texto'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new EndsWith($stdObject, 'texto');
```

[◂ Contains](05-contains.md) | [Sumário da Documentação](indice.md) | [Matches ▸](05-matches.md)
-- | -- | --
