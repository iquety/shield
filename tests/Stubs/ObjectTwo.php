<?php

declare(strict_types=1);

namespace Tests\Stubs;

class ObjectTwo extends ObjectOne
{
    public function __construct(public string $name)
    {
    }
}
