<?php

declare(strict_types=1);

namespace Tests\Stubs;

class ObjectOne implements InterfaceOne
{
    public function __construct(public string $name)
    {
    }
}
