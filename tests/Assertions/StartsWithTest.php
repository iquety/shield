<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\StartsWith;
use Tests\TestCase;

class StartsWithTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Palavra'] = ['Palavra', 'Pal'];
        $list['Ação'] = ['Ação', 'Aç'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $value, string $partial): void
    {
        $assertion = new StartsWith($value, $partial);

        $this->assertTrue($assertion->isValid());
    }

    /** @test */
    public function notAssertedCase(): void
    {
        $assertion = new StartsWith('Palavra', 'Pla');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must start with 'Pla'"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertion(): void
    {
        $assertion = new StartsWith('Palavra', 'Pla');

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must start with 'Pla'"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(): void
    {
        $assertion = new StartsWith('Palavra', 'Pla');

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "O valor Palavra está errado");
    }

    /** @test */
    public function notAssertedCaseWithCustomMessage(): void
    {
        $assertion = new StartsWith('Palavra', 'Pla');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "O valor Palavra está errado");
    }
}
