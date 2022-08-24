<?php

declare(strict_types=1);

namespace ArchTech\Enums\Tests\PHPStan\InvokableCases;

use ArchTech\Enums\InvokableCases;

enum Role
{
    use InvokableCases;

    case admin;
    case manager;
    case staff;

    public static function administrator(): self
    {
        return self::admin;
    }

    public function isManager(): bool
    {
        return $this === self::manager;
    }
}
