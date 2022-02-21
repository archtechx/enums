<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait Options
{
    /** Get an associative array of [case name => case value]. */
    public static function options(): array
    {
        return array_column(static::cases(), 'value', 'name');
    }
}
