<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsBrPhoneNumber;
use Tests\TestCase;

class IsBrPhoneNumberTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        return [
            '0300' => ["0300 313 4701"],
            '0500' => ["0500 313 4701"],
            '0800' => ["0800 729 0722"],
            '0900' => ["0900 313 4701"],

            '0300 dashs' => ["0300-313-4701"],
            '0500 dashs' => ["0500-313-4701"],
            '0800 dashs' => ["0800-729-0722"],
            '0900 dashs' => ["0900-313-4701"],

            '3003' => ["3003 3030"],
            '4003' => ["4003 3030"],
            '4004' => ["4004 3030"],

            '3003 dash' => ["3003-3030"],
            '4003 dash' => ["4003-3030"],
            '4004 dash' => ["4004-3030"],

            // movel
            'mobile' => ["(87) 9985-0997" ],
            'mobile dashes' => ["87-9985-0997" ],
            'mobile digits' => ["8799850997" ],
            'mobile spaces' => ["87 9985 0997" ],

            // // movel SP
            'mobile prefix 9' => ["(11) 9 9985-0997" ],
            'mobile prefix 9 dashes' => ["11-9-9985-0997" ],
            'mobile prefix 9 digits' => ["11999850997" ],
            'mobile prefix 9 spaces' => ["11 9 9985 0997" ],
        ];
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {

        return [
            '0300 dots' => ["0300.313.4701"],
            '0500 dots' => ["0500.313.4701"],
            '0800 dots' => ["0800.729.0722"],
            '0900 dots' => ["0900.313.4701"],

            '3003 dots' => ["3003.3030"],
            '4003 dots' => ["4003.3030"],
            '4004 dots' => ["4004.3030"],

            // movel
            'mobile' => ["(87).9985-0997" ],
            'mobile digits' => ["87.9985.0997" ],

            // movel SP
            'mobile prefix 9' => ["(11) 9.9985-0997" ],
            'mobile prefix 9 digits' => ["11.9.9985.0997" ],

            'Invalid Phone - 7 chars' => ['1234567'],
            'Invalid Phone - 9 chars' => ['123456789'],
            'Invalid Phone - 12 chars' => ['123456789012'],

            'Invalid Phone - 7 digits' => ['1234-567'],
            'Invalid Phone - 9 digits' => ['1234-56789'],
            'Invalid Phone - 12 digits' => ['12 345678-9012'],

            'Invalid Phone - invalid characters' => ['12A45-678'],
            'Invalid Phone - empty string' => [''],
            'Invalid Phone - special characters' => ['123@5-678'],
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid phone number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid phone number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $phoneNumber está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $phoneNumber): void
    {
        $assertion = new IsBrPhoneNumber($phoneNumber);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $phoneNumber está errado");
    }
}
