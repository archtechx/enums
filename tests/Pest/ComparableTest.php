<?php

it('compare equal enum', function () {
    expect(Status::PENDING->is(Status::PENDING))
        ->toBeTrue()
        ->and(Status::PENDING->is(Status::DONE))
        ->toBeFalse()
        ->and(Role::ADMIN->is(Role::ADMIN))
        ->toBeTrue()
        ->and(Role::ADMIN->is(Role::GUEST))
        ->toBeFalse()
        ->and(Role::ADMIN->is('admin'))
        ->toBeFalse();
});

it('compare not equal enum', function () {
    expect(Status::PENDING->isNot(Status::DONE))
        ->toBeTrue()
        ->and(Status::PENDING->isNot(Status::PENDING))
        ->toBeFalse()
        ->and(Status::PENDING->isNot(Role::ADMIN))
        ->toBeTrue()
        ->and(Role::ADMIN->isNot(Role::GUEST))
        ->toBeTrue()
        ->and(Role::ADMIN->isNot(Role::ADMIN))
        ->toBeFalse()
        ->and(Role::ADMIN->isNot('admin'))
        ->toBeTrue();
});

it('compare in enums', function () {
    expect(Status::PENDING->in([Status::PENDING, Status::DONE]))
        ->toBeTrue()
        ->and(Status::PENDING->in([Status::DONE]))
        ->toBeFalse()
        ->and(Status::PENDING->in([Role::ADMIN, Role::GUEST]))
        ->toBeFalse()
        ->and(Role::ADMIN->in([Role::ADMIN]))
        ->toBeTrue();
});

it('compare not in enums', function () {
    expect(Status::PENDING->notIn([Status::DONE]))
        ->toBeTrue()
        ->and(Status::PENDING->notIn([Status::PENDING, Status::DONE]))
        ->toBeFalse()
        ->and(Role::ADMIN->notIn([Role::GUEST]))
        ->toBeTrue()
        ->and(Role::ADMIN->notIn([Role::ADMIN, Role::GUEST]))
        ->toBeFalse();
});
