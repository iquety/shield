<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\NotMatches;
use stdClass;

class NotMatchesTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
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
     * @dataProvider validProvider
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
    public function invalidProvider(): array
    {
        $list = [];

        $list['utf8']         = $this->makeIncorrectItem('Coração de Leão', '/oraç/');
        $list['numeric']      = $this->makeIncorrectItem('123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/');
        $list['decimal']      = $this->makeIncorrectItem(123456.7891, '/(\d{6})\.(\d{4})/');
        // coerção de tipo remove o zero
        //$list['decimal'] = $this->makeIncorrectItem(123456.7890, '/(\d{6})\.(\d{4})/');
        $list['integer']      = $this->makeIncorrectItem(1234567890, '/(\d{5})(\d{5})/');
        $list['latin']        = $this->makeIncorrectItem('Hello World', '/World/');
        $list['array']        = $this->makeIncorrectItem(['Coração', 'Hello World', 'Leão'], '/World/');

        $list['true matches lower true']   = $this->makeIncorrectItem(true, '/true/');
        $list['true matches lower tr']     = $this->makeIncorrectItem(true, '/tr/');
        $list['true matches lower ue']     = $this->makeIncorrectItem(true, '/ue/');
        $list['true matches upper TRUE']   = $this->makeIncorrectItem(true, '/TRUE/');
        $list['true matches upper TR']     = $this->makeIncorrectItem(true, '/TR/');
        $list['true matches upper UE']     = $this->makeIncorrectItem(true, '/UE/');

        $list['false matches lower false'] = $this->makeIncorrectItem(false, '/false/');
        $list['false matches lower fa']    = $this->makeIncorrectItem(false, '/fa/');
        $list['false matches lower se']    = $this->makeIncorrectItem(false, '/se/');
        $list['false matches upper FALSE'] = $this->makeIncorrectItem(false, '/FALSE/');
        $list['false matches upper FA']    = $this->makeIncorrectItem(false, '/FA/');
        $list['false matches upper SE']    = $this->makeIncorrectItem(false, '/SE/');

        $list['null matches lower null'] = $this->makeIncorrectItem(null, '/null/');
        $list['null matches lower nu']   = $this->makeIncorrectItem(null, '/nu/');
        $list['null matches lower ll']   = $this->makeIncorrectItem(null, '/ll/');
        $list['null matches upper NULL'] = $this->makeIncorrectItem(null, '/NULL/');
        $list['null matches upper nu']   = $this->makeIncorrectItem(null, '/NU/');
        $list['null matches upper ll']   = $this->makeIncorrectItem(null, '/LL/');

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
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
     * @dataProvider invalidProvider
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
     * @dataProvider invalidProvider
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
     * @dataProvider invalidProvider
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
