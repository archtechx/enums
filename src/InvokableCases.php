<?php

declare(strict_types=1);

namespace ArchTech\Enums;

use BackedEnum;

trait InvokableCases
{
    /** Return the enum's value when it's $invoked(). */
    public function __invoke()
    {
        return $this instanceof BackedEnum ? $this->value : $this->name;
    }

    /** Return the enum's value or name when it's called ::STATICALLY(). */
    public static function __callStatic($name, $args)
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return $case instanceof BackedEnum ? $case->value : $case->name;
            }
        }

        throw new Exceptions\UndefinedCaseError(static::class, $name);
    }
}
