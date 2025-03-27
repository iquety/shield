# IsUrl

--page-nav--

Valid URL formats:

```php
// http         
new IsUrl('http://www.example.com');

// https        
new IsUrl('https://www.example.com');

// with path    
new IsUrl('http://www.example.com/path');

// with query   
new IsUrl('http://www.example.com/path?query=123');

// with fragment
new IsUrl('http://www.example.com/path#fragment');

// IP address
new IsUrl('http://192.168.1.1');

// localhost 
new IsUrl('http://localhost');

// subdomain 
new IsUrl('http://subdomain.example.com');

// port      
new IsUrl('http://www.example.com:8080');

// long TLD  
new IsUrl('http://www.example.museum');
```

--page-nav--
