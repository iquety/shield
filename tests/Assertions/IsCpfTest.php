<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCpf;
use stdClass;

class IsCpfTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validCpfProvider(): array
    {
        return [
            'valid cpf - 1' => ['187.260.788-80'],
            'valid cpf - 2' => ['254.659.882-15'],
            'valid cpf - 3' => ['153.347.537-70'],
            'valid cpf - 4' => ['18726078880'],
            'valid cpf - 5' => ['25465988215'],
            'valid cpf - 6' => ['15334753770'],
            'valid cpf - 7' => [18726078880],
            'valid cpf - 8' => [25465988215],
            'valid cpf - 9' => [15334753770],
            'valid stringable cpf' => [$this->makeStringableObject('15334753770')],
        ];
    }

    /**
     * @test
     * @dataProvider validCpfProvider
     */
    public function valueIsCpf(mixed $cpf): void
    {
        $assertion = new IsCpf($cpf);

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
    public function invalidCpfProvider(): array
    {
        return [
            'invalid cpf - 0' => $this->makeIncorrectItem('00000000000'),
            'invalid cpf - 1' => $this->makeIncorrectItem('11111111111'),
            'invalid cpf - 2' => $this->makeIncorrectItem('22222222222'),
            'invalid cpf - 3' => $this->makeIncorrectItem('33333333333'),
            'invalid cpf - 4' => $this->makeIncorrectItem('44444444444'),
            'invalid cpf - 5' => $this->makeIncorrectItem('55555555555'),
            'invalid cpf - 6' => $this->makeIncorrectItem('66666666666'),
            'invalid cpf - 7' => $this->makeIncorrectItem('77777777777'),
            'invalid cpf - 8' => $this->makeIncorrectItem('88888888888'),
            'invalid cpf - 9' => $this->makeIncorrectItem('99999999999'),

            'invalid integer cpf - 0' => $this->makeIncorrectItem(00000000000),
            'invalid integer cpf - 1' => $this->makeIncorrectItem(11111111111),
            'invalid integer cpf - 2' => $this->makeIncorrectItem(22222222222),
            'invalid integer cpf - 3' => $this->makeIncorrectItem(33333333333),
            'invalid integer cpf - 4' => $this->makeIncorrectItem(44444444444),
            'invalid integer cpf - 5' => $this->makeIncorrectItem(55555555555),
            'invalid integer cpf - 6' => $this->makeIncorrectItem(66666666666),
            'invalid integer cpf - 7' => $this->makeIncorrectItem(77777777777),
            'invalid integer cpf - 8' => $this->makeIncorrectItem(88888888888),
            'invalid integer cpf - 9' => $this->makeIncorrectItem(99999999999),

            'invalid cpf - 0 signals' => $this->makeIncorrectItem('000.000.000-00'),
            'invalid cpf - 1 signals' => $this->makeIncorrectItem('111.111.111-11'),
            'invalid cpf - 2 signals' => $this->makeIncorrectItem('222.222.222-22'),
            'invalid cpf - 3 signals' => $this->makeIncorrectItem('333.333.333-33'),
            'invalid cpf - 4 signals' => $this->makeIncorrectItem('444.444.444-44'),
            'invalid cpf - 5 signals' => $this->makeIncorrectItem('555.555.555-55'),
            'invalid cpf - 6 signals' => $this->makeIncorrectItem('666.666.666-66'),
            'invalid cpf - 7 signals' => $this->makeIncorrectItem('777.777.777-77'),
            'invalid cpf - 8 signals' => $this->makeIncorrectItem('888.888.888-88'),
            'invalid cpf - 9 signals' => $this->makeIncorrectItem('999.999.999-99'),

            'invalid cpf - 1 calc' => $this->makeIncorrectItem('17734532493'),
            'invalid cpf - 2 calc' => $this->makeIncorrectItem('00135829304'),
            'invalid cpf - 3 calc' => $this->makeIncorrectItem('12070275460'),
            'invalid cpf - 4 calc' => $this->makeIncorrectItem('00138625504'),
            'invalid cpf - 5 calc' => $this->makeIncorrectItem('00127436714'),
            'invalid cpf - 6 calc' => $this->makeIncorrectItem('00136123694'),
            'invalid cpf - 7 calc' => $this->makeIncorrectItem('13090940977'),
            'invalid cpf - 8 calc' => $this->makeIncorrectItem('01303816444'),
            'invalid cpf - 9 calc' => $this->makeIncorrectItem('00704535034'),

            'invalid cpf integer- 1 calc' => $this->makeIncorrectItem(17734532493),
            'invalid cpf integer- 2 calc' => $this->makeIncorrectItem(10135829304),
            'invalid cpf integer- 3 calc' => $this->makeIncorrectItem(12070275460),
            'invalid cpf integer- 4 calc' => $this->makeIncorrectItem(10138625504),
            'invalid cpf integer- 5 calc' => $this->makeIncorrectItem(10127436714),
            'invalid cpf integer- 6 calc' => $this->makeIncorrectItem(10136123694),
            'invalid cpf integer- 7 calc' => $this->makeIncorrectItem(13090940977),
            'invalid cpf integer- 8 calc' => $this->makeIncorrectItem(11303816444),
            'invalid cpf integer- 9 calc' => $this->makeIncorrectItem(10704535034),

            'empty string'      => $this->makeIncorrectItem(''),
            'one space string'  => $this->makeIncorrectItem(' '),
            'two spaces string' => $this->makeIncorrectItem('  '),
            'array'             => $this->makeIncorrectItem(['a']),
            'object'            => $this->makeIncorrectItem(new stdClass()),
            'false'             => $this->makeIncorrectItem(false),
            'true'              => $this->makeIncorrectItem(true),
            'null'              => $this->makeIncorrectItem(null),

            'invalid stringable cpf' => $this->makeIncorrectItem($this->makeStringableObject('17734532493')),

        ];
    }

    /**
     * @test
     * @dataProvider invalidCpfProvider
     */
    public function valueIsNotCpf(mixed $cpf): void
    {
        $assertion = new IsCpf($cpf);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid CPF"
        );
    }

    /**
     * @test
     * @dataProvider invalidCpfProvider
     */
    public function namedValueIsNotCpf(mixed $cpf): void
    {
        $assertion = new IsCpf($cpf);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid CPF"
        );
    }

    /**
     * @test
     * @dataProvider invalidCpfProvider
     */
    public function namedValueIsNotCpfAndCustomMessage(mixed $cpf, string $message): void
    {
        $assertion = new IsCpf($cpf);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidCpfProvider
     */
    public function valueIsNotCpfWithCustomMessage(mixed $cpf, string $message): void
    {
        $assertion = new IsCpf($cpf);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
