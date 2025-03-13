<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\NotEqualTo;
use Tests\Stubs\ObjectOne;

class NotEqualToTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $typeValues = [
            'string'     => 'Palavra Diferente',
            'object'     => new ObjectOne('x'),
            'integer'    => 45,
            'float'      => 44.5,
            'float zero' => 44.1,
        ];

        foreach($typeValues as $type => $value) {
            $list["string != $type"]     = ["Palavra", $value];
            $list["object != $type"]     = [new ObjectOne(''), $value];
            $list["integer != $type"]    = [44, $value];
            $list["float != $type"]      = [44.4, $value];
            $list["float zero != $type"] = [44.0, $value];
            $list["null != $type"]       = [null, $value];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valuesAreNotEquals(mixed $one, mixed $two): void
    {
        $assertion = new NotEqualTo($one, $two);

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
    public function incorrectProvider(): array
    {
        $list = [];

        $list['string']     = $this->makeIncorrectItem('Palavra', 'Palavra');
        $list['object']     = $this->makeIncorrectItem(new ObjectOne(''), new ObjectOne(''));
        $list['integer']    = $this->makeIncorrectItem(44, 44);
        $list['float']      = $this->makeIncorrectItem(44.4, 44.4);
        $list['float zero'] = $this->makeIncorrectItem(44.0, 44.0);
        $list['null']       = $this->makeIncorrectItem(null, null);

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function notAssertedCase(
        mixed $one,
        mixed $two,
        string $oneString,
        string $twoString
    ): void {
        $assertion = new NotEqualTo($one, $two);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be different from '$twoString'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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
            "Value of the field 'name' must be different from '$twoString'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectProvider
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
     * @dataProvider incorrectProvider
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
