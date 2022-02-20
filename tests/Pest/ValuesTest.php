<?php

it('can return an array of case values')
    ->expect(Status::values())
    ->toBe([0, 1]);
