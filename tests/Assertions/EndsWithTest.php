<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\EndsWith;
use Tests\TestCase;

class EndsWithTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Palavra'] = ['Palavra', 'vra'];
        $list['Ação'] = ['Ação', 'ão'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $value, string $partial): void
    {
        $assertion = new EndsWith($value, $partial);

        $this->assertTrue($assertion->isValid());
    }

    /** @test */
    public function notAssertedCase(): void
    {
        $assertion = new EndsWith('Palavra', 'va');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must end with 'va'"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertion(): void
    {
        $assertion = new EndsWith('Palavra', 'va');

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must end with 'va'"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(): void
    {
        $assertion = new EndsWith('Palavra', 'va');

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "O valor Palavra está errado");
    }

    /** @test */
    public function notAssertedCaseWithCustomMessage(): void
    {
        $assertion = new EndsWith('Palavra', 'va');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "O valor Palavra está errado");
    }
}
