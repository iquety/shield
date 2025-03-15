# EndsWith

[◂ Contains](05-contains.md) | [Sumário da Documentação](indice.md) | [Matches ▸](05-matches.md)
-- | -- | --

O valor completo termina com o valor parcial.

```php
// string terminam com a palavra 'texto'
new EndsWith('Meu texto', 'texto');

// string termina com o número 456
new EndsWith('123456', 456);

// número termina com a string 456
new EndsWith(12.3456, '456');

// número termina com o número 456
new EndsWith(123456, 456);

// último elemento do Array é 'texto'
new EndsWith(['Meu', 'texto'], 'texto');

// valor textual do objeto do tipo \Stringable termina com a palavra 'texto'
new EndsWith(new MeuStringable('Meu texto'), 'texto');

// último elemento do objeto do tipo \IteratorAggregate é 'texto'
new EndsWith(new ArrayObject(['Meu', 'texto']), 'texto');

// último elemento do objeto do tipo \Iterator é 'texto'
new EndsWith(new ArrayIterator(['Meu', 'texto']), 'texto');

// última propriedade do objeto \stdClass possui o valor 'texto'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new EndsWith($stdObject, 'texto');
```

[◂ Contains](05-contains.md) | [Sumário da Documentação](indice.md) | [Matches ▸](05-matches.md)
-- | -- | --
