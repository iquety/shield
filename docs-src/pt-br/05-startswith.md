# StartsWith

--page-nav--

O valor completo começa com o valor parcial.

```php
// string começa com a palavra 'Meu'
new StartsWith('Meu texto', 'Meu');

// string começa com o número 123
new StartsWith('123456', 123);

// número começa com a string 12.3
new StartsWith(12.3456, '12.3');

// número começa com o número 123
new StartsWith(123456, 123);

// primeiro elemento do Array é 'texto'
new StartsWith(['Meu', 'texto'], 'Meu');

// valor textual do objeto do tipo \Stringable começa com a palavra 'Meu'
new StartsWith(new MeuStringable('Meu texto'), 'Meu');

// primeiro elemento do objeto do tipo \IteratorAggregate é 'Meu'
new StartsWith(new ArrayObject(['Meu', 'texto']), 'Meu');

// primeiro elemento do objeto do tipo \Iterator é 'Meu'
new StartsWith(new ArrayIterator(['Meu', 'texto']), 'Meu');

// última propriedade do objeto \stdClass possui o valor 'Meu'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new StartsWith($stdObject, 'Meu');
```

--page-nav--
