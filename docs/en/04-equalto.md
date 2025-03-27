# EqualTo

[◂ Assertions](03-assertions.md) | [Documentation Summary](index.md) | [EqualTo ▸](04-notequalto.md)
-- | -- | --

Checks if both values ​​are equal.

Objects will be compared taking into account their type and content.

| Comparable types  |
|:--                |
| string            |
| array             |
| object            |
| integer           |
| float             |
| boolean           |
| null              |

```php
// equal texts
new EqualTo('Word', 'Word');

// arrays with equal content
new EqualTo(['one', 'two'], ['one', 'two']);

// objects with equal types and content
new EqualTo(new ObjectOne('acme'), new ObjectOne('acme'));

// equal numeric values
new EqualTo(44, 44);
new EqualTo(4.5, 4.5);

// equal boolean values
new EqualTo(true, true);
new EqualTo(false, false);

// nulls
new EqualTo(null, null);
```

[◂ Assertions](03-assertions.md) | [Documentation Summary](index.md) | [EqualTo ▸](04-notequalto.md)
-- | -- | --
