<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\Matches;
use stdClass;

class MatchesTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['utf8'] = ['Coração de Leão', '/oraç/'];
        $list['numeric'] = ['123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/'];
        $list['decimal'] = [123456.7891, '/(\d{6})\.(\d{4})/'];
        //$list['decimal'] = [123456.7890, '/(\d{6})\.(\d{4})/']; // coerção de tipo remove o zero
        $list['integer'] = [1234567890, '/(\d{5})(\d{5})/'];
        $list['latin'] = ['Hello World', '/World/'];
        $list['array'] = [['Coração', 'Hello World', 'Leão'], '/World/'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     * @param array<mixed>|string $value
     */
    public function valueMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new Matches($value, $pattern);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, string $pattern): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            $pattern,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['utf8'] = $this->makeIncorrectItem('Coração de Leão', '/orax/');
        $list['array'] = $this->makeIncorrectItem(['Coração', 'Hello World', 'Leão'], '/Worlx/');
        $list['decimal'] = $this->makeIncorrectItem(123456.7891, '/(\d{3})456\.7899/');
        $list['integer'] = $this->makeIncorrectItem(1234567890, '/(\d{5})67899/');

        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), '/x/');

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new Matches($value, $pattern);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must match $pattern",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueNotMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new Matches($value, $pattern);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must match $pattern"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueNotMatchesPatternAndCustomMessage(
        mixed $value,
        string $pattern,
        string $message
    ): void {
        $assertion = new Matches($value, $pattern);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotMatchesPatternWithCustomMessage(
        mixed $value,
        string $pattern,
        string $message
    ): void {
        $assertion = new Matches($value, $pattern);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
