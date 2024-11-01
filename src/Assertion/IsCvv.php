<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\CreditCardBrand;
use Iquety\Shield\Message;

class IsCvv extends Assertion
{
    public function __construct(int|string $cvv, CreditCardBrand $brand)
    {
        $this->setValue($cvv);

        $this->setAssertValue($brand);
    }

    public function isValid(): bool
    {
        $brand = $this->getAssertValue();
        $cvv = (string)$this->getValue();

        // Remove todos os caracteres não-numéricos
        $cvv = preg_replace('/\D/', '', $cvv);

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
