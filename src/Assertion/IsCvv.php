<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\CreditCardBrand;
use Iquety\Shield\Message;

class IsCvv extends Assertion
{
    public function __construct(mixed $cvv, CreditCardBrand $brand)
    {
        $this->setValue($cvv);

        $this->setAssertValue($brand);
    }

    public function isValid(): bool
    {
        $cvv = $this->getValue();

        if (
            is_bool($cvv) === true
            || is_object($cvv) === true
            || is_array($cvv) === true
        ) {
            return false;
        }

        $brand = $this->getAssertValue();

        // Remove todos os caracteres não-numéricos
        $cvv = (string)preg_replace('/\D/', '', (string)$cvv);

        return match ($brand) {
            CreditCardBrand::AMEX => $this->resolveAmex($cvv),
            default => strlen($cvv) === 3,
        };
    }

    private function resolveAmex(string $cvv): bool
    {
        if (strlen($cvv) !== 4) {
            return false;
        }

        return true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid card verification code");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid card verification code",
        );
    }
}
