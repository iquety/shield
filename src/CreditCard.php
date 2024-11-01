<?php

declare(strict_types=1);

namespace Iquety\Shield;

use InvalidArgumentException;
use Iquety\Shield\Assertion\IsCreditCard;

class CreditCard
{
    private int $number;

    public function __construct(int|string $number)
    {
        $assertion = new IsCreditCard($number);

        if ($assertion->isValid() === false) {
            throw new InvalidArgumentException('Credit card number is invalid');
        }

        $this->number = (int)preg_replace('/\D/', '', (string)$number);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    public function getBrand(): CreditCardBrand
    {
        return CreditCardBrand::fromNumber($this->number);
    }
}
