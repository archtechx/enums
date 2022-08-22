<?php

use ArchTech\Enums\Tests\PHPStan\InvokableCases\InvokableCasesTestCase;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;

uses(InvokableCasesTestCase::class);

it('correctly identifies allowable static method calls for invokable pure enum', function () {
    $class = \ArchTech\Enums\Tests\PHPStan\InvokableCases\Role::class;

    // Base enum
    $this->assertStaticallyCallable($class, 'cases');
    $this->assertStaticallyCallable($class, 'from', false);
    $this->assertStaticallyCallable($class, 'tryFrom', false);

    // Defined methods
    $this->assertStaticallyCallable($class, 'administrator');
    $this->assertStaticallyCallable($class, 'isManager', true, false);

    // Cases
    $this->assertStaticallyCallable($class, 'admin');
    $this->assertStaticallyCallable($class, 'manager');
    $this->assertStaticallyCallable($class, 'staff');

    // Missing Case
    $this->assertStaticallyCallable($class, 'customer', false);
});

it('correctly identifies allowable static method calls for invokable int backed enum', function () {
    $class = \ArchTech\Enums\Tests\PHPStan\InvokableCases\Status::class;

    // Base enum
    $this->assertStaticallyCallable($class, 'cases');
    $this->assertStaticallyCallable($class, 'from');
    $this->assertStaticallyCallable($class, 'tryFrom');

    // Defined methods
    $this->assertStaticallyCallable($class, 'initial');
    $this->assertStaticallyCallable($class, 'isStarted', true, false);

    // Cases
    $this->assertStaticallyCallable($class, 'created');
    $this->assertStaticallyCallable($class, 'running');
    $this->assertStaticallyCallable($class, 'done');

    // Missing Case
    $this->assertStaticallyCallable($class, 'failed', false);
});

it('correctly identifies allowable static method calls for invokable string backed enum', function () {
    $class = \ArchTech\Enums\Tests\PHPStan\InvokableCases\Suits::class;

    // Base enum
    $this->assertStaticallyCallable($class, 'cases');
    $this->assertStaticallyCallable($class, 'from');
    $this->assertStaticallyCallable($class, 'tryFrom');

    // Defined methods
    $this->assertStaticallyCallable($class, 'valuable');
    $this->assertStaticallyCallable($class, 'isRed', true, false);

    // Cases
    $this->assertStaticallyCallable($class, 'clubs');
    $this->assertStaticallyCallable($class, 'diamonds');
    $this->assertStaticallyCallable($class, 'hearts');
    $this->assertStaticallyCallable($class, 'spades');

    // Missing Case
    $this->assertStaticallyCallable($class, 'joker', false);
});

it('correctly identifies types for invoked pure enum cases', function () {
    $class = \ArchTech\Enums\Tests\PHPStan\InvokableCases\Role::class;

    // Cases
    $this->assertStaticallyCallableType($class, 'admin', StringType::class);
    $this->assertStaticallyCallableType($class, 'manager', StringType::class);
    $this->assertStaticallyCallableType($class, 'staff', StringType::class);
});

it('correctly identifies types for invoked int backed enum cases', function () {
    $class = \ArchTech\Enums\Tests\PHPStan\InvokableCases\Status::class;

    // Cases
    $this->assertStaticallyCallableType($class, 'created', IntegerType::class);
    $this->assertStaticallyCallableType($class, 'running', IntegerType::class);
    $this->assertStaticallyCallableType($class, 'done', IntegerType::class);
});

it('correctly identifies types for invoked string backed enum cases', function () {
    $class = \ArchTech\Enums\Tests\PHPStan\InvokableCases\Suits::class;

    // Cases
    $this->assertStaticallyCallableType($class, 'clubs', StringType::class);
    $this->assertStaticallyCallableType($class, 'diamonds', StringType::class);
    $this->assertStaticallyCallableType($class, 'hearts', StringType::class);
    $this->assertStaticallyCallableType($class, 'spades', StringType::class);
});
