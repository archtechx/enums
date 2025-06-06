<?php

declare(strict_types=1);

use ArchTech\Enums\Exceptions\UndefinedCaseError;

it('can be used as a static method with backed enums', function () {
    expect(Status::PENDING())->toBe(0);
    expect(Status::DONE())->toBe(1);
});

it('can be used as a static method with pure enums', function () {
    expect(Role::ADMIN())->toBe('ADMIN');
    expect(Role::GUEST())->toBe('GUEST');
});

it('can be invoked as an instance as a backed enum', function () {
    $status = Status::PENDING;

    expect($status())->toBe(0);
    expect($status())->toBe($status->value);
});

it('can be invoked as an instance as a pure enum', function () {
    $role = Role::ADMIN;

    expect($role())->toBe('ADMIN');
});

it('throws an error when a nonexistent case is being used for backed enums', function () {
    Status::INVALID();
})->expectException(UndefinedCaseError::class);

it('throws an error when a nonexistent case is being used for pure enums', function () {
    Role::INVALID();
})->expectException(UndefinedCaseError::class);
