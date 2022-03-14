<?php

declare(strict_types=1);

namespace ArchTech\Enums;

use BackedEnum;

trait Options
{
    /** Get an associative array of [case name => case value]. */
    public static function options(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value', 'name')
            : array_column($cases, 'name');
    }
}
