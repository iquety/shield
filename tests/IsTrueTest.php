<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\IsFalse;
use Iquety\Shield\IsTrue;
use Tests\TestCase;

class IsTrueTest extends TestCase
{
    public function trueCasesProvider(): array
    {
        $list = [];

        $list['boolean'] = [true];

        return $list;
    }

    /**
     * @test
     * @dataProvider trueCasesProvider
     * */
    public function trueCases(mixed $actual): void
    {
        $assertion = new IsTrue($actual);

        $this->assertTrue($assertion->isValid());
    }

    public function falseCasesProvider(): array
    {
        $list = [];

        $list['boolean'] = [false];

        return $list;
    }

    /**
     * @test
     * @dataProvider falseCasesProvider
     * */
    public function falseCases(mixed $actual): void
    {
        $assertion = new IsTrue($actual, 'Error message', 'email');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->getErrorMessage(), 'Error message');
        $this->assertEquals($assertion->getIdentity(), 'email');
    }
}
