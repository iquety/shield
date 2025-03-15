# Matches

--page-nav--

O valor completo corresponde ou contém um trecho da expressão regular.

```php

// palavra contém o padrão
new Matches('Coração de Leão', '/oraç/');

// formado texto corresponde ao padrão
new Matches('123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/');

// formato do número decimal corresponde ao padrão
new Matches(123456.7891, '/(\d{6})\.(\d{4})/');

// formato do número inteiro corresponde ao padrão
new Matches(1234567890, '/(\d{5})(\d{5})/');

// array contém um elemento que corresponde ao padrão
new Matches(['Coração', 'Hello World', 'Leão'], '/World/');

// nulos também podem ser verificados
new Matches(null, '/null/');
new Matches(null, '/nu/');
```

## Limitações

**Atenção:** números decimais com zero no final não funcionarão por uma limitação da correção de tipos do PHP, que removerá os zeros do final

```php
new Matches(123456.7890, '/(\d{6})\.(\d{4})/');
```

--page-nav--
