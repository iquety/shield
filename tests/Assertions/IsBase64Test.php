<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsBase64;
use stdClass;

class IsBase64Test extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['base64 text 1']  = [base64_encode('Texto123')];
        $list['base64 text 2']  = [base64_encode('abc123')];
        $list['base64 text 3']  = [base64_encode('123xyz')];
        $list['base64 text 4']  = [base64_encode('TextoABC123')];
        $list['base64 text 5']  = [base64_encode('123XYZTexto')];
        $list['base64 text 6']  = [base64_encode('Texto123XYZ')];
        $list['base64 text 7']  = [base64_encode('TextoABC')];
        $list['base64 text 8']  = [base64_encode('abc123xyz')];
        $list['base64 text 9']  = [base64_encode('123')];
        $list['base64 text 10'] = [base64_encode('texto')];
        $list['stringable']     = [$this->makeStringableObject(base64_encode('texto'))];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsBase64(mixed $value): void
    {
        $assertion = new IsBase64($value);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['Not Base64 Text 1'] = $this->makeIncorrectItem('Te&xto123');
        $list['Not Base64 Text 2'] = $this->makeIncorrectItem('abçc123=');
        $list['Not Base64 Text 3'] = $this->makeIncorrectItem('12á3xyz=');
        $list['Not Base64 Text 4'] = $this->makeIncorrectItem('Te^xtoABC123=');
        $list['Not Base64 Text 5'] = $this->makeIncorrectItem('123*XYZTexto=');
        $list['Not Base64 Text 6'] = $this->makeIncorrectItem('Text)o123XYZ=');
        $list['Not Base64 Text 7'] = $this->makeIncorrectItem('Tex(toABC=');
        $list['Not Base64 Text 8']  = $this->makeIncorrectItem('ab@c123xyz=');
        $list['Not Base64 Text 9']  = $this->makeIncorrectItem('13#23=');
        $list['Not Base64 Text 10'] = $this->makeIncorrectItem('t$exto=');
        $list['Not Base64 Text 11'] = $this->makeIncorrectItem('%+');
        $list['Not Base64 Text 12'] = $this->makeIncorrectItem('&/');
        $list['Not Base64 Text 13'] = $this->makeIncorrectItem('_=');
        $list['Not Base64 Text 14'] = $this->makeIncorrectItem('&=+==');
        $list['Not Base64 Text 15'] = $this->makeIncorrectItem('&+/=');
        $list['Not Base64 Text 16'] = $this->makeIncorrectItem('&+/==');
        $list['empty string']       = $this->makeIncorrectItem('');
        $list['one space string']   = $this->makeIncorrectItem(' ');
        $list['two spaces string']  = $this->makeIncorrectItem('  ');
        $list['boolean']            = $this->makeIncorrectItem(false);
        $list['array']              = $this->makeIncorrectItem(['a']);
        $list['object']             = $this->makeIncorrectItem(new stdClass());
        $list['false']              = $this->makeIncorrectItem(false);
        $list['true']               = $this->makeIncorrectItem(true);
        $list['null']               = $this->makeIncorrectItem(null);
        $list['stringable']         = $this->makeIncorrectItem($this->makeStringableObject('&+/=='));

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotBase64(mixed $value): void
    {
        $assertion = new IsBase64($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid base64 string"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotBase64(mixed $value): void
    {
        $assertion = new IsBase64($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid base64 string"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotBase64AndCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsBase64($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotBase64WithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsBase64($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
