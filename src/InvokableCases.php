<?php

declare(strict_types=1);

namespace ArchTech\Enums;

trait InvokableCases
{
    /** Return the enum's value when it's $invoked(). */
    public function __invoke()
    {
        return $this->value;
    }

    /** Return the enum's value when it's called ::STATICALLY(). */
    public static function __callStatic($name, $args)
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return $case->value;
            }
        }

        throw new Exceptions\UndefinedCaseError(static::class, $name);
    }
}
