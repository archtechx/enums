<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait Names
{
    /** Get an array of case names. */
    public static function names(): array
    {
        return array_map(function ($case) {
            return $case->name;
        }, static::cases());
    }
}
