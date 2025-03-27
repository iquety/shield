# EqualTo

[◂ EqualTo](04-equalto.md) | [Documentation Summary](index.md) | [Contains ▸](05-contains.md)
-- | -- | --

Checks if both values ​​are equal.

Objects will be compared taking into account their type and content.

| Comparable types |
|:-- |
| string |
| array |
| object |
| integer |
| float |
| boolean |
| null |

```php
// different texts
new NotEqualTo('Word', 'Wordss');

// arrays with different content
new NotEqualTo(['one', 'two'], ['three', 'two']);

// objects with different type or content
new NotEqualTo(new ObjectOne(''), new ObjectTwo(''));

new NotEqualTo(new ObjectOne(''), new ObjectOne('value'));

// different numeric values
new NotEqualTo(44, 45); new NotEqualTo(10.5, 10.6);

// other different comparisons
new NotEqualTo(null, true);
new NotEqualTo(true, null);
new NotEqualTo(false, 'x');
new NotEqualTo(['one', 'two'], 123);
new NotEqualTo(new ObjectOne(''), 'text');
```

[◂ EqualTo](04-equalto.md) | [Documentation Summary](index.md) | [Contains ▸](05-contains.md)
-- | -- | --
