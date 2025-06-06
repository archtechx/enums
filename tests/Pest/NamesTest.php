<?php

declare(strict_types=1);

it('can return an array of case names from backed enums')
    ->expect(Status::names())
    ->toBe(['PENDING', 'DONE']);

it('can return an array of case names from pure enums')
    ->expect(Role::names())
    ->toBe(['ADMIN', 'GUEST']);
