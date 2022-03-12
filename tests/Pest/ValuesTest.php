<?php

it('can return an array of case values from a backed enum')
    ->expect(Status::values())
    ->toBe([0, 1]);

it('can returns an empty array from a pure enum')
    ->expect(Role::values())
    ->toBe([]);
