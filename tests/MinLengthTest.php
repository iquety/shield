<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\MinLength;
use Tests\TestCase;

class MinLengthTest extends TestCase
{
    /** @test */
    public function lessSize(): void
    {
        $assertion = new MinLength('Cora', 7);

        $this->assertFalse($assertion->isValid());
    }

    /** @test */
    public function sameSize(): void
    {
        $assertion = new MinLength('Coração', 7);

        $this->assertTrue($assertion->isValid());
    }

    public function greaterSize(): void
    {
        $assertion = new MinLength('Coração', 5);

        $this->assertTrue($assertion->isValid());
    }
}
