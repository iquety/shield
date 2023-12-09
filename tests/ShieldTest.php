<?php

declare(strict_types=1);

namespace Tests;

use DomainException;
use Exception;
use InvalidArgumentException;
use Iquety\Shield\Shield;
use RuntimeException;
use Tests\Stubs\AssertionNotValid;
use Tests\Stubs\AssertionValid;
use Tests\TestCase;

class ShieldTest extends TestCase
{
    /** @test */
    public function assertNoErrors(): void
    {
        $instance = new Shield();

        $instance->assert(new AssertionValid());
        $instance->assert(new AssertionValid());
        $instance->assert(new AssertionValid());

        $this->assertFalse($instance->hasErrors());
        $this->assertCount(0, $instance->getErrorList());
    }

    /** @test */
    public function assertErrors(): void
    {
        $instance = new Shield();

        $instance->assert(new AssertionValid());
        $instance->assert(new AssertionNotValid());
        $instance->assert(new AssertionNotValid());

        $this->assertTrue($instance->hasErrors());

        $this->assertCount(2, $instance->getErrorList());
    }

    /** @test */
    public function identityMethod(): void
    {
        $instance = new Shield();

        $assertionOne   = new AssertionNotValid();
        $assertionTwo   = new AssertionNotValid();
        $assertionThree = new AssertionNotValid();

        $instance->assert($assertionOne)->identity('one');
        $instance->assert($assertionTwo)->identity('two');
        $instance->assert($assertionThree)->identity('three');

        $this->assertEquals($assertionOne->getIdentity(), 'one');
        $this->assertEquals($assertionTwo->getIdentity(), 'two');
        $this->assertEquals($assertionThree->getIdentity(), 'three');

        $this->assertEquals($instance->getErrorList()[0]->getIdentity(), 'one');
        $this->assertEquals($instance->getErrorList()[1]->getIdentity(), 'two');
        $this->assertEquals($instance->getErrorList()[2]->getIdentity(), 'three');
    }

    public function identityExceptionProvider(): array
    {
        $list = [];

        $list[':id:label'] = [ ':name:Meu Nome', 'Invalid format for identity ":name:Meu Nome". Use id:label'];
        $list['id:label:'] = [ 'name:Meu Nome:', 'Invalid format for identity "name:Meu Nome:". Use id:label'];
        $list['id:la:bel'] = [ 'name:Meu :Nome', 'Invalid format for identity "name:Meu :Nome". Use id:label'];
        $list['i:d:label'] = [ 'na:me:Meu Nome', 'Invalid format for identity "na:me:Meu Nome". Use id:label'];

        return $list;
    }

    /**
     * @test
     * @dataProvider identityExceptionProvider
     */
    public function identityMethodException(string $identity, string $exceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $instance = new Shield();

        $assertionOne   = new AssertionNotValid();

        $instance->assert($assertionOne)->identity($identity);
    }

    /** @test */
    public function orThrowMethod(): void
    {
        $instance = new Shield();

        $assertionOne   = new AssertionNotValid();
        $assertionTwo   = new AssertionNotValid();
        $assertionThree = new AssertionNotValid();

        $instance->assert($assertionOne); // default Exception
        $instance->assert($assertionTwo)->orThrow(RuntimeException::class);
        $instance->assert($assertionThree)->orThrow(DomainException::class);

        $this->assertEquals($assertionOne->getExceptionType(), Exception::class);
        $this->assertEquals($assertionTwo->getExceptionType(), RuntimeException::class);
        $this->assertEquals($assertionThree->getExceptionType(), DomainException::class);

        $this->assertEquals($instance->getErrorList()[0]->getExceptionType(), Exception::class);
        $this->assertEquals($instance->getErrorList()[1]->getExceptionType(), RuntimeException::class);
        $this->assertEquals($instance->getErrorList()[2]->getExceptionType(), DomainException::class);
    }

    /** @test */
    public function assertDefaultException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Campo inválido');

        $instance = new Shield();

        $assertionOne   = new AssertionValid('Campo inválido'); // vai passar
        $assertionTwo   = new AssertionNotValid('Campo inválido'); // não vai passar
        $assertionThree = new AssertionValid('Campo inválido'); // vai passar

        $instance->assert($assertionOne);
        $instance->assert($assertionTwo);
        $instance->assert($assertionThree);

        // a exceção padrão será a Exception
        $instance->validOrThrow();
    }

    public function templateProvider(): array
    {
        $list = [];

        $list['id from only id'] = [ 'name', 'Campo {id} é inválido', 'Campo name é inválido'];
        $list['label from only id'] = [ 'name', 'Campo {label} é inválido', 'Campo name é inválido'];
        $list['label from id:label'] = [ 'name:Meu Nome', 'Campo {label} é inválido', 'Campo Meu Nome é inválido'];
        $list['id e label from id:label'] = [ 'name:Meu Nome', 'Campo {id} {label} é inválido', 'Campo name Meu Nome é inválido'];

        return $list;
    }

    /**
     * @test
     * @dataProvider templateProvider
     */
    public function assertExceptionTemplate(string $identity, string $template, string $exceptionMessage): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage($exceptionMessage);

        $instance = new Shield();

        $assertionOne   = new AssertionValid($template); // vai passar
        $assertionTwo   = new AssertionNotValid($template); // não vai passar
        $assertionThree = new AssertionValid($template); // vai passar

        $instance->assert($assertionOne);
        $instance->assert($assertionTwo)->identity($identity);
        $instance->assert($assertionThree);

        // muda a exceção padrão será a RuntimeException
        $instance->validOrThrow();
    }

    /** @test */
    public function assertChangedDefaultException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Campo inválido');

        $instance = new Shield();

        $assertionOne   = new AssertionValid('Campo inválido'); // vai passar
        $assertionTwo   = new AssertionNotValid('Campo inválido'); // não vai passar
        $assertionThree = new AssertionValid('Campo inválido'); // vai passar

        $instance->assert($assertionOne);
        $instance->assert($assertionTwo);
        $instance->assert($assertionThree);

        // muda a exceção padrão será a RuntimeException
        $instance->validOrThrow(RuntimeException::class);
    }

    /** @test */
    public function assertExceptionFromAssertion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo inválido');

        $instance = new Shield();

        $assertionOne   = new AssertionValid('Campo inválido'); // vai passar
        $assertionTwo   = new AssertionNotValid('Campo inválido'); // não vai passar
        $assertionThree = new AssertionValid('Campo inválido'); // vai passar

        $instance->assert($assertionOne); // passou
        $instance->assert($assertionTwo)->orThrow(InvalidArgumentException::class); // não passou
        $instance->assert($assertionThree); // passou

        // a exceção padrão será a Exception
        $instance->validOrThrow();
    }

    /** @test */
    public function assertExceptionPrecedenceFromAssertion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo inválido');

        $instance = new Shield();

        $assertionOne   = new AssertionValid('Campo inválido'); // vai passar
        $assertionTwo   = new AssertionNotValid('Campo inválido'); // não vai passar
        $assertionThree = new AssertionValid('Campo inválido'); // vai passar

        $instance->assert($assertionOne); // passou
        $instance->assert($assertionTwo)->orThrow(InvalidArgumentException::class); // não passou
        $instance->assert($assertionThree); // passou

        // a exceção padrão será a RuntimeException
        $instance->validOrThrow(RuntimeException::class);
    }
}
