# Asserções

--page-nav--

As seguintes asserções são usadas para validar o valor de uma variável:

## Contains

O valor completo contém o valor parcial.

```php
// string contém a palavra 'texto'
new Contains('Meu texto', 'texto');

// string contém o número 123
new Contains('123456', 123);

// número contém a string 12.3
new Contains(12.3456, '12.3');

// número contém o número 123
new Contains(123456, 123);

// Objetos do tipo \Stringable contém a palavra 'texto'
new Contains(new Exception('Meu texto'), 'texto');

// Array contém o elemento 'texto'
new Contains(['Meu', 'texto'], 'texto');

// Objetos do tipo \ArrayAccess contém o elemento 'texto'
new Contains(new ArrayObject(['Meu', 'texto']), 'texto');

// Objetos do tipo \stdClass contém a propriedade pública 'texto'
$stdObject = new stdClass();
$stdObject->one = 'Meu';
$stdObject->two = 'Texto';
new Contains($stdObject, 'texto');
```

## EndsWith

O valor completo termina com o valor parcial.

```php
new EndsWith($stdObject);
```



| Asserção             | Descrição                                           |
| :--                  | :--                                                 |
| Contains             | O valor contém o valor esperado                     |
| EndsWith             | O valor termina com o valor esperado                |
| EqualTo              | Ambos os valores são iguais                         |
| GreaterThan          | O valor é maior do que o valor esperado             |
| GreaterThanOrEqualTo | O valor é maior ou igual ao esperado                |
| IsAlpha              | O valor contém apenas letras                        |
| IsAlphaNumeric       | O valor contém apenas letras e números              |
| IsAmountOfTime       | O valor é uma hora sem limite (ex.: 99:59:59)       |
| IsBase64             | O valor é uma string codificada em base64           |
| IsBrPhoneNumber      | O valor é um telefone brasileiro                    |
| IsCep                | O valor é um CEP                                    |
| IsCpf                | O valor é um CPF                                    |
| IsCreditCard         | O valor é um cartão de crédito                      |
| IsCreditCardBrand    | O valor é uma banderia de cartão de crédito         |
| IsCvv                | O valor é um código de verificação de cartão de crédito |
| IsDate               | O valor é uma data válida                           |
| IsDateTime           | O valor é uma data e hora válida                    |
| IsEmail              | O valor é um e-mail válido                          |
| IsEmpty              | O valor é vazio                                     |
| IsFalse              | O valor é falso                                     |
| IsHexadecimal        | O valor é um número hexadecimal válido              |
| IsHexColor           | O valor é uma cor hexadecimal válida                |
| IsIp                 | O valor é um endereço IP válido                     |
| IsMacAddress         | O valor é um endereço MAC válido                    |
| IsNotEmpty           | O valor não é vazio                                 |
| IsNotNull            | O valor não é nulo                                  |
| IsNull               | O valor é nulo                                      |
| IsTime               | O valor é uma hora válida (ex.: 23:59:59)           |
| IsTrue               | O valor é verdadeiro                                |
| IsUrl                | O valor é uma URL válida                            |
| IsUuid               | O valor é um UUID válido                            |
| Length               | O valor possui o tamanho esperado                   |
| LessThan             | O valor é menor do que o valor esperado             |
| LessThanOrEqualTo    | O valor é menor ou igual ao valor esperado          |
| Matches              | O valor corresponde ao padrão esperado              |
| MaxLength            | O valor possui o tamanho máximo esperado            |
| MinLength            | O valor possui pelo menos o tamanho mínimo esperado |
| NotContains          | O valor não contém o valor esperado                 |
| NotEqualTo           | Os valores são diferentes                           |
| NotMatches           | O valor não corresponde ao padrão esperado          |
| StartsWith           | O valor começa com o valor esperado                 |

--page-nav--
