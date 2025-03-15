<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

/**
 * Valida se o valor é um número de telefone válido no Brasil
 * Os seguintes formatos são aceitos:
 * 3003 9999        - numero fixo nacional (a tarifa é dividida entre a empresa e o usuário)
 * 4003 9999        - numero fixo nacional (a tarifa é dividida entre a empresa e o usuário)
 * 4004 9999        - numero fixo nacional (a tarifa é dividida entre a empresa e o usuário)
 * 0300 999 9999    - Serviços não gratuitos
 * 0500 999 9999    - Serviços de doação a instituições de utilidade pública
 * 0800 999 9999    - Serviços gratuitos
 * 0900 999 9999    - Serviços de valor adicionado
 * (99) 9999-9999   - telefonia fixa
 * (99) 9 9999-9999 - telefonia móvel
 */
class IsBrPhoneNumber extends Assertion
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
            || is_null($value) === true
        ) {
            return false;
        }

        // retira todos os separadores, espaços e parêntesis
        $number = str_replace(['-', ' ', '(', ')'], '', $value);

        $length = strlen($number);

        // 3003 9999
        // 4003 9999
        // 4004 9999
        if ($length === 8) {
            return preg_match('/[0-4]{4}[0-9]{4}/', $number) === 1;
        }

        // (99) 9999-9999 - telefonia fixa
        if ($length === 10) {
            return preg_match('/[0-9]{2}[0-9]{4}[0-9]{4}/', $number) === 1;
        }

        // 0300 999 9999 - Serviços não gratuitos
        // 0500 999 9999 - Serviços de doação a instituições de utilidade pública
        // 0800 999 9999 - Serviços gratuitos
        // 0900 999 9999 - Serviços de valor adicionado
        if ($length === 11) {
            return
                // 0300 999 9999 - serviços
                preg_match('/0300|0500|0800|0900[0-9]{3}[0-9]{4}/', $number) === 1
                // (99) 9 9999-9999 - telefonia móvel
                || preg_match('/[0-9]{4}[0-9]{3}[0-9]{4}/', $number) === 1;
        }

        return false;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid phone number");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid phone number",
        );
    }
}
