<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait From
{
    /**
     * Gets the Enum by index for "Pure" enums.
     *
     * This will not override the `from()` method on BackedEnums
     *
     * @throws \ValueError
     */
    static public function from(int $case): static
    {
        return static::cases()[$case] ?? throw new \ValueError($case . ' is not a valid unit for enum "' . get_called_class() . '"');
    }

    /**
     * Gets the Enum by index, if it exists for "Pure" enums.
     *
     * This will not override the `tryFrom()` method on BackedEnums
     */
    static public function tryFrom(int $case): ?static
    {
        return static::cases()[$case] ?? null;
    }

    /**
     * Gets the Enum by name.
     *
     * @throws \ValueError
     */
    static public function fromName(string $case): static
    {
        return static::tryFromName($case) ?? throw new \ValueError('"' . $case . '" is not a valid name for enum "' . get_called_class() . '"');
    }

    /**
     * Gets the Enum by name, if it exists.
     */
    static public function tryFromName(string $case): ?static
    {
        $cases = array_filter(
            static::cases(),
            fn ($c) => $c->name === $case
        );

        return array_pop($cases) ?? null;
    }
}
