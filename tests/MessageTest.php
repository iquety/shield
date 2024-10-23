<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Message;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function patternProvider(): array
    {
        $list = [];

        $list['only field with left space'] = [
            "Meu campo se chama '{{ field}}'",
            "Meu campo se chama 'email'",
        ];

        $list['only field with right space'] = [
            "Meu campo se chama '{{field }}'",
            "Meu campo se chama 'email'",
        ];

        $list['only field with both spaces'] = [
            "Meu campo se chama '{{ field }}'",
            "Meu campo se chama 'email'",
        ];

        $list['only value with left space'] = [
            "Meu valor se chama '{{ value}}'",
            "Meu valor se chama 'ricardo@gmail.com'",
        ];

        $list['only value with right spaces'] = [
            "Meu valor se chama '{{value }}'",
            "Meu valor se chama 'ricardo@gmail.com'",
        ];
        
        $list['only value with both spaces'] = [
            "Meu valor se chama '{{ value }}'",
            "Meu valor se chama 'ricardo@gmail.com'",
        ];

        $list['only assert value with left space'] = [
            "Minha comparacao é '{{ assert-value}}'",
            "Minha comparacao é 'ricardo.assert@gmail.com'",
        ];

        $list['only assert value with right space'] = [
            "Minha comparacao é '{{assert-value }}'",
            "Minha comparacao é 'ricardo.assert@gmail.com'",
        ];

        $list['only assert value with both spaces'] = [
            "Minha comparacao é '{{ assert-value }}'",
            "Minha comparacao é 'ricardo.assert@gmail.com'",
        ];

        $list['all'] = [
            "Campo é '{{field}}', valor é '{{value}}' e asserção é '{{assert-value}}'",
            "Campo é 'email', valor é 'ricardo@gmail.com' e asserção é 'ricardo.assert@gmail.com'",
        ];

        return $list;
    }

    /**
     * @test
     * @dataProvider patternProvider
     */
    public function makeMessages(string $pattern, string $message): void
    {
        $object = new Message($pattern);

        $this->assertSame(
            $message,
            $object->make('email', 'ricardo@gmail.com', 'ricardo.assert@gmail.com')
        );
    }
}
