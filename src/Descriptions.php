<?php

namespace ArchTech\Enums;

trait Descriptions
{
    /**
     * @return array
     */
    public static function descriptions(): array
    {
        return array_map(fn($case) => $case->getDescription(), static::cases());
    }
}