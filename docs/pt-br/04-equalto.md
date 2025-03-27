# EqualTo

[◂ Asserções](03-assertions.md) | [Sumário da Documentação](indice.md) | [EqualTo ▸](04-notequalto.md)
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
// textos iguais
new EqualTo('Palavra', 'Palavra');

// arrays com conteúdos iguais
new EqualTo(['one', 'two'], ['one', 'two']);

// objetos com tipos e conteúdos iguais
new EqualTo(new ObjectOne('acme'), new ObjectOne('acme'));

// numéricos iguais
new EqualTo(44, 44);
new EqualTo(4.5, 4.5);

// booleanos iguais
new EqualTo(true, true);
new EqualTo(false, false);

// nulos
new EqualTo(null, null);
```

[◂ Asserções](03-assertions.md) | [Sumário da Documentação](indice.md) | [EqualTo ▸](04-notequalto.md)
-- | -- | --
