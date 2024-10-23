<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Exception;

class AssertionException extends Exception
{
    /** @var array<string,array<int,string>> */
    private array $errorList = [];

    public function extractErrorsFrom(Shield $shield): self
    {
        $this->errorList = $shield->getErrorList();

        return $this;
    }

    /** @var array<string,array<int,string>> */
    public function toArray(): array
    {
        return $this->errorList;
    }
}
