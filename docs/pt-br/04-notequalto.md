# EqualTo

[◂ EqualTo](04-equalto.md) | [Sumário da Documentação](indice.md) | [Contains ▸](05-contains.md)
-- | -- | --

Verifica se ambos os valores são iguais.

Objetos serão comparados levando em consideração seu tipo e seu conteúdo.

| Tipos comparáveis |
|:--                |
| string            |
| array             |
| object            |
| integer           |
| float             |
| boolean           |
| null              |

```php
// textos diferentes
new NotEqualTo('Palavra', 'Palavrasss');

// arrays com conteúdos diferentes
new NotEqualTo(['one', 'two'], ['three', 'two']);

// objetos com tipo ou conteúdo diferentes
new NotEqualTo(new ObjectOne(''), new ObjectTwo(''));
new NotEqualTo(new ObjectOne(''), new ObjectOne('valor'));

// numéricos diferentes
new NotEqualTo(44, 45);
new NotEqualTo(10.5, 10.6);

// outras comparações diferentes
new NotEqualTo(null, true);
new NotEqualTo(true, null);
new NotEqualTo(false, 'x');
new NotEqualTo(['one', 'two'], 123);
new NotEqualTo(new ObjectOne(''), 'texto');
```

[◂ EqualTo](04-equalto.md) | [Sumário da Documentação](indice.md) | [Contains ▸](05-contains.md)
-- | -- | --
