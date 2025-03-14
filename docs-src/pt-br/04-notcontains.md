# Contains

--page-nav--

O valor completo não contém o valor parcial.

```php
// string não contém a palavra 'legal'
new Contains('Meu texto', 'legal');

// string não contém o número 777
new Contains('123456', 777);

// número não contém a string 77.3
new Contains(12.3456, '77.3');

// número não contém o número 777
new Contains(123456, 777);

// Array não contém o elemento 'legal'
new Contains(['Meu', 'texto'], 'legal');

// Objetos do tipo \Stringable não contém a palavra 'legal'
new Contains(new Exception('Meu texto'), 'legal');

// Objetos do tipo \IteratorAggregate não contém o elemento 'legal'
new Contains(new ArrayObject(['Meu', 'texto']), 'legal');

// Objetos do tipo \Iterator não contém o elemento 'legal'
new Contains(new ArrayIterator(['Meu', 'texto']), 'legal');

// Objetos do tipo \stdClass não contém uma propriedade pública com o valor 'legal'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new Contains($stdObject, 'texto');
```

--page-nav--
