# IsUrl

[◂ IsMacAddress](09-ismacaddress.md) | [Sumário da Documentação](indice.md) | [IsTime ▸](10-isbrphonenumber.md)
-- | -- | --

Formatos de URL válidos:

```php
// com protocolo http         
new IsUrl('http://www.exemplo.com');

// com protocolo https        
new IsUrl('https://www.exemplo.com');

// com caminho
new IsUrl('http://www.exemplo.com/caminho');

// com consulta
new IsUrl('http://www.exemplo.com/caminho?consulta=123');

// com fragmento
new IsUrl('http://www.exemplo.com/caminho#fragmento');

// com endereço IP
new IsUrl('http://192.168.1.1');

// localhost 
new IsUrl('http://localhost');

// com subdomínio
new IsUrl('http://subdominio.exemplo.com');

// com porta
new IsUrl('http://www.exemplo.com:8080');

// com sufixo TLD longo
new IsUrl('http://www.exemplo.museum');
```

[◂ IsMacAddress](09-ismacaddress.md) | [Sumário da Documentação](indice.md) | [IsTime ▸](10-isbrphonenumber.md)
-- | -- | --
