# IsMacAddress

[◂ IsIp](09-isip.md) | [Sumário da Documentação](indice.md) | [IsUrl ▸](09-isurl.md)
-- | -- | --

Formatos de endereços MAC.

| Tipos verificáveis |
|:--                 |
| string             |
| Stringable         |

```php
// separado por dois pontos
new IsMacAddress('00:1A:2B:3C:4D:5E');

// separado por hífen
new IsMacAddress('00-1A-2B-3C-4D-5E');

// em caixa alta
new IsMacAddress('00:1A:2B:3C:4D:5E');

// em caixa baixa
new IsMacAddress('00:1a:2b:3c:4d:5e');

// objeto Stringable
new IsMacAddress(new CustomStringable('00:1a:2b:3c:4d:5e'));
```

[◂ IsIp](09-isip.md) | [Sumário da Documentação](indice.md) | [IsUrl ▸](09-isurl.md)
-- | -- | --
