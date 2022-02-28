<?php

it('can return an array of case descriptions')
    ->expect(Status::descriptions())
    ->toBe([0 => 'this is `PENDING` description', 1 => 'this is `DONE` description']);