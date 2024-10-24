# How to use

--page-nav--

Assertions are configured through the `Shield` library.

## 1. Validating arguments in operations

Can be used to validate arguments in methods:

```php
function myOperation(string $name): void
{
    $instance = new Shield();
    
    // is the $name argument 8 characters or less?
    $instance->assert(new MaxLength($name, 8)); 

    // Does the $name argument have 3 or more characters?
    $instance->assert(new MinLength($name, 3)); 
    
    // either all assertions match,
    // or an exception will be thrown
    $instance->validOrThrow();
}
```

## 2. Validating user input

It is also very useful to validate user input:

```php
// user input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

$instance = new Shield();

// Is $name 8 characters or less?
$instance
    ->field('name_html')
    ->assert(new MaxLength($name, 8)); 

// Is $name 3 characters or more?
$instance
    ->field('name_html')
    ->assert(new MinLength($name, 3)); 

// $email is valid?
$instance
    ->field('email_html')
    ->assert(new IsEmail($email)); 

// if any of the assertions fail
if ($instance->hasErrors() === false) {
    $errorMessages = $instance->getErrorList();

    // in this example, we output the error messages
    // to the user in JSON format to be handled by JavaScript
    echo json_encode($errorMessages);
}
```

--page-nav--
