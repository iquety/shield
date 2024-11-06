<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Iquety\Shield\Assertion\EqualTo;
use Iquety\Shield\AssertionException;
use Iquety\Shield\Field;
use Iquety\Shield\Shield;
use ReflectionClass;
use ReflectionObject;
use Tests\TestCase;

class ShieldNamedTest extends TestCase
{
    /** @test */
    public function duplicatedNames(): void
    {
        $instance = new Shield();

        $fieldOne = $instance->field('duplicateName');
        $fieldTwo = $instance->field('duplicateName');

        $this->assertInstanceOf(Field::class, $fieldOne);
        $this->assertInstanceOf(Field::class, $fieldTwo);

        $this->assertNotSame($fieldOne, $fieldTwo);
    }

    /** @test */
    public function indexMultipleAdditions(): void
    {
        $instance = new Shield();

        $fieldOne = $instance->field('firstField');
        $fieldTwo = $instance->field('secondField');
        $fieldThree = $instance->field('thirdField');

        $reflection = new ReflectionClass($instance);
        $property = $reflection->getProperty('fieldList');
        $property->setAccessible(true);
        $fieldList = $property->getValue($instance);

        $this->assertCount(3, $fieldList);

        $this->assertSame($fieldOne, $fieldList[0]);
        $this->assertSame($fieldTwo, $fieldList[1]);
        $this->assertSame($fieldThree, $fieldList[2]);
    }

    /** @test */
    public function fieldAssertion(): void
    {
        $instance = new Shield();

        $instance->field('name')->assert(new EqualTo('palavra', 'palavra diferente'));

        $instance->field('name')->assert(new EqualTo('palavra', 'palavra diferente'));

        $instance->field('email')->assert(new EqualTo('palavra', 'palavra diferente'));

        $this->assertCount(2, $instance->getErrorList());

        $this->assertSame(
            [
                'name' => [
                    "Value of the field 'name' must be equal to 'palavra diferente'",
                    "Value of the field 'name' must be equal to 'palavra diferente'"
                ],
                'email' => [
                    "Value of the field 'email' must be equal to 'palavra diferente'"
                ]
            ],
            $instance->getErrorList()
        );
    }

    /** @test */
    public function hasErrors(): void
    {
        $instance = new Shield();

        $instance->field('name')->assert(new EqualTo('palavra', 'palavra diferente'));

        $this->assertTrue($instance->hasErrors());
    }

    /** @test */
    public function notHasErrors(): void
    {
        $instance = new Shield();

        $instance->field('name')->assert(new EqualTo('palavra', 'palavra'));

        $this->assertFalse($instance->hasErrors());
    }

    /** @test */
    public function getErrorList(): void
    {
        $instance = new Shield();

        // mensagem padrão
        $instance->field('name')
            ->assert(new EqualTo('palavra', 'palavra diferente'));

        // mensagem personalizada
        $instance->field('name')
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("O campo '{{ field }}' é legal");

        // mensagem personalizada
        $instance->field('pass')
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("O campo '{{ field }}' tem um valor feio");

        $this->assertSame([
            'name' => [
                "Value of the field 'name' must be equal to 'palavra diferente'",
                "O campo 'name' é legal"
            ],
            'pass' => [
                "O campo 'pass' tem um valor feio"
            ]
        ], $instance->getErrorList());
    }

    /** @test */
    public function throwing(): void
    {
        $instance = new Shield();

        // mensagem padrão
        $instance->field('name')
            ->assert(new EqualTo('palavra', 'palavra diferente'));

        // mensagem personalizada
        $instance->field('name')
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("O campo '{{ field }}' é legal");

        // mensagem personalizada
        $instance->field('pass')
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("O campo '{{ field }}' tem um valor feio");

        try {
            $instance->validOrThrow();
        } catch (AssertionException $exception) {
            $this->assertSame([
                'name' => [
                    "Value of the field 'name' must be equal to 'palavra diferente'",
                    "O campo 'name' é legal"
                ],
                'pass' => [
                    "O campo 'pass' tem um valor feio"
                ]
            ], $exception->getErrorList());

            $this->assertSame(
                'The value was not successfully asserted',
                $exception->getMessage()
            );
        }
    }

    /** @test */
    public function throwingCustomException(): void
    {
        $instance = new Shield();

        // mensagem padrão
        $instance->field('name')
            ->assert(new EqualTo('palavra', 'palavra diferente'));

        // mensagem personalizada
        $instance->field('name')
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("O campo '{{ field }}' é legal");

        // mensagem personalizada
        $instance->field('pass')
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("O campo '{{ field }}' tem um valor feio");

        try {
            $instance->validOrThrow(Exception::class);
        } catch (Exception $exception) {
            $reflection = new ReflectionObject($exception);
            $this->assertFalse($reflection->hasMethod('getErrorList'));

            $this->assertSame(
                'The value was not successfully asserted',
                $exception->getMessage()
            );
        }
    }
}
