<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Iquety\Shield\Assertion\EqualTo;
use Iquety\Shield\AssertionException;
use Iquety\Shield\Shield;
use ReflectionObject;
use Tests\TestCase;

class ShieldUnamedTest extends TestCase
{
    /** @test */
    public function directAssertion(): void
    {
        $instance = new Shield();

        $instance->assert(new EqualTo('palavra', 'palavra diferente'));
        $instance->assert(new EqualTo('palavra', 'palavra diferente'));

        $this->assertCount(2, $instance->getErrorList());

        $this->assertSame(
            [
                "Value must be equal to 'palavra diferente'",
                "Value must be equal to 'palavra diferente'"
            ],
            $instance->getErrorList()
        );
    }

    /** @test */
    public function hasErrors(): void
    {
        $instance = new Shield();

        $instance->assert(new EqualTo('palavra', 'palavra diferente'));

        $this->assertTrue($instance->hasErrors());
    }

    /** @test */
    public function notHasErrors(): void
    {
        $instance = new Shield();

        $instance->assert(new EqualTo('palavra', 'palavra'));

        $this->assertFalse($instance->hasErrors());
    }

    /** @test */
    public function getErrorList(): void
    {
        $instance = new Shield();

        // mensagem padrão
        $instance->assert(new EqualTo('palavra', 'palavra diferente'));

        // mensagem personalizada
        $instance
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("Primeira mensagem personalizada");

        // mensagem personalizada
        $instance
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("Segunda mensagem personalizada");

        $this->assertSame([
            "Value must be equal to 'palavra diferente'",
            "Primeira mensagem personalizada",
            "Segunda mensagem personalizada"
        ], $instance->getErrorList());
    }

    /** @test */
    public function throwing(): void
    {
        $instance = new Shield();

        // mensagem padrão
        $instance->assert(new EqualTo('palavra', 'palavra diferente'));

        // mensagem personalizada
        $instance
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("Primeira mensagem personalizada");

        // mensagem personalizada
        $instance
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("Segunda mensagem personalizada");

        try {
            $instance->validOrThrow();
        } catch (AssertionException $exception) {
            $this->assertSame([
                "Value must be equal to 'palavra diferente'",
                "Primeira mensagem personalizada",
                "Segunda mensagem personalizada"
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
        $instance->assert(new EqualTo('palavra', 'palavra diferente'));

        // mensagem personalizada
        $instance
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("Primeira mensagem personalizada");

        // mensagem personalizada
        $instance
            ->assert(new EqualTo('palavra', 'palavra diferente'))
            ->message("Segunda mensagem personalizada");

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
