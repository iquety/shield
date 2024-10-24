<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Exception;

class AssertionException extends Exception
{
    /** @var array<int|string,array<int,string>|string> */
    private array $errorList = [];

    public function extractErrorsFrom(Shield $shield): self
    {
        $this->errorList = $shield->getErrorList();

        return $this;
    }

    /** @return array<int|string,array<int,string>|string> */
    public function getErrorList(): array
    {
        return $this->errorList;
    }
}
