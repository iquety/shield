<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsMacAddress;
use stdClass;

class IsMacAddressTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        return [
            'valid mac - colon separated' => ['00:1A:2B:3C:4D:5E'],
            'valid mac - hyphen separated' => ['00-1A-2B-3C-4D-5E'],
            'valid mac - uppercase' => ['00:1A:2B:3C:4D:5E'],
            'valid mac - lowercase' => ['00:1a:2b:3c:4d:5e'],
        ];
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsMacAddress(mixed $macAddress): void
    {
        $assertion = new IsMacAddress($macAddress);

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
            'invalid mac - too short'          => $this->makeIncorrectItem('00:1A:2B:3C:4D'),
            'invalid mac - too long'           => $this->makeIncorrectItem('00:1A:2B:3C:4D:5E:6F'),
            'invalid mac - invalid characters' => $this->makeIncorrectItem('00:1G:2B:3C:4D:5E'),
            'invalid mac - missing separators' => $this->makeIncorrectItem('001A2B3C4D5E'),
            'invalid mac - mixed separators'   => $this->makeIncorrectItem('00:1A-2B:3C-4D:5E'),
            'invalid mac - empty string'       => $this->makeIncorrectItem(''),
            'invalid mac - spaces'             => $this->makeIncorrectItem('00:1A: 2B:3C:4D:5E'),
            'empty string'                     => $this->makeIncorrectItem(''),
            'one space string'                 => $this->makeIncorrectItem(' '),
            'two spaces string'                => $this->makeIncorrectItem('  '),
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
    public function valueIsNotMacAddress(mixed $macAddress): void
    {
        $assertion = new IsMacAddress($macAddress);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid MAC address"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotMacAddress(mixed $macAddress): void
    {
        $assertion = new IsMacAddress($macAddress);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid MAC address"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotMacAddressWithCustomMessage(
        mixed $macAddress,
        string $message
    ): void {
        $assertion = new IsMacAddress($macAddress);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotMacAddressWithCustomMessage(
        mixed $macAddress,
        string $message
    ): void {
        $assertion = new IsMacAddress($macAddress);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
