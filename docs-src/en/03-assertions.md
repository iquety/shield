# Assertions

--page-nav--

The following assertions are used to validate the value of a variable:

## Equality

| Assertion | Description |
| :-- | :-- |
| [EqualTo](04-equalto.md) | The values ​​are equal |
| [NotEqualTo](04-notequalto.md) | The values ​​are not equal |

## Elements

| Assertion                        | Description                                |
| :--                              | :--                                        |
| [Contains](05-contains.md)       | The value contains the other value         |
| [EndsWith](05-endswith.md)       | The value ends with the other value        |
| [Matches](05-matches.md)         | The value matches the pattern              |
| [NotContains](05-notcontains.md) | The value does not contain the other value |
| [NotMatches](05-notmatches.md)   | Value does not match pattern               |
| [StartsWith](05-startswith.md)   | Value starts with the other value          |

## Numbers

| Assertion                                          | Description                                |
| :--                                                | :--                                        |
| [GreaterThan](06-greaterthan.md)                   | Number is greater than expected             |
| [GreaterThanOrEqualTo](06-greaterthanorequalto.md) | Number is greater than or equal to expected |
| [LessThan](06-lessthan.md)                         | Number is less than expected                |
| [LessThanOrEqualTo](06-lessthanorequalto.md)       | Number is less than or equal to other value |

## Count

| Assertion                                          | Description                                |
| :--                                                | :--                                        |
| [Length](07-length.md)                             | Value is the expected length               |
| [MaxLength](07-maxlength.md)                       | The value has the maximum length           |
| [MinLength](07-minlength.md)                       | The value has the minimum length           |

## Dates and times

| Assertion                          | Description                    |
| :--                                | :--                            |
| [IsDate](08-isdate.md)             | Date formats                   |
| [IsDateTime](08-isdatetime.md)     | Date + time formats            |
| [IsTime](08-istime.md)             | Time format with 24-hour limit |
| [IsAmountTime](08-isamounttime.md) | Time format with no hour limit |

## Internet

| Assertion                          | Description                                    |
| :--                                | :--                                            |
| IsEmail                            | Electronic address (e.g. **fulano@gmail.com**) |
| [IsIp](09-isip.md)                 | Is an IP address                               |
| [IsMacAddress](09-ismacaddress.md) | Is a MAC address                               |
| [IsUrl](09-isurl.md)               | Is a URL                                       |

## Brazilian formats

| Assertion        | Description                                                       |
| :--              | :--                                                               |
| [IsBrPhoneNumber](10-isbrphonenumber.md) | The value is a Brazilian telephone number |
| IsCep            | Postal code (e.g. **12.380-315**)                                 |
| IsCpf            | Individual taxpayer registration number (e.g. **742.143.120-90**) |

## Other formats

| Assertion         | Description                                                                   |
| :--               | :--                                                                           |
| IsAlpha           | Alphabetic characters (e.g. **abcdefghijklmnopqrstuvwxyz**)                   |
| IsAlphaNumeric    | Alphanumeric characters (e.g. **abcdefghijklmnopqrstuvwxyz1234567890**)       |
| IsBase64          | Base64 encoded text: (e.g. **YcOnw6NvdmFsZW50ZQ==**)                          |
| IsCreditCard      | Credit card number: (e.g. **5279 6901 2297 4109** or **5279-6901-2297-4109**) |
| IsCreditCardBrand | A credit card brand                                                           |
| IsCvv             | Credit card security code (e.g. **345**)                                      |
| IsEmpty           | The value is empty (false, null, '', 0, [], empty Countable)                  |
| IsFalse           | The value is false (false, 0, 'false', '0', 'false', '', ' ')                 |
| IsHexadecimal     | Hexadecimal characters (e.g. **1234567890abcdef**)                            |
| IsHexColor        | Is a hexadecimal color (e.g. **#ff00ee** or **#FF00EE**)                      |
| IsNotEmpty        | The value is not empty (different of false, null, '', 0, [], empty Countable) |
| IsNotNull         | The value is not null                                                         |
| IsNull            | The value is null                                                             |
| IsTrue            | The value is true (true, 1, 'true', '1', 'on')                                |
| IsUuid            | Is a UUID (e.g. **3f2504e0-4f89-41d3-9a0c-0305e82c3301**)                     |

--page-nav--
