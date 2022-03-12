<?php

it('can return an associative array of options from a backed enum')
    ->expect(Status::options())->toBe([
        'PENDING' => 0,
        'DONE' => 1,
    ]);

it('can return an indexed array of options from a pure enum')
    ->expect(Role::options())->toBe([
        0 => 'ADMIN',
        1 => 'GUEST',
    ]);
