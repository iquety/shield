<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion\NotEqualTo;
use Tests\Stubs\ObjectOne;
use Tests\TestCase;

class NotEqualToTest extends TestCase
{
    public function validEquality(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 'Palavras'];
        $list['object'] = [new ObjectOne(''), new ObjectOne('x')];
        $list['integer'] = [44, 45];
        $list['float'] = [44.4, 44.5];
        $list['float zero'] = [44.0, 44.1];

        return $list;
    }

    /**
     * @test
     * @dataProvider validEquality
     */
    public function assertedCase(mixed $one, mixed $two): void
    {
        $assertion = new NotEqualTo($one, $two);

        $this->assertTrue($assertion->isValid());
    }

    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = [
            'Palavra', 'Palavra',
            'Palavra', 'Palavra'
        ];

        $list['object'] = [
            new ObjectOne(''), new ObjectOne(''),
            ObjectOne::class . ':["name"=>""]', ObjectOne::class . ':["name"=>""]'
        ];

        $list['integer'] = [
            44, 44,
            '44', '44'
        ];

        $list['float'] = [
            44.4, 44.4,
            '44.4', '44.4'
        ];

        $list['float zero'] = [
            44.0, 44.0,
            '44', '44'
        ];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $one, mixed $two): void
    {
        $assertion = new NotEqualTo($one, $two);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "The values ​​must be different"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedWithNamedAssertionCase(
        mixed $one,
        mixed $two,
        string $oneString,
        string $twoString
    ): void {
        $assertion = new NotEqualTo($one, $two);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "The 'name' field value must be different from '$twoString'"
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
        $assertion = new NotEqualTo($one, $two);

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
        $assertion = new NotEqualTo($one, $two);

        $assertion->message('O valor {{ value }} e {{ assert-value }} são diferentes');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $oneString e $twoString são diferentes");
    }
}
