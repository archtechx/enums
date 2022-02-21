<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait Values
{
    /** Get an array of case values. */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }
}
