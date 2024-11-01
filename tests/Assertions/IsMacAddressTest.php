<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsMacAddress;
use Tests\TestCase;

class IsMacAddressTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        return [
            'Valid MAC - colon separated' => ['00:1A:2B:3C:4D:5E'],
            'Valid MAC - hyphen separated' => ['00-1A-2B-3C-4D-5E'],
            'Valid MAC - uppercase' => ['00:1A:2B:3C:4D:5E'],
            'Valid MAC - lowercase' => ['00:1a:2b:3c:4d:5e'],
        ];
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $macAddress): void
    {
        $assertion = new IsMacAddress($macAddress);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        return [
            'Invalid MAC - too short' => ['00:1A:2B:3C:4D'],
            'Invalid MAC - too long' => ['00:1A:2B:3C:4D:5E:6F'],
            'Invalid MAC - invalid characters' => ['00:1G:2B:3C:4D:5E'],
            'Invalid MAC - missing separators' => ['001A2B3C4D5E'],
            'Invalid MAC - mixed separators' => ['00:1A-2B:3C-4D:5E'],
            'Invalid MAC - empty string' => [''],
            'Invalid MAC - spaces' => ['00:1A: 2B:3C:4D:5E'],
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $macAddress): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $macAddress): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $macAddress): void
    {
        $assertion = new IsMacAddress($macAddress);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $macAddress está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $macAddress): void
    {
        $assertion = new IsMacAddress($macAddress);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $macAddress está errado");
    }
}
