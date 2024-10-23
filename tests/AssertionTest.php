<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;
use Tests\TestCase;

class AssertionTest extends TestCase
{
    /** @test */
    public function assertionNamedExecution(): void
    {
        $object = new class extends Assertion
        {
            public function isValid(): bool
            {
                return true;
            }
    
            public function getDefaultMessage(): Message
            {
                return new Message('{{ value }} / {{ assert-value }}');
            }

            public function getDefaultNamedMessage(): Message
            {
                return new Message('Named {{ field }} = {{ value }} / {{ assert-value }}');
            }
        };

        $object->setFieldName('email');
        $object->setValue('valor');
        $object->setAssertValue('valor aferido');

        $this->assertSame('email', $object->getFieldName());
        $this->assertSame('valor', $object->getValue());
        $this->assertSame('valor aferido', $object->getAssertValue());

        $this->assertTrue($object->isValid());

        $this->assertSame(
            'Named email = valor / valor aferido',
            $object->makeMessage()
        );

        $object->message('Campo: {{ field }}; Valor: {{ value }}; Aferido: {{ assert-value }}');

        $this->assertSame(
            'Campo: email; Valor: valor; Aferido: valor aferido',
            $object->makeMessage()
        );
    }

    /** @test */
    public function assertionExecution(): void
    {
        $object = new class extends Assertion
        {
            public function isValid(): bool
            {
                return true;
            }
    
            public function getDefaultMessage(): Message
            {
                return new Message('{{ value }} / {{ assert-value }}');
            }

            public function getDefaultNamedMessage(): Message
            {
                return new Message('Named {{ field }} = {{ value }} / {{ assert-value }}');
            }
        };

        $object->setValue('valor');
        $object->setAssertValue('valor aferido');

        $this->assertSame('', $object->getFieldName());
        $this->assertSame('valor', $object->getValue());
        $this->assertSame('valor aferido', $object->getAssertValue());

        $this->assertTrue($object->isValid());

        $this->assertSame(
            'valor / valor aferido',
            $object->makeMessage()
        );

        $object->message('Campo: {{ field }}; Valor: {{ value }}; Aferido: {{ assert-value }}');

        $this->assertSame(
            'Campo: ; Valor: valor; Aferido: valor aferido',
            $object->makeMessage()
        );
    }
}
