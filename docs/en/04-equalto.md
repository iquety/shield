# EqualTo

[◂ Assertions](03-assertions.md) | [Documentation Summary](index.md) | [EqualTo ▸](04-notequalto.md)
-- | -- | --

Checks if both values ​​are equal.

```php
// equal texts
new EqualTo('Word', 'Word');

// equal object type and content
new EqualTo(new ObjectOne(''), new ObjectOne(''));

// equal numbers
new EqualTo(44, 44);
new EqualTo(4.5, 4.5);

// equal arrays
new EqualTo(['one', 'two'], ['one', 'two']);

// other equal values
new EqualTo(null, null);
new EqualTo(true, true);
new EqualTo(false, false);
```

[◂ Assertions](03-assertions.md) | [Documentation Summary](index.md) | [EqualTo ▸](04-notequalto.md)
-- | -- | --
