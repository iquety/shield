# IsMacAddress

--page-nav--

MAC address formats.

| Verifiable types |
|:--               |
| string           |
| Stringable       |

```php
// colon separated
new IsMacAddress('00:1A:2B:3C:4D:5E');

// hyphen separated
new IsMacAddress('00-1A-2B-3C-4D-5E');

// uppercase
new IsMacAddress('00:1A:2B:3C:4D:5E');

//lowercase
new IsMacAddress('00:1a:2b:3c:4d:5e');

// Stringable object
new IsMacAddress(new CustomStringable('00:1a:2b:3c:4d:5e'));
```

--page-nav--
