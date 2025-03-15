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
| [Contains](04-contains.md)       | O valor contém o outro valor      |
| [EndsWith](04-endswith.md)       | O valor termina com o outro valor |
| [Matches](04-matches.md)         | O valor corresponde ao padrão     |
| [NotContains](04-notcontains.md) | O valor não contém o outro valor  |
| [NotMatches](04-notmatches.md)   | O valor não corresponde ao padrão |
| [StartsWith](04-startswith.md)   | O valor começa com o outro valor  |

## Contagem

| Asserção                                     | Descrição                               |
| :--                                          | :--                                     |
| [GreaterThan](04-greaterthan.md)             | O valor é maior do que o esperado       |
| [GreaterThanOrEqualTo](04-greaterthanorequalto.md) | O valor é maior ou igual ao esperado |
| [Length](04-length.md)                       | O valor possui o tamanho esperado       |
| [LessThan](04-lessthan.md)                   | O valor é menor do que o esperado       |
| [LessThanOrEqualTo](04-lessthanorequalto.md) | O valor é menor ou igual ao outro valor |
| [MaxLength](04-maxlength.md)                 | O valor possui o tamanho máximo         |
| [MinLength](04-minlength.md)                 | O valor possui o tamanho mínimo         |

## Datas e tempo

| Asserção                               | Descrição                               |
| :--                                    | :--                                     |
| [IsDate](04-isdate.md)                 | Formatos de data                        |
| [IsDateTime](04-isdatetime.md)         | Formatos de data + hora                 |
| [IsTime](04-istime.md)                 | Formato de hora com limite de 24 horas) |
| [IsAmountTime](04-isamounttime.md) | Formato de hora sem limite de horas     |

## Outros formatos

| Asserção           | Descrição                                                  |
| :--                | :--                                                        |
| IsAlpha            | Aceita os caracteres: abcdefghijklmnopqrstuvwxyz           |
| IsAlphaNumeric     | Aceita os caracteres: abcdefghijklmnopqrstuvwxyz1234567890 |
| IsBase64           | É uma string codificada em base64  YcOnw6NvdmFsZW50ZQ==                        |
| IsBrPhoneNumber    | O valor é um telefone brasileiro      |
| IsCep              | 99.999-999                      |
| IsCpf              | 999.999.999-99                      |
| IsCreditCard       | 9999-É um cartão de crédito                |
| IsCreditCardBrand  | É uma banderia de cartão de crédito   |
| IsCvv              | 999                                   |
| IsEmail            | O valor é um e-mail                   |
| IsEmpty            | O valor é vazio                       |
| IsFalse            | O valor é falso                       |
| IsHexadecimal      | É um número hexadecimal               |
| IsHexColor         | O valor é uma cor hexadecimal         |
| IsIp               | O valor é um endereço IP              |
| IsMacAddress       | O valor é um endereço MAC             |
| IsNotEmpty         | O valor não é vazio                   |
| IsNotNull          | O valor não é nulo                    |
| IsNull             | O valor é nulo                        |
| IsTrue             | O valor é verdadeiro                  |
| IsUrl              | O valor é uma URL                     |
| IsUuid             | O valor é um UUID                     |

--page-nav--
