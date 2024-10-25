<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsDate;
use Tests\TestCase;

class IsDateTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['ISO 8601'] = ['2024-12-31'];
        $list['European format'] = ['31/12/2024'];
        $list['US format'] = ['12/31/2024'];
        $list['Alternative format'] = ['2024.12.31'];
        $list['Abbreviated month name'] = ['31-Dec-2024'];
        $list['Full month name'] = ['December 31, 2024'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $dateString): void
    {
        $assertion = new IsDate($dateString);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['ISO 8601 dirty'] = ['00002024-12-31xxx'];
        $list['European format dirty'] = ['31/12//2024'];
        $list['US format dirty'] = ['xxx12/31/2024'];
        $list['Alternative format dirty'] = ['rr2x024.12.31'];
        $list['Abbreviated month name dirty'] = ['xxx31-Dec-2024'];
        $list['Full month name dirty'] = ['xxxDecember 31, 2024'];

        $list['ISO 8601 invalid month'] = ['2024-13-31'];
        $list['ISO 8601 invalid day'] = ['2024-12-32'];

        $list['European format month'] = ['31/13/2024'];
        $list['European format day'] = ['32/12/2024'];

        $list['US format month'] = ['13/31/2024'];
        $list['US format day'] = ['12/32/2024'];
        
        $list['Alternative format month'] = ['2024.13.31'];
        $list['Alternative format day'] = ['2024.12.32'];

        $list['Abbreviated month name month'] = ['31-Err-2024'];
        $list['Abbreviated month name day'] = ['32-Dec-2024'];

        $list['Full month name month'] = ['Invalid 31, 2024'];
        $list['Full month name day'] = ['December 32, 2024'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $dateString): void
    {
        $assertion = new IsDate($dateString);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid date"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $dateString): void
    {
        $assertion = new IsDate($dateString);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid date"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $dateString): void
    {
        $assertion = new IsDate($dateString);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $dateString está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $dateString): void
    {
        $assertion = new IsDate($dateString);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $dateString está errado");
    }
}
