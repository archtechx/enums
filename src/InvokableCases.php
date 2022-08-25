<?php

declare(strict_types=1);

namespace ArchTech\Enums;

use BackedEnum;
use ReflectionEnum;

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
        static $valueMap = [];

        if (isset($valueMap[$name])) {
            return $valueMap[$name];
        }

        $reflEnum = new ReflectionEnum(static::class);
        if (! $reflEnum->hasCase($name)) {
            throw new Exceptions\UndefinedCaseError(static::class, $name);
        }

        // Get the enum case, and invoke it to get the value or name
        return $valueMap[$name] = $reflEnum->getCase($name)->getValue()();
    }
}
