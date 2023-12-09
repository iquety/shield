<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Iquety\Shield\CommonAssertion;

class AssertionValid extends CommonAssertion
{
    public function __construct(
        private string $errorMessage = '',
        private string $identity = ''
    ) {
        $this->populate(true, $errorMessage, $identity);
    }

    public function isValid(): bool
    {
        return true;
    }
}
