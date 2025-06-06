<?php

declare(strict_types=1);

use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Meta\MetaProperty;
use ArchTech\Enums\Metadata;

test('enums can use traits which define meta properties on themselves', function () {
    expect(MyEnum::FOO->description())->toBe('Foo!');
    expect(MyEnum::BAR->description())->toBe('Bar!');
    expect(MyEnum::BAZ->description())->toBe(null);
});

enum MyEnum
{
    use Metadata;
    use HasDescription;

    #[Description('Foo!')]
    case FOO;

    #[Description('Bar!')]
    case BAR;

    case BAZ;
}

#[Attribute]
class Description extends MetaProperty
{}

/**
 * @method string|null description()
 */
#[Meta(Description::class)]
trait HasDescription
{
}
