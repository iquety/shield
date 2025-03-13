<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsUuid;
use stdClass;

class IsUuidTest extends AssertionCase
{
    /** @return array<string, array<int, mixed>> */
    public function valueProvider(): array
    {
        return [
            'uuid_1' => ['3f2504e0-4f89-41d3-9a0c-0305e82c3301'],
            'uuid_2' => ['550e8400-e29b-41d4-a716-446655440000'],
            'uuid_3' => ['6ba7b810-9dad-11d1-80b4-00c04fd430c8'],
        ];
    }

    /**
     * @test
     * @dataProvider valueProvider
     */
    public function valueIsUuid(mixed $uuidString): void
    {
        $assertion = new IsUuid($uuidString);

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

    /** @return array<string, array<int, mixed>> */
    public function invalueProvider(): array
    {
        return [
            'missing segments'   => $this->makeIncorrectItem('12345678-9012-3456'),
            'too short'          => $this->makeIncorrectItem('1234567890123456789012345'),
            'too long'           => $this->makeIncorrectItem('12345678-9012-3456-7890-123456789012345678901234567890'),
            'invalid characters' => $this->makeIncorrectItem('12345678-ABCD-WXYZ-9012-345678901234'),
            'missing dashes'     => $this->makeIncorrectItem('1234567890123456789012345'),
            'special characters' => $this->makeIncorrectItem('1234*&^%$#@!~-9012-456-7890-123456789012'),
            'empty string'       => $this->makeIncorrectItem(''),
            'one space string'   => $this->makeIncorrectItem(' '),
            'two spaces string'  => $this->makeIncorrectItem('  '),
            'spaces'             => $this->makeIncorrectItem('   '),
            'integer'            => $this->makeIncorrectItem(123456),
            'decimal'            => $this->makeIncorrectItem(123.456),
            'boolen'             => $this->makeIncorrectItem(false),
            'array'              => $this->makeIncorrectItem(['a']),
            'object'             => $this->makeIncorrectItem(new stdClass()),
            'null'               => $this->makeIncorrectItem(null),
        ];
    }

    /**
     * @test
     * @dataProvider invalueProvider
     */
    public function valueIsNotUuid(mixed $uuidString): void
    {
        $assertion = new IsUuid($uuidString);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid UUID"
        );
    }

    /**
     * @test
     * @dataProvider invalueProvider
     */
    public function namedValueIsNotUuid(mixed $uuidString): void
    {
        $assertion = new IsUuid($uuidString);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid UUID"
        );
    }

    /**
     * @test
     * @dataProvider invalueProvider
     */
    public function namedValueIsNotUuidAndCustomMessage(
        mixed $uuidString,
        string $message
    ): void {
        $assertion = new IsUuid($uuidString);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalueProvider
     */
    public function valueIsNotUuidWithCustomMessage(
        mixed $uuidString,
        string $message
    ): void {
        $assertion = new IsUuid($uuidString);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
