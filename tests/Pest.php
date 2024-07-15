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

#[Attribute]
class IsActive extends MetaProperty
{
    public static string $method = 'isActive';

    public static function defaultValue(): mixed
    {
        return false;
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

#[Meta([IsActive::class])]
enum ReferenceType: int
{
    use InvokableCases, Options, Names, Values, From, Metadata, Comparable;

    #[IsActive(true)]
    case ACTIVE_TYPE = 1;

    case INACTIVE_TYPE = 0;
}
    
#[Meta([Desc::class])]
enum RoleWithoutAttribute
{
    use InvokableCases, Options, Names, Values, From, Metadata, Comparable;

    case ADMIN;
}

enum MultiWordSnakeCaseEnum
{
    use Options;

    case FOO_BAR;
    case BAR_BAZ;
}

enum BackedMultiWordSnakeCaseEnum: int
{
    use Options;

    case FOO_BAR = 0;
    case BAR_BAZ = 1;
}

enum PascalCaseEnum
{
    use Options;

    case FooBar;
    case BarBaz;
}

enum BackedPascalCaseEnum: int
{
    use Options;

    case FooBar = 0;
    case BarBaz = 1;
}
