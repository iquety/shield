# Contains

[◂ EqualTo](04-notequalto.md) | [Sumário da Documentação](indice.md) | [EndsWith ▸](05-endswith.md)
-- | -- | --

O valor completo contém o valor parcial.

```php
// string contém a palavra 'texto'
new Contains('Meu texto', 'texto');

// string contém o número 123
new Contains('123456', 123);

// número contém a string 12.3
new Contains(12.3456, '12.3');

// número contém o número 123
new Contains(123456, 123);

// Array contém o elemento 'texto'
new Contains(['Meu', 'texto'], 'texto');

// Objetos do tipo \Stringable contém a palavra 'texto'
new Contains(new Exception('Meu texto'), 'texto');

// Objetos do tipo \IteratorAggregate contém o elemento 'texto'
new Contains(new ArrayObject(['Meu', 'texto']), 'texto');

// Objetos do tipo \Iterator contém o elemento 'texto'
new Contains(new ArrayIterator(['Meu', 'texto']), 'texto');

// Objetos do tipo \stdClass contém uma propriedade pública com o valor 'texto'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new Contains($stdObject, 'texto');
```

[◂ EqualTo](04-notequalto.md) | [Sumário da Documentação](indice.md) | [EndsWith ▸](05-endswith.md)
-- | -- | --
