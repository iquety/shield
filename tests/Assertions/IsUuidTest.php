<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsUuid;
use Tests\TestCase;

class IsUuidTest extends TestCase
{
    /** @return array<string, array<int, mixed>> */
    public function correctValueProvider(): array
    {
        return [
            'uuid_1' => ['3f2504e0-4f89-41d3-9a0c-0305e82c3301'],
            'uuid_2' => ['550e8400-e29b-41d4-a716-446655440000'],
            'uuid_3' => ['6ba7b810-9dad-11d1-80b4-00c04fd430c8'],
        ];
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $uuidString): void
    {
        $assertion = new IsUuid($uuidString);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string, array<int, mixed>> */
    public function incorrectValueProvider(): array
    {
        return [
            'Invalid UUID - missing segments' => ['12345678-9012-3456'],
            'Invalid UUID - too short' => ['1234567890123456789012345'],
            'Invalid UUID - too long' => ['12345678-9012-3456-7890-123456789012345678901234567890'],
            'Invalid UUID - invalid characters' => ['12345678-ABCD-WXYZ-9012-345678901234'],
            'Invalid UUID - missing dashes' => ['1234567890123456789012345'],
            'Invalid UUID - empty string' => [''],
            'Invalid UUID - spaces' => ['   '],
            'Invalid UUID - special characters' => ['1234*&^%$#@!~-9012-456-7890-123456789012'],
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $uuidString): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $uuidString): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $uuidString): void
    {
        $assertion = new IsUuid($uuidString);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $uuidString está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $uuidString): void
    {
        $assertion = new IsUuid($uuidString);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $uuidString está errado");
    }
}
