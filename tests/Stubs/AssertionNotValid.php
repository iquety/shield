<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Iquety\Shield\CommonAssertion;

class AssertionNotValid extends CommonAssertion
{
    public function __construct(
        private string $errorMessage = '',
        private string $identity = ''
    ) {
        $this->populate(false, $errorMessage, $identity);
    }

    public function isValid(): bool
    {
        return false;
    }
}
