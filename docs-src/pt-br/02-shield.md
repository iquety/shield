# Objeto Shield

--page-nav--

## 1. Introdução

A classe Shield é responsável pela configuração das asserções.

```php
$shield = new Shield();
```

## 2. Asserção

Para registrar uma asserção, a classe `Shield` oferece o método chamado `assert`
que recebe um objeto `Assertion` como argumento.

O método `assert` pode ser chamado diretamente ou utilizando o método `field`
para relacionar a asserção em um campo específico de formulário.

```php
// asserção simples
$shield->assert(new EqualTo('palavra', 'palavra'));
```

```php
// asserção relacionada a um campo de formulário
$shield
    ->field('username')
    ->assert(new MinLength('kamenrider', 3));
```

## 3. Mensagens de erro

Todas as asserções possuem uma mensagem de erro padrão, que pode ser personalizada
usando o método `message`:

```php
$shield
    ->field('username')
    ->assert(new MinLength('kamenrider', 3))
    // mensagem personalizada em caso de erro na asserção
    ->message('O campo {{ field }} deve ter pelo menos {{ assert-value }} caracteres');
```

Para compor a mensagem, existem variáveis que podem ser utilizadas:

| Variável             | Descrição                          |
| :--                  | :--                                |
| `{{ field }}`        | nome do campo                      |
| `{{ value }}`        | valor a ser aferido                |
| `{{ assert-value }}` | valor a ser comparado na aferência |

## 4. Usando os erros

Após declarar as asserções, o método `hasErrors` pode ser chamado para verificar
se houveram erros. Caso haja, o método `getErrorList` retorna um array com os erros.

```php
$shield = new Shield();

... // declaração das asserções aqui

if ($shield->hasErrors() === true) {
    $errors = $shield->getErrorList();

    // podemos liberar aqui uma estrutura para ser usada no front-end
    // para exibir os erros ao usuário
    echo json_encode($errors);
}
```

O formato da lista de erros é propício para validação na camada de apresentação (usando Javascript, por exemplo):

```php
[
    'username' => [
        "O nome deve ter no mínimo 3 caracteres",
        "O nome não pode conter acentos"
    ],
    'email' => [
        "O email fornecido é inválido"
    ]
],
```

## 5. Lançando exceções

Outra possibilidade é usar o método `validOrThrow` para lançar uma exceção se
houver erros.

```php
$shield = new Shield();

... // declaração das asserções aqui

$shield->validOrThrow();
```

Por padrão, uma exceção do tipo `AssertionException` é lançada, mas é possível
personalizar o tipo de exceção passando a exceção desejada como argumento do método:

```php
$shield = new Shield();

... // declaração das asserções aqui

$shield->validOrThrow(RuntimeException::class);
```

A vantagem da exceção padrão do tipo `AssertionException` é a possibilidade de
obter a lista de erros a partir dela e liberar para o usuário:

```php
$shield = new Shield();

... // declaração das asserções aqui

try {
    $shield->validOrThrow();
} catch (AssertionException $exception) {
    $errors = $exception->getErrorList();

    // podemos liberar aqui uma estrutura para ser usada no front-end
    // para exibir os erros ao usuário
    echo json_encode($errors);
}
```

--page-nav--
