<?php

declare(strict_types=1);

namespace Iquety\Shield;

class Message
{
    private string $pattern = '';

    public function __construct(string $pattern)
    {
        $this->pattern = $this->normalizePattern($pattern);
    }

    public function make(string $fieldName, string $value, string $assertValue): string
    {
        return str_replace(
            ['{{field}}', '{{value}}', '{{assert-value}}'],
            [ $fieldName, $value, $assertValue],
            $this->pattern
        );
    }

    private function normalizePattern(string $pattern): string
    {
        return str_replace(
            ['{{ ', ' }}'],
            ['{{' , '}}' ],
            $pattern
        );
    }
}
