# Como usar

[◂ Sumário da Documentação](indice.md) | [Objeto Shield ▸](02-shield.md)
-- | --

As asserções são configuradas através da biblioteca `Shield`.

## 1. Validando argumentos em operaçṍes

Pode ser usado para validar argumentos em métodos:

```php
function minhaOperacao(string $nome): void
{
    $instance = new Shield();
    
    // o argumento $nome possui 8 caracteres ou menos?
    $instance->assert(new MaxLength($name, 8)); 

    // o argumento $nome possui 3 caracteres ou mais?
    $instance->assert(new MinLength($name, 3)); 
    
    // ou todas as asserções conferem, 
    // ou uma exceção será lançada
    $instance->validOrThrow();
}
```

## 2. Validando entradas do usuário

Também é muito útil para validar entradas do usuário:

```php
// entradas do usuário
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

$instance = new Shield();

// $nome possui 8 caracteres ou menos?
$instance
    ->field('nome_html')
    ->assert(new MaxLength($name, 8)); 

// $nome possui 3 caracteres ou mais?
$instance
    ->field('nome_html')
    ->assert(new MinLength($name, 3)); 

// $email é válido?
$instance
    ->field('email_html')
    ->assert(new IsEmail($email)); 

// se alguma das asserções falhar
if ($instance->hasErrors() === false) {
    $mensagensDeErros = $instance->getErrorList();

    // neste exemplo, liberamos as mensagens de erro
    // ao usuário em formato JSON para ser tratada pelo JavaScript
    echo json_encode($mensagensDeErros);
}
```

[◂ Sumário da Documentação](indice.md) | [Objeto Shield ▸](02-shield.md)
-- | --
