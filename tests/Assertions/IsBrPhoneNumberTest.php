<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsBrPhoneNumber;
use stdClass;

class IsBrPhoneNumberTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        // $list['0300 int']   = [03003134701]; // começa com zero é octal
        // $list['0500 int']   = [05003134701]; // começa com zero é octal
        // $list['0800 int']   = [08007290722]; // Invalid numeric literal
        //$list['0900 int']    = [09003134701]; // Invalid numeric literal
        $list['0300 spaces'] = ["0300 313 4701"];
        $list['0500 spaces'] = ["0500 313 4701"];
        $list['0800 spaces'] = ["0800 729 0722"];
        $list['0900 spaces'] = ["0900 313 4701"];
        $list['0300 dashs']  = ["0300-313-4701"];
        $list['0500 dashs']  = ["0500-313-4701"];
        $list['0800 dashs']  = ["0800-729-0722"];
        $list['0900 dashs']  = ["0900-313-4701"];

        $list['3003 int']    = [30033030];
        $list['4003 int']    = [40033030];
        $list['4004 int']    = [40043030];
        $list['3003 spaces'] = ["3003 3030"];
        $list['4003 spaces'] = ["4003 3030"];
        $list['4004 spaces'] = ["4004 3030"];
        $list['3003 dash']   = ["3003-3030"];
        $list['4003 dash']   = ["4003-3030"];
        $list['4004 dash']   = ["4004-3030"];

        // movel
        $list['mobile int']   = [8799850997];
        $list['mobile digits']   = ["8799850997"];
        $list['mobile formated'] = ["(87) 9985-0997"];
        $list['mobile dashes']   = ["87-9985-0997"];
        $list['mobile spaces']   = ["87 9985 0997"];

        // movel SP
        $list['mobile prefix int']      = [11999850997];
        $list['mobile prefix 9 digits'] = ["11999850997"];
        $list['mobile prefix 9']        = ["(11) 9 9985-0997"];
        $list['mobile prefix 9 dashes'] = ["11-9-9985-0997"];
        $list['mobile prefix 9 spaces'] = ["11 9 9985 0997"];

        $list['stringable'] = [$this->makeStringableObject("11 9 9985 0997")];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsPhoneNumber(mixed $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

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
        return [
            '0300 dots' => $this->makeIncorrectItem("0300.313.4701"),
            '0500 dots' => $this->makeIncorrectItem("0500.313.4701"),
            '0800 dots' => $this->makeIncorrectItem("0800.729.0722"),
            '0900 dots' => $this->makeIncorrectItem("0900.313.4701"),

            '3003 dots' => $this->makeIncorrectItem("3003.3030"),
            '4003 dots' => $this->makeIncorrectItem("4003.3030"),
            '4004 dots' => $this->makeIncorrectItem("4004.3030"),

            // movel
            'mobile' => $this->makeIncorrectItem("(87).9985-0997"),
            'mobile digits' => $this->makeIncorrectItem("87.9985.0997"),

            // movel SP
            'mobile prefix 9' => $this->makeIncorrectItem("(11) 9.9985-0997"),
            'mobile prefix 9 digits' => $this->makeIncorrectItem("11.9.9985.0997"),

            'Invalid Phone - 7 chars' => $this->makeIncorrectItem('1234567'),
            'Invalid Phone - 9 chars' => $this->makeIncorrectItem('123456789'),
            'Invalid Phone - 12 chars' => $this->makeIncorrectItem('123456789012'),

            'Invalid Phone - 7 digits' => $this->makeIncorrectItem('1234-567'),
            'Invalid Phone - 9 digits' => $this->makeIncorrectItem('1234-56789'),
            'Invalid Phone - 12 digits' => $this->makeIncorrectItem('12 345678-9012'),

            'Invalid Phone - invalid characters' => $this->makeIncorrectItem('12A45-678'),
            'Invalid Phone - empty string' => $this->makeIncorrectItem(''),
            'Invalid Phone - special characters' => $this->makeIncorrectItem('123@5-678'),

            'empty string'      => $this->makeIncorrectItem(''),
            'one space string'  => $this->makeIncorrectItem(' '),
            'two spaces string' => $this->makeIncorrectItem('  '),
            'boolean'           => $this->makeIncorrectItem(false),
            'array'             => $this->makeIncorrectItem(['a']),
            'object'            => $this->makeIncorrectItem(new stdClass()),
            'false'             => $this->makeIncorrectItem(false),
            'true'              => $this->makeIncorrectItem(true),
            'null'              => $this->makeIncorrectItem(null),

            'stringable' => $this->makeIncorrectItem($this->makeStringableObject('123@5-678'))
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotPhoneNumber(mixed $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid phone number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueisNotPhoneNumber(mixed $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid phone number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotPhoneNumberAndCustomMessage(mixed $phoneNumber, string $message): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotPhoneNumberWithCustomMessage(mixed $phoneNumber, string $message): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
