# Shield object

[◂ How to use](01-how-to-use.md) | [Documentation Summary](index.md) | [Assertions ▸](03-assertions.md)
-- | -- | --

## 1. Introduction

The Shield class is responsible for configuring assertions.

```php
$shield = new Shield();
```

## 2. Assertion

To register an assertion, the `Shield` class offers a method called `assert`
that takes an `Assertion` object as an argument.

The `assert` method can be called directly or by using the `field` method
to relate the assertion to a specific form field.

```php
// simple assertion
$shield->assert(new EqualTo('word', 'word'));
```

```php
// assertion related to a form field
$shield
    ->field('username')
    ->assert(new MinLength('kamenrider', 3));
```

## 3. Mensagens de erro

All assertions have a default error message, which can be customized using the
`message` method:

```php
$shield
    ->field('username')
    ->assert(new MinLength('kamenrider', 3))
    // custom message in case of assertion error
    ->message('The field {{ field }} must have at least {{ assert-value }} characters');
```

To compose the message, there are variables that can be used:

| Variable             | Description                            |
| :--                  | :--                                    |
| `{{ field }}`        | field namempo                          |
| `{{ value }}`        | value to be assessed                   |
| `{{ assert-value }}` | value to be compared in the assessment |

## 4. Using errors

After declaring the assertions, the `hasErrors` method can be called to check
if there were any errors. If there were, the `getErrorList` method returns an
array with the errors.

```php
$shield = new Shield();

... // declaration of the assertions here

if ($shield->hasErrors() === true) {
    $errors = $shield->getErrorList();

    // we can release a structure here to be used in the front-end
    // to display errors to the user
    echo json_encode($errors);
}
```

## 5. Throwing exceptions

Another possibility is to use the `validOrThrow` method to throw an exception if
there are errors.

```php
$shield = new Shield();

... // declaration of the assertions here

$shield->validOrThrow();
```

By default, an exception of type `AssertionException` is thrown, but it is possible
to customize the exception type by passing the desired exception as a method argument:

```php
$shield = new Shield();

... // declaration of the assertions here

$shield->validOrThrow(RuntimeException::class);
```

The advantage of the standard exception of the `AssertionException` type is the
possibility of obtaining the list of errors from it and releasing it to the user:

```php
$shield = new Shield();

... // declaration of the assertions here

try {
    $shield->validOrThrow();
} catch (AssertionException $exception) {
    $errors = $exception->getErrorList();

    // we can release a structure here to be used in the front-end
    // to display errors to the user
    echo json_encode($errors);
}
```

[◂ How to use](01-how-to-use.md) | [Documentation Summary](index.md) | [Assertions ▸](03-assertions.md)
-- | -- | --
