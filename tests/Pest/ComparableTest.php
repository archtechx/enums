<?php

declare(strict_types=1);

test('the is method checks for equality', function () {
    expect(Status::PENDING->is(Status::PENDING))->toBeTrue();
    expect(Status::PENDING->is(Status::DONE))->toBeFalse();
    expect(Role::ADMIN->is(Role::ADMIN))->toBeTrue();

    expect(Role::ADMIN->is(Role::GUEST))->toBeFalse();
    expect(Role::ADMIN->is('admin'))->toBeFalse();
});

it('the isNot method checks for inequality', function () {
    expect(Status::PENDING->isNot(Status::DONE))->toBeTrue();
    expect(Status::PENDING->isNot(Status::PENDING))->toBeFalse();
    expect(Status::PENDING->isNot(Role::ADMIN))->toBeTrue();
    expect(Role::ADMIN->isNot(Role::GUEST))->toBeTrue();

    expect(Role::ADMIN->isNot(Role::ADMIN))->toBeFalse();
    expect(Role::ADMIN->isNot('admin'))->toBeTrue();
});

it('the in method checks for presence in an array', function () {
    expect(Status::PENDING->in([Status::PENDING, Status::DONE]))->toBeTrue();
    expect(Role::ADMIN->in([Role::ADMIN]))->toBeTrue();

    $iterator = new ArrayIterator([Status::PENDING, Status::DONE]);
    expect(Status::PENDING->in($iterator))->toBeTrue();
    expect(Status::DONE->in($iterator))->toBeTrue();
    expect(Status::PENDING->in(new ArrayIterator([Role::ADMIN, Role::GUEST])))->toBeFalse();

    expect(Status::PENDING->in([Status::DONE]))->toBeFalse();
    expect(Status::PENDING->in([Role::ADMIN, Role::GUEST]))->toBeFalse();
});

it('the not in method checks for absence in an array', function () {
    expect(Status::PENDING->notIn([Status::DONE]))->toBeTrue();
    expect(Role::ADMIN->notIn([Role::GUEST]))->toBeTrue();

    expect(Status::PENDING->notIn([Status::PENDING, Status::DONE]))->toBeFalse();
    expect(Role::ADMIN->notIn([Role::ADMIN, Role::GUEST]))->toBeFalse();
});

test('the in and notIn methods work with Laravel collections', function () {
    expect(Status::PENDING->in(collect([Status::PENDING, Status::DONE])))->toBeTrue();
    expect(Role::ADMIN->in(collect([Status::PENDING, Role::GUEST])))->toBeFalse();

    expect(Status::DONE->notIn(collect([Status::PENDING])))->toBeTrue();
    expect(Role::ADMIN->notIn(collect([Role::ADMIN, Status::PENDING])))->toBeFalse();
});
