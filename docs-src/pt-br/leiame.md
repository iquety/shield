# Iquety Shield

[![GitHub Release](https://img.shields.io/github/release/iquety/shield.svg)](https://github.com/iquety/shield/releases/latest)
![PHP Version](https://img.shields.io/badge/php-%5E8.3-blue)
![License](https://img.shields.io/badge/license-MIT-blue)
[![Codacy Grade](https://app.codacy.com/project/badge/Grade/5097e82662f54f52a8ae5bb3a4b54e45)](https://www.codacy.com/gh/iquety/security/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=iquety/security&amp;utm_campaign=Badge_Grade)
[![Codacy Coverage](https://app.codacy.com/project/badge/Coverage/5097e82662f54f52a8ae5bb3a4b54e45)](https://www.codacy.com/gh/iquety/security/dashboard?utm_source=github.com&utm_medium=referral&utm_content=iquety/security&utm_campaign=Badge_Coverage)

[English](../../readme.md) | [Português](leiame.md)
-- | --

## Sinopse

```bash
composer require iquety/shield
```

Esta é uma biblioteca oferece um conjunto de Asserções para valores e expressões.

Em computação, asserção (assertion) é uma verificação com o objetivo de certificar
que uma determinada condição imposta pelo desenvolvedor seja verdadeira.

O uso de asserções é muito útil, principalmente na validação de valores 
provenientes de argumentos de métodos ou de entradas do usuário.

## Como usar

As asserções são registradas através da biblioteca `Shield`.

Pode ser usado na forma convencional:

```php

$name = 'Ricardo';

$instance = new Shield();

// 'Ricardo' possui 4 caracteres ou menos?
$instance->assert(new MaxLength($name, 4)); 

// ou todas as asserções conferem, 
// ou uma exceção é lançada
$instance->validOrThrow();
```

ou na forma fluente:

```php

$name = 'Ricardo';

$instance = (new Shield())
    ->assert(new MaxLength($name, 4))
    ->validOrThrow();
```

No exemplo acima, uma exceção do tipo `Exception` será lançada com a mensagem 
*"The value was not successfully asserted"*.

Para informações detalhadas, consulte o [Sumário da Documentação](indice.md).

## Características

- Feito para o PHP 8.3 ou superior;
- Codificado com boas práticas e máxima qualidade;
- Bem documentado e amigável para IDEs;
- Feito com TDD (Test Driven Development);
- Implementado com testes de unidade usando PHPUnit;
- Feito com :heart: &amp; :coffee:.

## Creditos

[Ricardo Pereira Dias](https://www.ricardopedias.com.br)
