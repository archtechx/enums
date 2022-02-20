<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait Options
{
    /** Get an associative array of [case name => case value]. */
    public static function options(): array
    {
        return array_reduce(static::cases(), function ($options, $case) {
            $options[$case->name] = $case->value;

            return $options;
        }, []);
    }
}
