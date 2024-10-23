# Iquety Shield (alpha)

[![GitHub Release](https://img.shields.io/github/release/iquety/shield.svg)](https://github.com/iquety/shield/releases/latest)
![PHP Version](https://img.shields.io/badge/php-%5E8.3-blue)
![License](https://img.shields.io/badge/license-MIT-blue)
[![Codacy Grade](https://app.codacy.com/project/badge/Grade/5097e82662f54f52a8ae5bb3a4b54e45)](https://www.codacy.com/gh/iquety/security/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=iquety/security&amp;utm_campaign=Badge_Grade)
[![Codacy Coverage](https://app.codacy.com/project/badge/Coverage/5097e82662f54f52a8ae5bb3a4b54e45)](https://www.codacy.com/gh/iquety/security/dashboard?utm_source=github.com&utm_medium=referral&utm_content=iquety/security&utm_campaign=Badge_Coverage)

[English](readme.md) | [Português](./docs/pt-br/leiame.md)
-- | --

## Synopsis

```bash
composer require iquety/shield
```

This is a library offering a set of Assertions for values and expressions.

In computing, assertion is a check with the aim of certifying that a certain 
condition imposed by the developer is true.

The use of assertions is very useful, especially when validating values coming 
from method arguments or user input.

## How to use

Assertions are registered through the `Shield` library.

Can be used in the conventional way:

```php

$name = 'Ricardo';

$instance = new Shield();

// Does 'Ricardo' 4 characters or less?
$instance->assert(new MaxLength($name, 4)); 

// or all assertions match,
// or an exception is thrown
$instance->validOrThrow();
```

or in fluent form:

```php

$name = 'Ricardo';

$instance = (new Shield())
    ->assert(new MaxLength($name, 4))
    ->validOrThrow();
```

In the example above, an exception of type `Exception` will be thrown with the 
message *"The value was not successfully asserted"*.

For detailed information, see [Documentation Summary](docs/en/index.md).

## Characteristics

- Made for PHP 8.3 or higher;
- Codified with best practices and maximum quality;
- Well documented and IDE friendly;
- Made with TDD (Test Driven Development);
- Implemented with unit tests using PHPUnit;
- Made with :heart: &amp; :coffee:.

## Creditos

[Ricardo Pereira Dias](https://www.ricardopedias.com.br)
