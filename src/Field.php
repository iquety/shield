<?php

declare(strict_types=1);

namespace Iquety\Shield;

class Field
{
    /** @var array<int,Assertion> */
    private array $assertionList = [];

    /** @var array<int,Assertion> */
    private array $errorList = [];

    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }


    private function proccess(): void
    {
        foreach ($this->assertionList as $assertion) {
            if ($assertion->isValid() === false) {
                $this->errorList[] = $assertion;
            }
        }
    }

    /** @return array<int,Assertion> */
    public function getErrorList(): array
    {
        if ($this->errorList === []) {
            $this->proccess();
        }

        return $this->errorList;
    }

    public function assert(Assertion $assertion): Assertion
    {
        $index = count($this->assertionList);

        $assertion->setFieldName($this->name);

        $this->assertionList[$index] = $assertion;

        return $this->assertionList[$index];
    }
}
