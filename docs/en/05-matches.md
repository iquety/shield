# Matches

[◂ EndsWith](05-endswith.md) | [Documentation Summary](index.md) | [NotContains ▸](05-notcontains.md)
-- | -- | --

The full value matches or contains a portion of the regular expression.

```php

// word contains the pattern
new Matches('Lionheart', '/ionh/');

// formatted text matches the pattern
new Matches('123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/');

// decimal number format matches the pattern
new Matches(123456.7891, '/(\d{6})\.(\d{4})/');

// integer format matches pattern
new Matches(1234567890, '/(\d{5})(\d{5})/');

// array contains an element that matches pattern
new Matches(['Heart', 'Hello World', 'Lion'], '/World/');

// nulls can also be checked
new Matches(null, '/null/');
new Matches(null, '/nu/');
```

## Limitations

**Warning**: decimal numbers with a trailing zero will not work due to a limitation of PHP's type correction, which will remove the trailing zeros

```php
new Matches(123456.7890, '/(\d{6})\.(\d{4})/');
```

[◂ EndsWith](05-endswith.md) | [Documentation Summary](index.md) | [NotContains ▸](05-notcontains.md)
-- | -- | --
