<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait Descriptions
{
    abstract public function getDescription(): string;

    public static function descriptions(): array
    {
        return array_map(fn ($case) => $case->getDescription(), static::cases());
    }
}
