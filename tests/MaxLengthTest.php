<?php

declare(strict_types=1);

namespace Tests;

use DateTime;
use Iquety\Shield\MaxLength;
use Iquety\Shield\NotEqualTo;
use Tests\TestCase;

class MaxLengthTest extends TestCase
{
    /** @test */
    public function lessSize(): void
    {
        $assertion = new MaxLength('Cora', 7);

        $this->assertTrue($assertion->isValid());
    }

    /** @test */
    public function sameSize(): void
    {
        $assertion = new MaxLength('Coração', 7);

        $this->assertTrue($assertion->isValid());
    }

    public function greaterSize(): void
    {
        $assertion = new MaxLength('Coração', 5);

        $this->assertFalse($assertion->isValid());
    }
}
