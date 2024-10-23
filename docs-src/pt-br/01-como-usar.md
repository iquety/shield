# Como usar

--page-nav--

## O que é uma asserção

Em computação, asserção (assertion) é uma verificação com o objetivo de certificar
que uma determinada condição imposta pelo desenvolvedor seja verdadeira.

O uso de asserções é muito útil, principalmente na validação de valores, como 
argumentos de métodos ou entradas do usuário.

## Uso básico

As asserções são registradas através da biblioteca `Shield`.

```php

function saveUser(string $name, string $email, string $password): void
{
    $instance = new Shield();

    $instance->assert($assertionOne)->identity('one');
}
```

--page-nav--
