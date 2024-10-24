<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion\EqualTo;
use Tests\Stubs\ObjectOne;
use Tests\TestCase;

class EqualToTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function validEquality(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 'Palavra'];
        $list['object'] = [new ObjectOne(''), new ObjectOne('')];
        $list['integer'] = [44, 44];
        $list['float'] = [44.4, 44.4];
        $list['float zero'] = [44.0, 44.0];

        return $list;
    }

    /**
     * @test
     * @dataProvider validEquality
     */
    public function assertedCase(mixed $one, mixed $two): void
    {
        $assertion = new EqualTo($one, $two);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = [
            'Palavra', 'Palavra Diferente',
            'Palavra', 'Palavra Diferente'
        ];

        $list['object'] = [
            new ObjectOne(''), new ObjectOne('x'),
            ObjectOne::class . ':["name"=>""]', ObjectOne::class . ':["name"=>"x"]'
        ];

        $list['integer'] = [
            44, 45,
            '44', '45'
        ];

        $list['float'] = [
            44.4, 44.1,
            '44.4', '44.1'
        ];

        $list['float zero'] = [
            44.0, 44.1,
            '44', '44.1'
        ];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $one, mixed $two): void
    {
        $assertion = new EqualTo($one, $two);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "The values ​​must be equal"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function notAssertedWithNamedAssertionCase(
        mixed $one,
        mixed $two,
        string $oneString,
        string $twoString
    ): void {
        $assertion = new EqualTo($one, $two);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "The value of the field 'name' must be equal to '$twoString'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedWithNamedAssertionAndCustomMessageCase(
        mixed $one,
        mixed $two,
        string $oneString,
        string $twoString
    ): void {
        $assertion = new EqualTo($one, $two);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} e {{ assert-value }} são diferentes');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $oneString e $twoString são diferentes");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(
        mixed $one,
        mixed $two,
        string $oneString,
        string $twoString
    ): void {
        $assertion = new EqualTo($one, $two);

        $assertion->message('O valor {{ value }} e {{ assert-value }} são diferentes');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $oneString e $twoString são diferentes");
    }
}
