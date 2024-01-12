<?php

declare(strict_types=1);

namespace ArchTech\Enums\Meta;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionEnumUnitCase;
use ReflectionObject;

class Reflection
{
    /**
     * Get the meta properties enabled on an Enum.
     *
     * @param \Enum&\ArchTech\Enums\Metadata $enum
     * @return string[]|array<\class-string<MetaProperty>>
     */
    public static function metaProperties(mixed $enum): array
    {
        $reflection = new ReflectionObject($enum);
        $metaProperties = static::parseMetaProperties($reflection);

        // Traits except the `Metadata` trait
        $traits = array_values(array_filter($reflection->getTraits(), fn (ReflectionClass $class) => $class->getName() !== 'ArchTech\Enums\Metadata'));

        foreach ($traits as $trait) {
            $metaProperties = array_merge($metaProperties, static::parseMetaProperties($trait));
        }

        return $metaProperties;
    }

    /** @param ReflectionClass<object> $reflection */
    protected static function parseMetaProperties(ReflectionClass $reflection): array
    {
        // Only the `Meta` attribute
        $attributes = $reflection->getAttributes(Meta::class);

        if ($attributes) {
            /** @var Meta $meta */
            $meta = $attributes[0]->newInstance();

            return $meta->metaProperties;
        }

        return [];
    }

    /**
     * Get the value of a meta property on the provided enum.
     *
     * @param \Enum $enum
     */
    public static function metaValue(string $metaProperty, mixed $enum): mixed
    {
        // Find the case used by $enum
        $reflection = new ReflectionEnumUnitCase($enum::class, $enum->name);
        $attributes = $reflection->getAttributes();

        // Instantiate each ReflectionAttribute
        /** @var MetaProperty[] $properties */
        $properties = array_map(fn (ReflectionAttribute $attr) => $attr->newInstance(), $attributes);

        // Find the property that matches the $metaProperty class
        $properties = array_filter($properties, fn (MetaProperty $property) => $property::class === $metaProperty);

        // Reset array index
        $properties = array_values($properties);

        if ($properties) {
            return $properties[0]->value;
        }

        return null;
    }
}
