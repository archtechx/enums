<?php

use ArchTech\Enums\{Comparable, InvokableCases, Options, Names, Values, From, Metadata};
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Meta\MetaProperty;

uses(ArchTech\Enums\Tests\TestCase::class)->in('Pest');

#[Attribute]
class Color extends MetaProperty {}

#[Attribute]
class Desc extends MetaProperty
{
    public static function method(): string
    {
        return 'description';
    }
}

#[Attribute]
class Instructions extends MetaProperty
{
    public static string $method = 'help';

    protected function transform(mixed $value): mixed
    {
        return 'Help: ' . $value;
    }
}

/**
 * @method string description()
 * @method string color()
 */
#[Meta(Color::class, Desc::class)] // variadic syntax
enum Status: int
{
    use InvokableCases, Options, Names, Values, From, Metadata, Comparable;

    #[Color('orange')] #[Desc('Incomplete task')]
    case PENDING = 0;

    #[Color('green')] #[Desc('Completed task')]
    #[Instructions('Illegal meta property — not enabled on the enum')]
    case DONE = 1;
}

#[Meta([Color::class, Desc::class, Instructions::class])] // array
enum Role
{
    use InvokableCases, Options, Names, Values, From, Metadata, Comparable;

    #[Color('indigo')]
    #[Desc('Administrator')]
    #[Instructions('Administrators can manage the entire account')]
    case ADMIN;

    #[Color('gray')]
    #[Desc('Read-only guest')]
    #[Instructions('Guest users can only view the existing records')]
    case GUEST;
}
