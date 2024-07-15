<?php

declare(strict_types=1);

namespace ArchTech\Enums\Meta;

abstract class MetaProperty
{
    final public function __construct(
        public mixed $value,
    ) {
        $this->value = $this->transform($value);
    }

    public static function defaultValue(): mixed
    {
        return null;
    }

    public static function make(mixed $value): static
    {
        return new static($value);
    }

    protected function transform(mixed $value): mixed
    {
        // Feel free to override this to transform the value during instantiation

        return $value;
    }

    /** Get the name of the accessor method */
    public static function method(): string
    {
        if (property_exists(static::class, 'method')) {
            return static::${'method'};
        }

        $parts = explode('\\', static::class);

        return lcfirst(end($parts));
    }
}
