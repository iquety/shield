<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\CreditCardBrand;
use Iquety\Shield\Message;
use ValueError;

class IsCreditCard extends Assertion
{
    public function __construct(int|string $value)
    {
        $this->setValue($value);
    }

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    public function isValid(): bool
    {
        $value = (string)$this->getValue();

        // Remove todos os caracteres não-numéricos
        $value = (string)preg_replace('/\D/', '', $value);

        try {
            CreditCardBrand::fromNumber($value);
        } catch (ValueError) {
            return false;
        }

        return $this->isValidLuhn($value);
    }

    private function isValidLuhn(string $number): bool
    {
        $sum = 0;
        $numDigits = strlen($number);
        $parity = $numDigits % 2;

        for ($i = 0; $i < $numDigits; $i++) {
            $digit = (int)$number[$i];

            if ($i % 2 == $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return ($sum % 10) === 0;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid credit card number");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid credit card number",
        );
    }
}
