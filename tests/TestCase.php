<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
abstract class TestCase extends FrameworkTestCase
{
    protected function mockMethodReturn(MockObject &$mock, string $methodName, mixed $returnValue): void
    {
        $mock->method($methodName)
            ->willReturn($returnValue);
    }

    // protected function getFakeUserRepository(): UserRepository
    // {
    //     $stub = $this->createStub(UserRepository::class);

    //     /** @var MockObject $stub */
    //     $stub->method('nextIdentity')
    //         ->willReturn('5d1fd2d6-c500-4d0c-95b2-1b239dc5ec21');

    //     /** @var UserRepository $stub */
    //     return $stub;
    // }
}
