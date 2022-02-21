<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait Names
{
    /** Get an array of case names. */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }
}
