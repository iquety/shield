<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\EqualTo;
use Tests\Stubs\ObjectOne;

class EqualToTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 'Palavra'];

        $list['object'] = [new ObjectOne(''), new ObjectOne('')];

        $list['integer'] = [44, 44];
        $list['integer string'] = ['44', '44'];

        $list['float'] = [44.4, 44.4];
        $list['float string'] = ['44.4', '44.4'];

        $list['float zero'] = [44.0, 44.0];
        $list['float zero string'] = ['44.0', '44.0'];

        $list['array'] = [
            ['one', 'two', 'three'],
            ['one', 'two', 'three']
        ];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueOneEqualToTwo(mixed $valueOne, mixed $valueTwo): void
    {
        $assertion = new EqualTo($valueOne, $valueTwo);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $valueOne, mixed $valueTwo): array
    {
        return [
            $valueOne,
            $valueTwo,
            $this->makeMessageValue($valueOne),
            $this->makeMessageValue($valueTwo)
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = $this->makeIncorrectItem('Palavra', 'Palavra Diferente');

        $list['object'] = $this->makeIncorrectItem(new ObjectOne(''), new ObjectOne('x'));

        $list['integer'] = $this->makeIncorrectItem(44, 45);

        $list['float'] = $this->makeIncorrectItem(44.4, 44.1);

        $list['float zero'] = $this->makeIncorrectItem(44.0, 44.1);

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function valueOneNotEqualToTwo(
        mixed $one,
        mixed $two,
        string $oneString,
        string $twoString
    ): void {
        $assertion = new EqualTo($one, $two);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be equal to '$twoString'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function namedValueOneNotEqualToTwo(
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
            "Value of the field 'name' must be equal to '$twoString'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueOneNotEqualToTwoWithCustomMessageCase(
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
    public function valueOneNotEqualToTwoWithCustomMessage(
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
