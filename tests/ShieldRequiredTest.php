<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion;
use Iquety\Shield\Assertion\IsRequired;
use Iquety\Shield\CreditCardBrand;
use Iquety\Shield\Shield;

class ShieldRequiredTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function collectAssertionList(): array
    {
        return [
            'Iquety\\Shield\\Assertion\\Contains'             => ['', 'needle'],
            'Iquety\\Shield\\Assertion\\EndsWith'             => ['', 'needle'],
            'Iquety\\Shield\\Assertion\\EqualTo'              => ['', 'needle'],
            'Iquety\\Shield\\Assertion\\GreaterThanOrEqualTo' => ['', 5],
            'Iquety\\Shield\\Assertion\\GreaterThan'          => ['', 5],
            'Iquety\\Shield\\Assertion\\IsAlphaNumeric'       => [''],
            'Iquety\\Shield\\Assertion\\IsAlpha'              => [''],
            'Iquety\\Shield\\Assertion\\IsAmountTime'         => [''],
            'Iquety\\Shield\\Assertion\\IsBase64'             => [''],
            'Iquety\\Shield\\Assertion\\IsBrPhoneNumber'      => [''],
            'Iquety\\Shield\\Assertion\\IsCep'                => [''],
            'Iquety\\Shield\\Assertion\\IsCpf'                => [''],
            'Iquety\\Shield\\Assertion\\IsCreditCardBrand'    => ['', CreditCardBrand::VISA],
            'Iquety\\Shield\\Assertion\\IsCreditCard'         => [''],
            'Iquety\\Shield\\Assertion\\IsCvv'                => ['', CreditCardBrand::VISA],
            'Iquety\\Shield\\Assertion\\IsDate'               => [''],
            'Iquety\\Shield\\Assertion\\IsDateTime'           => [''],
            'Iquety\\Shield\\Assertion\\IsEmail'              => [''],
            'Iquety\\Shield\\Assertion\\IsEmpty'              => [''],
            'Iquety\\Shield\\Assertion\\IsFalse'              => [''],
            'Iquety\\Shield\\Assertion\\IsHexadecimal'        => [''],
            'Iquety\\Shield\\Assertion\\IsHexColor'           => [''],
            'Iquety\\Shield\\Assertion\\IsIp'                 => [''],
            'Iquety\\Shield\\Assertion\\IsMacAddress'         => [''],
            'Iquety\\Shield\\Assertion\\IsNotNull'            => [''],
            'Iquety\\Shield\\Assertion\\IsNull'               => [''],
            'Iquety\\Shield\\Assertion\\IsTime'               => [''],
            'Iquety\\Shield\\Assertion\\IsTrue'               => [''],
            'Iquety\\Shield\\Assertion\\IsUrl'                => [''],
            'Iquety\\Shield\\Assertion\\IsUuid'               => [''],
            'Iquety\\Shield\\Assertion\\Length'               => ['', 5],
            'Iquety\\Shield\\Assertion\\LessThanOrEqualTo'    => ['', 5],
            'Iquety\\Shield\\Assertion\\LessThan'             => ['', 5],
            'Iquety\\Shield\\Assertion\\Matches'              => ['', '/pattern/'],
            'Iquety\\Shield\\Assertion\\MaxLength'            => ['', 5],
            'Iquety\\Shield\\Assertion\\MinLength'            => ['', 5],
            'Iquety\\Shield\\Assertion\\NotContains'          => ['', 'needle'],
            'Iquety\\Shield\\Assertion\\NotEqualTo'           => ['', 'needle'],
            'Iquety\\Shield\\Assertion\\NotMatches'           => ['', '/pattern/'],
            'Iquety\\Shield\\Assertion\\StartsWith'           => ['', 'needle'],
        ];
    }

    /** @test */
    public function fieldAssertion(): void
    {
        $instance = new Shield();

        foreach ($this->collectAssertionList() as $assertion => $argumentList) {
            /** @var Assertion $assertionInstance */
            $assertionInstance = new $assertion(... $argumentList);

            $instance->field('name')->assert($assertionInstance);
        }

        $instance->field('name')->assert(new IsRequired('xxx'));

        $this->assertFalse($instance->hasErrors());
    }

    /** @test */
    public function fieldNotAssertion(): void
    {
        $instance = new Shield();

        foreach ($this->collectAssertionList() as $assertion => $argumentList) {
            /** @var Assertion $assertionInstance */
            $assertionInstance = new $assertion(... $argumentList);

            $instance->field('name')->assert($assertionInstance);
        }

        $instance->field('name')->assert(new IsRequired(''));

        $this->assertCount(1, $instance->getErrorList());

        $this->assertSame(
            [
                'name' => [
                    "Value of the field 'name' is required"
                ],
            ],
            $instance->getErrorList()
        );
    }

    /** @test */
    public function directAssertion(): void
    {
        $instance = new Shield();

        foreach ($this->collectAssertionList() as $assertion => $argumentList) {
            /** @var Assertion $assertionInstance */
            $assertionInstance = new $assertion(... $argumentList);

            $instance->assert($assertionInstance);
        }

        $instance->assert(new IsRequired('xxxx'));

        $this->assertFalse($instance->hasErrors());
    }

    /** @test */
    public function directNotAssertion(): void
    {
        $instance = new Shield();

        foreach ($this->collectAssertionList() as $assertion => $argumentList) {
            /** @var Assertion $assertionInstance */
            $assertionInstance = new $assertion(... $argumentList);

            $instance->assert($assertionInstance);
        }

        $instance->assert(new IsRequired(''));

        $this->assertCount(1, $instance->getErrorList());

        $this->assertSame(
            [
                'Value is required'
            ],
            $instance->getErrorList()
        );
    }
}
