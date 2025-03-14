# EqualTo

[◂ Contains](04-notcontains.md) | [Sumário da Documentação](indice.md) | [NotMatches ▸](04-notmatches.md)
-- | -- | --

Verifica se ambos os valores são diferentes.

```php
// textos diferentes
new EqualTo('Palavra', 'Palavrasss');

// tipo e conteúdo de objetos diferentes
new EqualTo(new ObjectOne(''), new ObjectOne('valor'));

// números diferentes
new EqualTo(44, 45);
new EqualTo(10.5, 10.6);

// arrays diferentes
new EqualTo(['one', 'two'], ['three', 'two']);

// outros valores diferentes
new EqualTo(null, true);
new EqualTo(true, null);
new EqualTo(false, 'x');
```

[◂ Contains](04-notcontains.md) | [Sumário da Documentação](indice.md) | [NotMatches ▸](04-notmatches.md)
-- | -- | --
