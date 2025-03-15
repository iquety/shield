# EqualTo

[◂ Asserções](03-assertions.md) | [Sumário da Documentação](indice.md) | [EqualTo ▸](04-notequalto.md)
-- | -- | --

Verifica se ambos os valores são iguais.

```php
// textos  iguais
new EqualTo('Palavra', 'Palavra');

// tipo e conteúdo de objetos iguais
new EqualTo(new ObjectOne(''), new ObjectOne(''));

// números iguais
new EqualTo(44, 44);
new EqualTo(4.5, 4.5);

// arrays iguais
new EqualTo(['one', 'two'], ['one', 'two']);

// outros valores iguais
new EqualTo(null, null);
new EqualTo(true, true);
new EqualTo(false, false);
```

[◂ Asserções](03-assertions.md) | [Sumário da Documentação](indice.md) | [EqualTo ▸](04-notequalto.md)
-- | -- | --
