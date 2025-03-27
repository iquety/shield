# Contains

--page-nav--

O valor completo contém o valor parcial.

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
// string contém a palavra 'texto'
new Contains('Meu texto', 'texto');

// Objetos do tipo \Stringable contém a palavra 'texto'
new Contains(new Exception('Meu texto'), 'texto');

// Array contém o elemento 'texto'
new Contains(['Meu', 'texto'], 'texto');

// Objetos do tipo \ArrayAccess contém o elemento 'texto'
new Contains(new CustomArrayAccess(['Meu', 'texto']), 'texto');

// Objetos do tipo \Iterator contém o elemento 'texto'
new Contains(new ArrayIterator(['Meu', 'texto']), 'texto');

// Objetos do tipo \IteratorAggregate contém o elemento 'texto'
new Contains(new ArrayObject(['Meu', 'texto']), 'texto');

// Objetos do tipo \stdClass contém uma propriedade pública com o valor 'texto'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new Contains($stdObject, 'texto');
```

--page-nav--
