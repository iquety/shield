<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Exception;
use InvalidArgumentException;

abstract class Assertion
{
    private mixed $actual = '';

    private mixed $comparison = '';

    private string $errorMessage = '';

    private string $identity = '';

    private string $exceptionType = Exception::class;

    abstract public function isValid(): bool;

    public function getActual(): mixed
    {
        return $this->actual;
    }

    public function getComparison(): mixed
    {
        return $this->comparison;
    }

    public function getErrorMessage(): string
    {
        $identity = trim($this->getIdentity(), ":");

        $nodes = explode(':', $identity);

        $tag   = $nodes[0];
        $label = $nodes[1] ?? $tag;

        return str_replace(
            ['{id}', '{label}'],
            [$tag, $label],
            $this->errorMessage
        );
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getExceptionType(): string
    {
        return $this->exceptionType;
    }

    public function setActual(mixed $value): void
    {
        $this->actual = $value;
    }

    public function setComparison(mixed $value): void
    {
        $this->comparison = $value;
    }

    public function setErrorMessage(string $message): void
    {
        $this->errorMessage = $message;
    }

    public function setIdentity(string $identity): void
    {
        if (substr_count($identity, ":") > 1) {
            throw new InvalidArgumentException(
                "Invalid format for identity \"$identity\". Use id:label"
            );
        }

        $this->identity = $identity;
    }

    public function setExceptionType(string $exceptionType): void
    {
        $this->exceptionType = $exceptionType;
    }
}
