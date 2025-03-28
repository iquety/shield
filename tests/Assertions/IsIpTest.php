<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsIp;
use stdClass;

class IsIpTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        return [
            'valid ip - ipv4'             => ['192.168.1.1'],
            'valid ip - ipv4 loopback'    => ['127.0.0.1'],
            'valid ip - ipv4 broadcast'   => ['255.255.255.255'],
            'valid ip - ipv6'             => ['2001:0db8:85a3:0000:0000:8a2e:0370:7334'],
            'valid ip - ipv6 compressed'  => ['2001:db8:85a3::8a2e:370:7334'],
            'valid ip - ipv6 loopback'    => ['::1'],
            'valid ip - ipv6 unspecified' => ['::'],
            'valid stringable ip'         => [$this->makeStringableObject('192.168.1.1')],
        ];
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsIp(mixed $ipAddress): void
    {
        $assertion = new IsIp($ipAddress);

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
            'invalid ip - letters'                      => $this->makeIncorrectItem('abc.def.ghi.jkl'),
            'invalid ip - too many octets'              => $this->makeIncorrectItem('192.168.1.1.1'),
            'invalid ip - missing octets'               => $this->makeIncorrectItem('192.168.1'),
            'invalid ip - out of range octet'           => $this->makeIncorrectItem('256.256.256.256'),
            'invalid ip - negative octet'               => $this->makeIncorrectItem('-1.0.0.0'),
            'invalid ip - ipv6 with invalid characters' => $this->makeIncorrectItem('2001:db8:85a3::8a2e:370g:7334'),
            'invalid ip - ipv6 too short'               => $this->makeIncorrectItem('2001:db8:85a3'),

            'invalid ip - ipv6 too long' => $this->makeIncorrectItem('2001:0db8:85a3:0000:0000:8a2e:0370:7334:1234'),
            'invalid ip - empty string'  => $this->makeIncorrectItem(''),
            'invalid ip - spaces'        => $this->makeIncorrectItem('192. 168.1.1'),
            'empty string'               => $this->makeIncorrectItem(''),
            'one space string'           => $this->makeIncorrectItem(' '),
            'two spaces string'          => $this->makeIncorrectItem('  '),
            'array'                      => $this->makeIncorrectItem(['a']),
            'object'                     => $this->makeIncorrectItem(new stdClass()),
            'false'                      => $this->makeIncorrectItem(false),
            'true'                       => $this->makeIncorrectItem(true),
            'null'                       => $this->makeIncorrectItem(null),

            'invalid stringable ip' => $this->makeIncorrectItem($this->makeStringableObject('abc.def.ghi.jkl')),
        ];
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotIp(mixed $ipAddress): void
    {
        $assertion = new IsIp($ipAddress);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid IP address"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotIp(mixed $ipAddress): void
    {
        $assertion = new IsIp($ipAddress);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid IP address"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotIpWithCustomMessage(mixed $ipAddress, string $message): void
    {
        $assertion = new IsIp($ipAddress);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotIpWithCustomMessage(mixed $ipAddress, string $message): void
    {
        $assertion = new IsIp($ipAddress);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
