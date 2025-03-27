# NotContains

--page-nav--

O valor completo não contém o valor parcial.

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
// texto não contém a palavra 'legal'
new NotContains('Meu texto', 'legal');

// Objetos do tipo \Stringable não contém a palavra 'legal'
new NotContains(new Exception('Meu texto'), 'legal');

// Array não contém o elemento 'legal'
new NotContains(['Meu', 'texto'], 'legal');

// Objetos do tipo \ArrayAccess contém o elemento 'legal'
new NotContains(new CustomArrayAccess(['Meu', 'texto']), 'legal');

// Objetos do tipo \Iterator não contém o elemento 'legal'
new NotContains(new ArrayIterator(['Meu', 'texto']), 'legal');

// Objetos do tipo \IteratorAggregate não contém o elemento 'legal'
new NotContains(new ArrayObject(['Meu', 'texto']), 'legal');

// Objetos do tipo \stdClass não contém uma propriedade pública com o valor 'legal'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new NotContains($stdObject, 'legal');
```

--page-nav--
