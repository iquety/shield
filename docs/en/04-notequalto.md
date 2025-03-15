# EqualTo

[◂ EqualTo](04-equalto.md) | [Documentation Summary](index.md) | [Contains ▸](05-contains.md)
-- | -- | --

Check if both values ​​are different.

```php
// different texts
new NotEqualTo('Word', 'Wordss');

// different object type and content
new NotEqualTo(new ObjectOne(''), new ObjectOne('value'));

// different numbers
new NotEqualTo(44, 45);
new NotEqualTo(10.5, 10.6);

// different arrays
new NotEqualTo(['one', 'two'], ['three', 'two']);

// other different values
new NotEqualTo(null, true);
new NotEqualTo(true, null);
new NotEqualTo(false, 'x');
```

[◂ EqualTo](04-equalto.md) | [Documentation Summary](index.md) | [Contains ▸](05-contains.md)
-- | -- | --
