<?php

use ArchTech\Enums\Exceptions\UndefinedCaseError;

it('can be used as a static method', function () {
    expect(Status::PENDING())->toBe(0);
    expect(Status::DONE())->toBe(1);
});

it('can be invoked as an instance', function () {
    $status = Status::PENDING;

    expect($status())->toBe(0);
    expect($status())->toBe($status->value);
});

it('throws an error when a nonexistent case is being used', function () {
    Status::INVALID();
})->expectException(UndefinedCaseError::class);
