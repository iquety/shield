<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\EqualTo;
use Tests\Stubs\ObjectOne;

class EqualToTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
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

        $list['null'] = [null, null];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valuesAreEquals(mixed $valueOne, mixed $valueTwo): void
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
    public function invalidProvider(): array
    {
        $list = [];

        $typeValues = [
            'string'     => 'Palavra Diferente',
            'object'     => new ObjectOne('x'),
            'integer'    => 45,
            'float'      => 44.1,
            'float zero' => 44.1,
        ];

        foreach($typeValues as $type => $value) {
            $list["string != $type"]     = $this->makeIncorrectItem("Palavra", $value);
            $list["object != $type"]     = $this->makeIncorrectItem(new ObjectOne(''), $value);
            $list["integer != $type"]    = $this->makeIncorrectItem(44, $value);
            $list["float != $type"]      = $this->makeIncorrectItem(44.4, $value);
            $list["float zero != $type"] = $this->makeIncorrectItem(44.0, $value);
            $list["null != $type"]       = $this->makeIncorrectItem(null, $value);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function valuesAreNotEquals(
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
     * @dataProvider invalidProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function namedValuesAreNotEquals(
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
     * @dataProvider invalidProvider
     */
    public function namedValuesAreNotEqualsWithCustomMessageCase(
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
     * @dataProvider invalidProvider
     */
    public function valuesAreNotEqualsWithCustomMessage(
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
