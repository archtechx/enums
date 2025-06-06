<?php

declare(strict_types=1);

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

it('can return a string of options from a backed enum')
    ->expect(Status::stringOptions(fn ($name, $value) => "$name => $value", ', '))
    ->toBe("PENDING => 0, DONE => 1");

it('can return a string of options from a pure enum')
    ->expect(Role::stringOptions(fn ($name, $value) => "$name => $value", ', '))
    ->toBe("ADMIN => ADMIN, GUEST => GUEST");

it('returns default HTML options from backed enums')
    ->expect(Status::stringOptions())
    ->toBe('<option value="0">Pending</option>\n<option value="1">Done</option>');

it('returns default HTML options from pure enums')
    ->expect(Role::stringOptions())
    ->toBe('<option value="ADMIN">Admin</option>\n<option value="GUEST">Guest</option>');

it('returns default HTML options from pure enums with snake case')
    ->expect(MultiWordSnakeCaseEnum::stringOptions())
    ->toBe('<option value="FOO_BAR">Foo bar</option>\n<option value="BAR_BAZ">Bar baz</option>');

it('returns default HTML options from backed enums with snake case')
    ->expect(BackedMultiWordSnakeCaseEnum::stringOptions())
    ->toBe('<option value="0">Foo bar</option>\n<option value="1">Bar baz</option>');

it('returns default HTML options from pure enums with pascal case')
    ->expect(PascalCaseEnum::stringOptions())
    ->toBe('<option value="FooBar">Foo bar</option>\n<option value="BarBaz">Bar baz</option>');

it('returns default HTML options from backed enums with pascal case')
    ->expect(BackedPascalCaseEnum::stringOptions())
    ->toBe('<option value="0">Foo bar</option>\n<option value="1">Bar baz</option>');

