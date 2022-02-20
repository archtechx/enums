<?php

it('can return an associative array of options')
    ->expect(Status::options())->toBe([
        'PENDING' => 0,
        'DONE' => 1,
    ]);
