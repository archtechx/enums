<?php

declare(strict_types=1);

namespace ArchTech\Enums\Tests\PHPStan\InvokableCases;

use ArchTech\Enums\InvokableCases;

enum Suits: string
{
    use InvokableCases;

    case clubs = 'C';
    case diamonds = 'D';
    case hearts = 'H';
    case spades = 'S';

    public static function valuable(): self
    {
        return self::diamonds;
    }

    public function isRed(): bool
    {
        return match ($this) {
            self::diamonds, self::hearts => true,
            default => false,
        };
    }
}
