<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait Options
{
    /** Get an associative array of [case name => case value]. */
    public static function options(): array
    {
        $cases = static::cases();
        if (reset($cases) instanceof \BackedEnum) {
            return array_column($cases, 'value', 'name');
        }

        return array_column($cases, 'name');
    }
}
