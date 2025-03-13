<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCpf;
use stdClass;
use Tests\TestCase;

class IsCpfTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validCpfProvider(): array
    {
        return [
            'Valid CPF - 1' => ['187.260.788-80'],
            'Valid CPF - 2' => ['254.659.882-15'],
            'Valid CPF - 3' => ['153.347.537-70'],
            'Valid CPF - 4' => ['18726078880'],
            'Valid CPF - 5' => ['25465988215'],
            'Valid CPF - 6' => ['15334753770'],
            'Valid CPF - 7' => [18726078880],
            'Valid CPF - 8' => [25465988215],
            'Valid CPF - 9' => [15334753770],
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
            'Invalid CPF - 0' => $this->makeIncorrectItem('00000000000'),
            'Invalid CPF - 1' => $this->makeIncorrectItem('11111111111'),
            'Invalid CPF - 2' => $this->makeIncorrectItem('22222222222'),
            'Invalid CPF - 3' => $this->makeIncorrectItem('33333333333'),
            'Invalid CPF - 4' => $this->makeIncorrectItem('44444444444'),
            'Invalid CPF - 5' => $this->makeIncorrectItem('55555555555'),
            'Invalid CPF - 6' => $this->makeIncorrectItem('66666666666'),
            'Invalid CPF - 7' => $this->makeIncorrectItem('77777777777'),
            'Invalid CPF - 8' => $this->makeIncorrectItem('88888888888'),
            'Invalid CPF - 9' => $this->makeIncorrectItem('99999999999'),

            'Invalid integer CPF - 0' => $this->makeIncorrectItem(00000000000),
            'Invalid integer CPF - 1' => $this->makeIncorrectItem(11111111111),
            'Invalid integer CPF - 2' => $this->makeIncorrectItem(22222222222),
            'Invalid integer CPF - 3' => $this->makeIncorrectItem(33333333333),
            'Invalid integer CPF - 4' => $this->makeIncorrectItem(44444444444),
            'Invalid integer CPF - 5' => $this->makeIncorrectItem(55555555555),
            'Invalid integer CPF - 6' => $this->makeIncorrectItem(66666666666),
            'Invalid integer CPF - 7' => $this->makeIncorrectItem(77777777777),
            'Invalid integer CPF - 8' => $this->makeIncorrectItem(88888888888),
            'Invalid integer CPF - 9' => $this->makeIncorrectItem(99999999999),

            'Invalid CPF - 0 signals' => $this->makeIncorrectItem('000.000.000-00'),
            'Invalid CPF - 1 signals' => $this->makeIncorrectItem('111.111.111-11'),
            'Invalid CPF - 2 signals' => $this->makeIncorrectItem('222.222.222-22'),
            'Invalid CPF - 3 signals' => $this->makeIncorrectItem('333.333.333-33'),
            'Invalid CPF - 4 signals' => $this->makeIncorrectItem('444.444.444-44'),
            'Invalid CPF - 5 signals' => $this->makeIncorrectItem('555.555.555-55'),
            'Invalid CPF - 6 signals' => $this->makeIncorrectItem('666.666.666-66'),
            'Invalid CPF - 7 signals' => $this->makeIncorrectItem('777.777.777-77'),
            'Invalid CPF - 8 signals' => $this->makeIncorrectItem('888.888.888-88'),
            'Invalid CPF - 9 signals' => $this->makeIncorrectItem('999.999.999-99'),

            'Invalid CPF - 1 calc' => $this->makeIncorrectItem('17734532493'),
            'Invalid CPF - 2 calc' => $this->makeIncorrectItem('00135829304'),
            'Invalid CPF - 3 calc' => $this->makeIncorrectItem('12070275460'),
            'Invalid CPF - 4 calc' => $this->makeIncorrectItem('00138625504'),
            'Invalid CPF - 5 calc' => $this->makeIncorrectItem('00127436714'),
            'Invalid CPF - 6 calc' => $this->makeIncorrectItem('00136123694'),
            'Invalid CPF - 7 calc' => $this->makeIncorrectItem('13090940977'),
            'Invalid CPF - 8 calc' => $this->makeIncorrectItem('01303816444'),
            'Invalid CPF - 9 calc' => $this->makeIncorrectItem('00704535034'),

            'Invalid CPF integer- 1 calc' => $this->makeIncorrectItem(17734532493),
            'Invalid CPF integer- 2 calc' => $this->makeIncorrectItem(10135829304),
            'Invalid CPF integer- 3 calc' => $this->makeIncorrectItem(12070275460),
            'Invalid CPF integer- 4 calc' => $this->makeIncorrectItem(10138625504),
            'Invalid CPF integer- 5 calc' => $this->makeIncorrectItem(10127436714),
            'Invalid CPF integer- 6 calc' => $this->makeIncorrectItem(10136123694),
            'Invalid CPF integer- 7 calc' => $this->makeIncorrectItem(13090940977),
            'Invalid CPF integer- 8 calc' => $this->makeIncorrectItem(11303816444),
            'Invalid CPF integer- 9 calc' => $this->makeIncorrectItem(10704535034),

            'empty string'      => $this->makeIncorrectItem(''),
            'one space string'  => $this->makeIncorrectItem(' '),
            'two spaces string' => $this->makeIncorrectItem('  '),
            'array'             => $this->makeIncorrectItem(['a']),
            'object'            => $this->makeIncorrectItem(new stdClass()),
            'false'             => $this->makeIncorrectItem(false),
            'true'              => $this->makeIncorrectItem(true),
            'null'              => $this->makeIncorrectItem(null),
            
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
