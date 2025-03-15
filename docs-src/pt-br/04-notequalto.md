# EqualTo

--page-nav--

Verifica se ambos os valores são diferentes.

```php
// textos diferentes
new NotEqualTo('Palavra', 'Palavrasss');

// tipo e conteúdo de objetos diferentes
new NotEqualTo(new ObjectOne(''), new ObjectOne('valor'));

// números diferentes
new NotEqualTo(44, 45);
new NotEqualTo(10.5, 10.6);

// arrays diferentes
new NotEqualTo(['one', 'two'], ['three', 'two']);

// outros valores diferentes
new NotEqualTo(null, true);
new NotEqualTo(true, null);
new NotEqualTo(false, 'x');
```

--page-nav--
