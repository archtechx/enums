<?php

it('can return an array of case names')
    ->expect(Status::names())
    ->toBe(['PENDING', 'DONE']);
