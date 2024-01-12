<?php

declare(strict_types=1);

namespace ArchTech\Enums;

use ValueError;

trait From
{
    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `from()` method on BackedEnums
     *
     * @throws ValueError
     */
    public static function from(string $case): static
    {
        return static::fromName($case);
    }

    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `tryFrom()` method on BackedEnums
     */
    public static function tryFrom(string $case): ?static
    {
        return static::tryFromName($case);
    }

    /**
     * Gets the Enum by name.
     *
     * @throws ValueError
     */
    public static function fromName(string $case): static
    {
        return static::tryFromName($case) ?? throw new ValueError('"' . $case . '" is not a valid name for enum ' . static::class . '');
    }

    /**
     * Gets the Enum by name, if it exists.
     */
    public static function tryFromName(string $case): ?static
    {
        $cases = array_filter(
            static::cases(),
            fn ($c) => $c->name === $case
        );

        return array_values($cases)[0] ?? null;
    }
}
