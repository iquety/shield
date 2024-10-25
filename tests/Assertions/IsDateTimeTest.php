<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsDateTime;
use Tests\TestCase;

class IsDateTimeTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['ISO 8601'] = ['2024-12-31 23:59:59'];
        $list['European format'] = ['31/12/2024 23:59:59'];
        $list['US format am'] = ['12/31/2024 11:59:59 AM'];
        $list['US format pm'] = ['12/31/2024 11:59:59 PM'];
        $list['Alternative format'] = ['2024.12.31 23:59:59'];
        $list['Abbreviated month name'] = ['31-Dec-2024 23:59:59'];
        $list['Full month name'] = ['December 31, 2024 23:59:59'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $dateString): void
    {
        $assertion = new IsDateTime($dateString);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['ISO 8601 dirty'] = ['00002024-12-31xxx 23:59:59'];
        $list['European format dirty'] = ['31/12//2024 23:59:59'];
        $list['US format dirty'] = ['xxx12/31/2024 11:59:59 PM'];
        $list['Alternative format dirty'] = ['rr2x024.12.31 23:59:59'];
        $list['Abbreviated month name dirty'] = ['xxx31-Dec-2024 23:59:59'];
        $list['Full month name dirty'] = ['xxxDecember 31, 2024 23:59:59'];

        $list['ISO 8601 invalid month'] = ['2024-13-31 23:59:59'];
        $list['ISO 8601 invalid day'] = ['2024-12-32 23:59:59'];
        $list['ISO 8601 invalid hour'] = ['2024-12-31 25:59:59'];
        $list['ISO 8601 invalid minute'] = ['2024-12-31 20:62:59'];
        $list['ISO 8601 invalid second'] = ['2024-12-31 20:59:62'];

        $list['European format month'] = ['31/13/2024 23:59:59'];
        $list['European format day'] = ['32/12/2024 23:59:59'];
        $list['European format hour'] = ['31/12/2024 28:59:59'];
        $list['European format minute'] = ['31/12/2024 23:62:59'];
        $list['European format second'] = ['31/12/2024 23:59:62'];
        
        $list['US format month am'] = ['13/31/2024 11:59:59 AM'];
        $list['US format day am'] = ['12/32/2024 11:59:59 AM'];
        $list['US format hour am'] = ['12/31/2024 26:59:59 AM'];
        $list['US format minute am'] = ['12/31/2024 11:62:59 AM'];
        $list['US format second am'] = ['12/31/2024 11:59:62 AM'];

        $list['US format month pm'] = ['13/31/2024 11:59:59 PM'];
        $list['US format day pm'] = ['12/32/2024 11:59:59 PM'];
        $list['US format hour pm'] = ['12/31/2024 26:59:59 PM'];
        $list['US format minute pm'] = ['12/31/2024 11:62:59 PM'];
        $list['US format second pm'] = ['12/31/2024 11:59:62 PM'];
        
        $list['Alternative format month'] = ['2024.13.31 23:59:59'];
        $list['Alternative format day'] = ['2024.12.32 23:59:59'];
        $list['Alternative format hour'] = ['2024.12.31 27:59:59'];
        $list['Alternative format minute'] = ['2024.12.31 23:62:59'];
        $list['Alternative format second'] = ['2024.12.31 23:59:62'];

        $list['Abbreviated month name month'] = ['31-Err-2024 23:59:59'];
        $list['Abbreviated month name day'] = ['32-Dec-2024 23:59:59'];
        $list['Abbreviated month name hour'] = ['31-Dec-2024 27:59:59'];
        $list['Abbreviated month name minute'] = ['31-Dec-2024 23:62:59'];
        $list['Abbreviated month name second'] = ['31-Dec-2024 23:59:62'];

        $list['Full month name month'] = ['Invalid 31, 2024 23:59:59'];
        $list['Full month name day'] = ['December 32, 2024 23:59:59'];
        $list['Full month name hour'] = ['December 31, 2024 27:59:59'];
        $list['Full month name minute'] = ['December 31, 2024 23:62:59'];
        $list['Full month name second'] = ['December 31, 2024 23:59:62'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $dateString): void
    {
        $assertion = new IsDateTime($dateString);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid date and time"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $dateString): void
    {
        $assertion = new IsDateTime($dateString);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid date and time"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $dateString): void
    {
        $assertion = new IsDateTime($dateString);

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
        $assertion = new IsDateTime($dateString);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $dateString está errado");
    }
}
