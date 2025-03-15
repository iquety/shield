<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsCpf extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function isValid(): bool
    {
        $value = $this->getValue();

        if (
            is_bool($value) === true
            || is_object($value) === true
            || is_array($value) === true
        ) {
            return false;
        }

        // mantém somente os números
        $cpf = (string)preg_replace('/[^0-9]/is', '', (string)$value);

        // cpf deve possuir 11 caracteres
        if (strlen($cpf) !== 11) {
            return false;
        }

        // não foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // calcula o CPF
        for ($position = 9; $position < 11; $position++) {
            for ($digit = 0, $index = 0; $index < $position; $index++) {
                $digit += (int)$cpf[$index] * (($position + 1) - $index);
            }

            $digit = ((10 * $digit) % 11) % 10;

            if ($cpf[$index] !== (string)$digit) {
                return false;
            }
        }

        return true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid CPF");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid CPF",
        );
    }
}
