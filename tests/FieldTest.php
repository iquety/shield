<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion;
use Iquety\Shield\Field;
use Tests\TestCase;

class FieldTest extends TestCase
{
    /** @test */
    public function getterName(): void
    {
        $field = new Field('name');

        $this->assertEquals('name', $field->getName());
    }

    /** @test */
    public function getErrorList(): void
    {
        $field = new Field('name');

        $this->assertEquals([], $field->getErrorList());
    }

    /** @test */
    public function processAssertionsAndGetErrorList(): void
    {
        $assertionMock = $this->createMock(Assertion::class);
        $assertionMock->method('isValid')->willReturn(false);

        $field = new Field('name');

        /** @var Assertion $assertionMock */
        $field->assert($assertionMock);

        $this->assertCount(1, $field->getErrorList());
    }

    /** @test */
    public function assertAddsAssertionToList(): void
    {
        $assertionMock = $this->createMock(Assertion::class);
        $assertionMock->expects($this->once())->method('setFieldName')->with('name');

        $field = new Field('name');

        /** @var Assertion $assertionMock */
        $field->assert($assertionMock);

        $this->assertCount(1, $field->getErrorList());
    }
}
