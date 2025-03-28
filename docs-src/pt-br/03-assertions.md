# Asserções

--page-nav--

As seguintes asserções são usadas para validar o valor de uma variável:

## Igualdade

| Asserção                       | Descrição                  |
| :--                            | :--                        |
| [EqualTo](04-equalto.md)       | Os valores são iguais      |
| [NotEqualTo](04-notequalto.md) | Os valores são diferentes  |

## Elementos

| Asserção                         | Descrição                         |
| :--                              | :--                               |
| [Contains](05-contains.md)       | O valor contém o outro valor      |
| [EndsWith](05-endswith.md)       | O valor termina com o outro valor |
| [Matches](05-matches.md)         | O valor corresponde ao padrão     |
| [NotContains](05-notcontains.md) | O valor não contém o outro valor  |
| [NotMatches](05-notmatches.md)   | O valor não corresponde ao padrão |
| [StartsWith](05-startswith.md)   | O valor começa com o outro valor  |

## Números

| Asserção                                     | Descrição                                   |
| :--                                          | :--                                         |
| [GreaterThan](06-greaterthan.md)             | O número é maior do que o esperado          |
| [GreaterThanOrEqualTo](06-greaterthanorequalto.md) | O número é maior ou igual ao esperado |
| [LessThan](06-lessthan.md)                   | O número é menor do que o esperado          |
| [LessThanOrEqualTo](06-lessthanorequalto.md) | O número é menor ou igual ao outro valor    |

## Contagem

| Asserção                                     | Descrição                                  |
| :--                                          | :--                                        |
| [Length](07-length.md)                       | O valor possui o tamanho esperado          |
| [MaxLength](07-maxlength.md)                 | O valor possui o tamanho máximo            |
| [MinLength](07-minlength.md)                 | O valor possui o tamanho mínimo            |

## Datas e tempo

| Asserção                           | Descrição                               |
| :--                                | :--                                     |
| [IsDate](08-isdate.md)             | Formatos de data                        |
| [IsDateTime](08-isdatetime.md)     | Formatos de data + hora                 |
| [IsTime](08-istime.md)             | Formato de hora com limite de 24 horas) |
| [IsAmountTime](08-isamounttime.md) | Formato de hora sem limite de horas     |

## Internet

| Asserção                           | Descrição                                        |
| :--                                | :--                                              |
| IsEmail                            | Endereço eletrônico (ex.: **fulano@gmail.com**)  |
| [IsIp](09-isip.md)                 | É um endereço IP                                 |
| [IsMacAddress](09-ismacaddress.md) | É um endereço MAC                                |
| [IsUrl](09-isurl.md)               | É uma URL                                        |

## Formatos brasileiros

| Asserção           | Descrição                                              |
| :--                | :--                                                    |
| [IsBrPhoneNumber](10-isbrphonenumber.md) | O valor é um telefone brasileiro |
| IsCep              | Código de endereçamento postal (ex.: **12.380-315**)   |
| IsCpf              | Cadastro de pessoa física (ex.: **742.143.120-90**)    |

## Booleanos

| Asserção           | Descrição                                                                |
| :--                | :--                                                                      |
| IsFalse            | O valor é falso (false, 0, 'false', '0', 'false', '', ' ')               |
| IsTrue             | O valor é verdadeiro (true, 1, 'true', '1', 'on')                        |

## Vazios

| Asserção           | Descrição                                                                |
| :--                | :--                                                                      |
| IsEmpty            | O valor é vazio (false, null, '', 0, [] e tipos Countable vazios)        |
| IsNotEmpty         | O valor não é vazio (diferentes de false, null, '', 0, [] e tipos Countable vazios) |
| IsNotNull          | O valor não é nulo                                                       |
| IsNull             | O valor é nulo                                                           |

## Outros formatos

| Asserção           | Descrição                                                                |
| :--                | :--                                                                      |
| IsAlpha            | Caracteres alfabéticos (ex.: **abcdefghijklmnopqrstuvwxyz**)             |
| IsAlphaNumeric     | Caracteres alfanuméricos (ex.: **abcdefghijklmnopqrstuvwxyz1234567890**) |
| IsBase64           | Texto codificado em base64: (ex.: **YcOnw6NvdmFsZW50ZQ==**)              |
| IsCreditCard       | Número de cartão de crédito: (ex.: **5279 6901 2297 4109** ou **5279-6901-2297-4109**) |
| IsCreditCardBrand  | Uma bandeira de cartão de crédito                                        |
| IsCvv              | Código de segurança de cartão de crédito (ex.: **345**)                  |
| IsHexadecimal      | Caracteres hexadecimais (ex.: **1234567890abcdef**)                      |
| IsHexColor         | É uma cor hexadecimal (ex.: **#ff00ee** ou **#FF00EE**)                  |
| IsUuid             | É um UUID (ex.: **3f2504e0-4f89-41d3-9a0c-0305e82c3301**)                |

--page-nav--
