<?php

declare(strict_types=1);

namespace ArchTech\Enums\Tests\PHPStan\InvokableCases;

use ArchTech\Enums\InvokableCases;

enum Status: int
{
    use InvokableCases;

    case created = 0;
    case running = 1;
    case done = 2;

    public static function initial(): self
    {
        return self::created;
    }

    public function isStarted(): bool
    {
        return $this->value > self::created->value;
    }
}
