<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCep;
use stdClass;

class IsCepTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        return [
            'valid cep - format 1' => ['12345-678'],
            'valid cep - format 2' => ['98765-432'],
            'valid cep - format 3' => ['01000-000'],
            'valid cep - format 4' => ['99999-999'],
            'valid cep - format 5' => [12345678],
            'valid cep - format 6' => [98765432],
            'valid cep - format 7' => [11000000],
            'valid cep - format 8' => [99999999],
            'valid cep - format 9' => ['12345678'],
            'valid cep - format 10' => ['98765432'],
            'valid cep - format 11' => ['11000000'],
            'valid cep - format 12' => ['99999999'],
            'valid cep stringable' => [$this->makeStringableObject('12345-678')]

        ];
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsCep(mixed $cepCode): void
    {
        $assertion = new IsCep($cepCode);

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
    public function invalidProvider(): array
    {
        return [
            'invalid cep - too short'          => $this->makeIncorrectItem('1234-567'),
            'invalid cep - too long'           => $this->makeIncorrectItem('123456-789'),
            'invalid cep - invalid characters' => $this->makeIncorrectItem('12A45-678'),
            'invalid cep - empty string'       => $this->makeIncorrectItem(''),
            'invalid cep - spaces'             => $this->makeIncorrectItem('123 45-678'),
            'invalid cep - special characters' => $this->makeIncorrectItem('123@5-678'),
            'invalid cep - many numbers'       => $this->makeIncorrectItem(123567890),
            'invalid cep - loss numbers'       => $this->makeIncorrectItem(123567),
            'invalid cep stringable'           => $this->makeIncorrectItem($this->makeStringableObject('123@5-678')),
            'empty string'                     => $this->makeIncorrectItem(''),
            'one space string'                 => $this->makeIncorrectItem(' '),
            'two spaces string'                => $this->makeIncorrectItem('  '),
            'decimal'                          => $this->makeIncorrectItem(123.456),
            'array'                            => $this->makeIncorrectItem(['a']),
            'object'                           => $this->makeIncorrectItem(new stdClass()),
            'false'                            => $this->makeIncorrectItem(false),
            'true'                             => $this->makeIncorrectItem(true),
            'null'                             => $this->makeIncorrectItem(null),
        ];
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotCep(mixed $cepCode): void
    {
        $assertion = new IsCep($cepCode);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid CEP"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotCep(mixed $cepCode): void
    {
        $assertion = new IsCep($cepCode);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid CEP"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotCepAndCustomMessage(mixed $cepCode, string $message): void
    {
        $assertion = new IsCep($cepCode);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotCepWithCustomMessage(mixed $cepCode, string $message): void
    {
        $assertion = new IsCep($cepCode);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
