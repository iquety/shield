# IsIp

[◂ IsTime](08-istime.md) | [Sumário da Documentação](indice.md) | [IsMacAddress ▸](09-ismacaddress.md)
-- | -- | --

Formatos de IP.

| Tipos verificáveis |
|:--                 |
| string             |
| Stringable         |

```php
// ipv4
new IsIp('192.168.1.1');

// ipv4 loopback
new IsIp('127.0.0.1');

// ipv4 broadcast'   
new IsIp('255.255.255.255');

// ipv6'             
new IsIp('2001:0db8:85a3:0000:0000:8a2e:0370:7334');

// ipv6 comprimido'  
new IsIp('2001:db8:85a3::8a2e:370:7334');

// ipv6 loopback'    
new IsIp('::1');

// ipv6 não especificado' 
new IsIp('::');

// objeto Stringable
new IsIp(new CustomStringable('192.168.1.1'));
```

[◂ IsTime](08-istime.md) | [Sumário da Documentação](indice.md) | [IsMacAddress ▸](09-ismacaddress.md)
-- | -- | --
