<?php

it('does not override the default BackedEnum from method')
    ->expect(Status::from(0))
    ->toBe(Status::PENDING);

it('does not override the default BackedEnum from method with errors', function () {
    Status::from(2);
})->throws(\ValueError::class, '2 is not a valid backing value for enum "Status"');

it('does not override the default BackedEnum tryFrom method')
    ->expect(Status::tryFrom(1))
    ->toBe(Status::DONE);

it('does not override the default BackedEnum tryFrom method with errors')
    ->expect(Status::tryFrom(2))
    ->toBe(null);

it('can select a case by index with from() for pure enums')
    ->expect(Role::from(0))
    ->toBe(Role::ADMIN);

it('throws a value error when selecting a non-existent case by index with from() for pure enums', function () {
    Role::from(2);
})->throws(\ValueError::class, '2 is not a valid unit for enum "Role"');

it('can select a case by index with tryFrom() for pure enums')
    ->expect(Role::tryFrom(1))
    ->toBe(Role::GUEST);

it('can returns null when selecting a non-existent case by index with tryFrom() for pure enums')
    ->expect(Role::tryFrom(2))
    ->toBe(null);

it('can select a case by name with fromName() for pure enums')
    ->expect(Role::fromName('ADMIN'))
    ->toBe(Role::ADMIN);

it('throws a value error when selecting a non-existent case by name with fromName() for pure enums', function () {
    Role::fromName('NOTHING');
})->throws(\ValueError::class, '"NOTHING" is not a valid name for enum "Role"');

it('can select a case by name with tryFromName() for pure enums')
    ->expect(Role::tryFromName('GUEST'))
    ->toBe(Role::GUEST);

it('returns null when selecting a non-existent case by name with tryFromName() for pure enums')
    ->expect(Role::tryFromName('NOTHING'))
    ->toBe(null);

it('can select a case by name with fromName() for backed enums')
    ->expect(Status::fromName('PENDING'))
    ->toBe(Status::PENDING);

it('throws a value error when selecting a non-existent case by name with fromName() for backed enums', function () {
    Status::fromName('NOTHING');
})->throws(\ValueError::class, '"NOTHING" is not a valid name for enum "Status"');

it('can select a case by name with tryFromName() for backed enums')
    ->expect(Status::tryFromName('DONE'))
    ->toBe(Status::DONE);

it('returns null when selecting a non-existent case by name with tryFromName() for backed enums')
    ->expect(Status::tryFromName('NOTHING'))
    ->toBe(null);
