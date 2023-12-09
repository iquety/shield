<?php

declare(strict_types=1);

namespace Tests;

use DateTime;
use Iquety\Shield\EqualTo;
use Tests\TestCase;

class EqualToTest extends TestCase
{
    public function trueCasesProvider(): array
    {
        $list = [];

        $list['two integers'] = [123456, 123456];
        $list['two numbers'] = ['123456', '123456'];
        $list['two dates'] = [new DateTime('2023-10-01'), new DateTime('2023-10-01')];

        return $list;
    }

    /**
     * @test
     * @dataProvider trueCasesProvider
     * */
    public function trueCases(mixed $actual, mixed $comparison): void
    {
        $assertion = new EqualTo($actual, $comparison);

        $this->assertTrue($assertion->isValid());
    }

    public function falseCasesProvider(): array
    {
        $list = [];

        $list['two integers'] = [123456, 023456];
        $list['two numbers'] = ['123456', 123456];
        $list['two dates'] = [new DateTime('2023-10-01'), new DateTime('2023-10-02')];

        return $list;
    }

    /**
     * @test
     * @dataProvider falseCasesProvider
     * */
    public function falseCases(mixed $actual, mixed $comparison): void
    {
        $assertion = new EqualTo($actual, $comparison, 'Error message', 'email');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->getErrorMessage(), 'Error message');
        $this->assertEquals($assertion->getIdentity(), 'email');
    }
}
