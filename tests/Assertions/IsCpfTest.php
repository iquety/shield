<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCpf;
use Tests\TestCase;

class IsCpfTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function validCpfProvider(): array
    {
        return [
            'Valid CPF - 1' => ['187.260.788-80'],
            'Valid CPF - 2' => ['254.659.882-15'],
            'Valid CPF - 2' => ['153.347.537-70'],
            'Valid CPF - 3' => ['18726078880'],
            'Valid CPF - 4' => ['25465988215'],
            'Valid CPF - 5' => ['15334753770'],
        ];
    }

    /**
     * @test
     * @dataProvider validCpfProvider
     */
    public function assertedCase(string $cpf): void
    {
        $assertion = new IsCpf($cpf);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function invalidCpfProvider(): array
    {
        return [
            'Invalid CPF - 0' => ['00000000000'],
            'Invalid CPF - 1' => ['11111111111'],
            'Invalid CPF - 2' => ['22222222222'],
            'Invalid CPF - 3' => ['33333333333'],
            'Invalid CPF - 4' => ['44444444444'],
            'Invalid CPF - 5' => ['55555555555'],
            'Invalid CPF - 6' => ['66666666666'],
            'Invalid CPF - 7' => ['77777777777'],
            'Invalid CPF - 8' => ['88888888888'],
            'Invalid CPF - 9' => ['99999999999'],
            
            'Invalid CPF - 0 signals' => ['000.000.000-00'],
            'Invalid CPF - 1 signals' => ['111.111.111-11'],
            'Invalid CPF - 2 signals' => ['222.222.222-22'],
            'Invalid CPF - 3 signals' => ['333.333.333-33'],
            'Invalid CPF - 4 signals' => ['444.444.444-44'],
            'Invalid CPF - 5 signals' => ['555.555.555-55'],
            'Invalid CPF - 6 signals' => ['666.666.666-66'],
            'Invalid CPF - 7 signals' => ['777.777.777-77'],
            'Invalid CPF - 8 signals' => ['888.888.888-88'],
            'Invalid CPF - 9 signals' => ['999.999.999-99'],

            'Invalid CPF - 1 calc' => ['17734532493'],
            'Invalid CPF - 2 calc' => ['00135829304'],
            'Invalid CPF - 3 calc' => ['12070275460'],
            'Invalid CPF - 4 calc' => ['00138625504'],
            'Invalid CPF - 5 calc' => ['00127436714'],
            'Invalid CPF - 6 calc' => ['00136123694'],
            'Invalid CPF - 7 calc' => ['13090940977'],
            'Invalid CPF - 8 calc' => ['01303816444'],
            'Invalid CPF - 9 calc' => ['00704535034'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidCpfProvider
     */
    public function notAssertedCase(string $cpf): void
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
    public function notAssertedCaseWithNamedAssertion(string $cpf): void
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
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $cpf): void
    {
        $assertion = new IsCpf($cpf);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $cpf está errado");
    }

    /**
     * @test
     * @dataProvider invalidCpfProvider
     */
    public function notAssertedCaseWithCustomMessage(string $cpf): void
    {
        $assertion = new IsCpf($cpf);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $cpf está errado");
    }
}