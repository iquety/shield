<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsIp;
use Tests\TestCase;

class IsIpTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        return [
            'Valid IP - IPv4' => ['192.168.1.1'],
            'Valid IP - IPv4 loopback' => ['127.0.0.1'],
            'Valid IP - IPv4 broadcast' => ['255.255.255.255'],
            'Valid IP - IPv6' => ['2001:0db8:85a3:0000:0000:8a2e:0370:7334'],
            'Valid IP - IPv6 compressed' => ['2001:db8:85a3::8a2e:370:7334'],
            'Valid IP - IPv6 loopback' => ['::1'],
            'Valid IP - IPv6 unspecified' => ['::'],
        ];
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $ipAddress): void
    {
        $assertion = new IsIp($ipAddress);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        return [
            'Invalid IP - letters' => ['abc.def.ghi.jkl'],
            'Invalid IP - too many octets' => ['192.168.1.1.1'],
            'Invalid IP - missing octets' => ['192.168.1'],
            'Invalid IP - out of range octet' => ['256.256.256.256'],
            'Invalid IP - negative octet' => ['-1.0.0.0'],
            'Invalid IP - IPv6 with invalid characters' => ['2001:db8:85a3::8a2e:370g:7334'],
            'Invalid IP - IPv6 too short' => ['2001:db8:85a3'],
            'Invalid IP - IPv6 too long' => ['2001:0db8:85a3:0000:0000:8a2e:0370:7334:1234'],
            'Invalid IP - empty string' => [''],
            'Invalid IP - spaces' => ['192. 168.1.1'],
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $ipAddress): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $ipAddress): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $ipAddress): void
    {
        $assertion = new IsIp($ipAddress);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $ipAddress está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $ipAddress): void
    {
        $assertion = new IsIp($ipAddress);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $ipAddress está errado");
    }
}
