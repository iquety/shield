<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\NotMatches;
use stdClass;

class NotMatchesTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['utf8'] = ['Coração de Leão', '/orax/'];
        $list['array'] = [['Coração', 'Hello World', 'Leão'], '/Worlx/'];
        $list['decimal'] = [123456.7891, '/(\d{3})456\.7899/'];
        $list['integer'] = [1234567890, '/(\d{5})67899/'];

        $list['object not valid'] = [new stdClass(), '/x/'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     * @param array<mixed>|string $value
     */
    public function valueNotMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

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

    /** @return array<string,array<int,string>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['utf8'] = $this->makeIncorrectItem('Coração de Leão', '/oraç/');
        $list['numeric'] = $this->makeIncorrectItem('123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/');
        $list['decimal'] = $this->makeIncorrectItem(123456.7891, '/(\d{6})\.(\d{4})/');
        // coerção de tipo remove o zero
        //$list['decimal'] = $this->makeIncorrectItem(123456.7890, '/(\d{6})\.(\d{4})/');
        $list['integer'] = $this->makeIncorrectItem(1234567890, '/(\d{5})(\d{5})/');
        $list['latin'] = $this->makeIncorrectItem('Hello World', '/World/');
        $list['array'] = $this->makeIncorrectItem(['Coração', 'Hello World', 'Leão'], '/World/');

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @param array<mixed>|string $value
     */
    public function valueMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not match $pattern",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @param array<mixed>|string $value
     */
    public function namedValueNotMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not match $pattern"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @param array<mixed>|string $value
     */
    public function namedValueMatchesPatternAndCustomMessage(
        mixed $value,
        string $pattern,
        string $message
    ): void {
        $assertion = new NotMatches($value, $pattern);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @param array<mixed>|string $value
     */
    public function valueMatchesPatternWithCustomMessage(
        mixed $value,
        string $pattern,
        string $message
    ): void {
        $assertion = new NotMatches($value, $pattern);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
