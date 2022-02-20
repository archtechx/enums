<?php

namespace ArchTech\Enums;

trait Values
{
    /** Get an array of case values. */
    public static function values(): array
    {
        return array_map(function ($case) {
            return $case->value;
        }, static::cases());
    }
}
