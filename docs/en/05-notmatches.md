# NotMatches

[◂ NotContains](05-notcontains.md) | [Documentation Summary](index.md) | [StartsWith ▸](05-startswith.md)
-- | -- | --

The full value does not match or does not contain a part of the regular expression.

```php
// word does not contain the pattern
new Matches('Lionheart', '/life/');

// formatted text does not match the pattern
new Matches('123-456-7890', '/(\d{3})-(\d{3})-(\d{9})/');

// decimal number format does not match the pattern
new Matches(123456.7891, '/(\d{6})\.(\d{9})/');

// integer format does not match pattern
new Matches(1234567890, '/(\d{5})(\d{9})/');

// array does not contain an element that matches pattern
new Matches(['Heart', 'Hello World', 'Lion'], '/Life/');

// nulls can also be checked
new Matches(null, '/nus/');
```

## Limitations

**Warning:** decimal numbers with a trailing zero will not work due to a limitation of PHP's type correction, which will remove the trailing zeros

```php
new Matches(123456.7890, '/(\d{6})\.(\d{9})/');
```

[◂ NotContains](05-notcontains.md) | [Documentation Summary](index.md) | [StartsWith ▸](05-startswith.md)
-- | -- | --
