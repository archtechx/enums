<?php

test('pure enums can have metadata on cases', function () {
    expect(Role::ADMIN->color())->toBe('indigo');
    expect(Role::GUEST->color())->toBe('gray');

    expect(Role::ADMIN->description())->toBe('Administrator');
    expect(Role::GUEST->description())->toBe('Read-only guest');

    expect(Role::ADMIN->help())->toBe('Help: Administrators can manage the entire account');
    expect(Role::GUEST->help())->toBe('Help: Guest users can only view the existing records');
});

test('backed enums can have metadata on cases', function () {
    expect(Status::DONE->color())->toBe('green');
    expect(Status::PENDING->color())->toBe('orange');

    expect(Status::PENDING->description())->toBe('Incomplete task');
    expect(Status::DONE->description())->toBe('Completed task');
});

test('meta properties must be enabled on the enum to be usable on cases', function () {
    expect(Role::ADMIN->help())->not()->toBeNull(); // enabled
    expect(Status::DONE->help())->toBeNull(); // not enabled
});

test('meta properties can transform arguments', function () {
    expect(
        Instructions::make('Administrators can manage the entire account')->value
    )->toStartWith('Help: ');
});

test('meta properties can customize the method name using a method', function () {
    expect(Desc::method())->toBe('description');
    expect(Status::DONE->desc())->toBeNull();
    expect(Status::DONE->description())->not()->toBeNull();
});

test('meta properties can customize the method name using a property', function () {
    expect(Instructions::method())->toBe('help');
    expect(Role::ADMIN->instructions())->toBeNull();
    expect(Role::ADMIN->help())->not()->toBeNull();
});

test('enums can be instantiated from metadata', function () {
    expect(Role::fromMeta(Color::make('indigo')))->toBe(Role::ADMIN);
    expect(Role::fromMeta(Color::make('gray')))->toBe(Role::GUEST);

    expect(Status::fromMeta(Desc::make('Incomplete task')))->toBe(Status::PENDING);
    expect(Status::fromMeta(Desc::make('Completed task')))->toBe(Status::DONE);
});

test('enums can be instantiated from metadata using tryFromMeta')
    ->expect(Role::tryFromMeta(Color::make('indigo')))
    ->toBe(Role::ADMIN);

test('fromMeta throws an exception when the enum cannot be instantiated', function () {
    Role::fromMeta(Color::make('foobar'));
})->throws(ValueError::class, 'Enum Role does not have a case with a meta property "Color" of value "foobar"');

test('tryFromMeta silently fails when the enum cannot be instantiated')
    ->expect(Role::tryFromMeta(Color::make('foobar')))
    ->toBeNull();

test('metadata properties return null if missing on the case')
    ->expect(RoleWithoutAttribute::ADMIN->desc())
    ->toBeNull();

test('metadata can have default values')
    ->expect(ReferenceType::INACTIVE_TYPE->isActive())
    ->toBeFalse();
