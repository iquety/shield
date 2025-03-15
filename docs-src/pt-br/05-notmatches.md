# NotMatches

--page-nav--

O valor completo não corresponde ou não contém um trecho da expressão regular.

```php
// palavra não contém o padrão
new Matches('Coração de Leão', '/life/');

// formado texto não corresponde ao padrão
new Matches('123-456-7890', '/(\d{3})-(\d{3})-(\d{9})/');

// formato do número decimal não corresponde ao padrão
new Matches(123456.7891, '/(\d{6})\.(\d{9})/');

// formato do número inteiro não corresponde ao padrão
new Matches(1234567890, '/(\d{5})(\d{9})/');

// array não contém um elemento que corresponde ao padrão
new Matches(['Coração', 'Hello World', 'Leão'], '/Life/');

// nulos também podem ser verificados
new Matches(null, '/nus/');
```

## Limitações

**Atenção:** números decimais com zero no final não funcionarão por uma limitação da correção de tipos do PHP, que removerá os zeros do final

```php
new Matches(123456.7890, '/(\d{6})\.(\d{9})/');
```

--page-nav--
