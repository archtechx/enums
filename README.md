# Enums

A collection of enum helpers for PHP.

- [`InvokableCases`](#invokablecases)
- [`Names`](#names)
- [`Values`](#values)
- [`Options`](#options)
- [`From`](#from)
- [`Metadata`](#metadata)
- [`Comparable`](#comparable)

You can read more about the original idea on [Twitter](https://twitter.com/archtechx/status/1495158228757270528).

## Installation

PHP 8.1+ is required.

```sh
composer require archtechx/enums
```

## Usage

### InvokableCases

This helper lets you get the value of a backed enum, or the name of a pure enum, by "invoking" it — either statically (`MyEnum::FOO()` instead of `MyEnum::FOO`), or as an instance (`$enum()`).

That way, you can use enums as array keys:
```php
'statuses' => [
    TaskStatus::INCOMPLETE() => ['some configuration'],
    TaskStatus::COMPLETED() => ['some configuration'],
],
```

Or access the underlying primitives for any other use cases:
```php
public function updateStatus(int $status): void;

$task->updateStatus(TaskStatus::COMPLETED());
```

The main point: this is all without [having to append](https://twitter.com/archtechx/status/1495158237137494019) `->value` to everything.

This approach also has *decent* IDE support. You get autosuggestions while typing, and then you just append `()`:
```php
MyEnum::FOO; // => MyEnum instance
MyEnum::FOO(); // => 1
```

#### Apply the trait on your enum
```php
use ArchTech\Enums\InvokableCases;

enum TaskStatus: int
{
    use InvokableCases;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use InvokableCases;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use static calls to get the primitive value
```php
TaskStatus::INCOMPLETE(); // 0
TaskStatus::COMPLETED(); // 1
TaskStatus::CANCELED(); // 2
Role::ADMINISTRATOR(); // 'ADMINISTRATOR'
Role::SUBSCRIBER(); // 'SUBSCRIBER'
Role::GUEST(); // 'GUEST'
```

#### Invoke instances to get the primitive value
```php
public function updateStatus(TaskStatus $status, Role $role)
{
    $this->record->setStatus($status(), $role());
}
```

### Names

This helper returns a list of case *names* in the enum.

#### Apply the trait on your enum
```php
use ArchTech\Enums\Names;

enum TaskStatus: int
{
    use Names;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use Names;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `names()` method
```php
TaskStatus::names(); // ['INCOMPLETE', 'COMPLETED', 'CANCELED']
Role::names(); // ['ADMINISTRATOR', 'SUBSCRIBER', 'GUEST']
```

### Values

This helper returns a list of case *values* for backed enums, or a list of case *names* for pure enums (making this functionally equivalent to [`::names()`](#names) for pure Enums)

#### Apply the trait on your enum
```php
use ArchTech\Enums\Values;

enum TaskStatus: int
{
    use Values;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use Values;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `values()` method
```php
TaskStatus::values(); // [0, 1, 2]
Role::values(); // ['ADMINISTRATOR', 'SUBSCRIBER', 'GUEST']
```

### Options

This helper returns an associative array of case names and values for backed enums, or a list of names for pure enums (making this functionally equivalent to [`::names()`](#names) for pure Enums).

#### Apply the trait on your enum
```php
use ArchTech\Enums\Options;

enum TaskStatus: int
{
    use Options;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use Options;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `options()` method
```php
TaskStatus::options(); // ['INCOMPLETE' => 0, 'COMPLETED' => 1, 'CANCELED' => 2]
Role::options(); // ['ADMINISTRATOR', 'SUBSCRIBER', 'GUEST']
```

#### stringOptions()

The trait also adds the `stringOptions()` method that can be used for generating convenient string representations of your enum options:
```php
// First argument is the callback, second argument is glue
// returns "INCOMPLETE => 0, COMPLETED => 1, CANCELED => 2"
TaskStatus::stringOptions(fn ($name, $value) => "$name => $value", ', ');
```
For pure enums (non-backed), the name is used in place of `$value` (meaning that both `$name` and `$value` are the same).

Both arguments for this method are optional, the glue defaults to `\n` and the callback defaults to generating HTML `<option>` tags:
```php
// <option value="0">Incomplete</option>
// <option value="1">Completed</option>
// <option value="2">Canceled</option>
TaskStatus::stringOptions(); // backed enum

// <option value="ADMINISTRATOR">Administrator</option>
// <option value="Subscriber">Subscriber</option>
// <option value="GUEST">Guest</option>
Role::stringOptions(); // pure enum
```

### From

This helper adds `from()` and `tryFrom()` to pure enums, and adds `fromName()` and `tryFromName()` to all enums.

#### Important Notes:
* `BackedEnum` instances already implement their own `from()` and `tryFrom()` methods, which will not be overridden by this trait. Attempting to override those methods in a `BackedEnum` causes a fatal error.
* Pure enums only have named cases and not values, so the `from()` and `tryFrom()` methods are functionally equivalent to `fromName()` and `tryFromName()`

#### Apply the trait on your enum
```php
use ArchTech\Enums\From;

enum TaskStatus: int
{
    use From;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use From;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `from()` method
```php
Role::from('ADMINISTRATOR'); // Role::ADMINISTRATOR
Role::from('NOBODY'); // Error: ValueError
```

#### Use the `tryFrom()` method
```php
Role::tryFrom('GUEST'); // Role::GUEST
Role::tryFrom('NEVER'); // null
```

#### Use the `fromName()` method
```php
TaskStatus::fromName('INCOMPLETE'); // TaskStatus::INCOMPLETE
TaskStatus::fromName('MISSING'); // Error: ValueError
Role::fromName('SUBSCRIBER'); // Role::SUBSCRIBER
Role::fromName('HACKER'); // Error: ValueError
```

#### Use the `tryFromName()` method
```php
TaskStatus::tryFromName('COMPLETED'); // TaskStatus::COMPLETED
TaskStatus::tryFromName('NOTHING'); // null
Role::tryFromName('GUEST'); // Role::GUEST
Role::tryFromName('TESTER'); // null
```

### Metadata

This trait lets you add metadata to enum cases.

#### Apply the trait on your enum
```php
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Meta\Meta;
use App\Enums\MetaProperties\{Description, Color};

#[Meta(Description::class, Color::class)]
enum TaskStatus: int
{
    use Metadata;

    #[Description('Incomplete Task')] #[Color('red')]
    case INCOMPLETE = 0;

    #[Description('Completed Task')] #[Color('green')]
    case COMPLETED = 1;

    #[Description('Canceled Task')] #[Color('gray')]
    case CANCELED = 2;
}
```

Explanation:
- `Description` and `Color` are userland class attributes — meta properties
- The `#[Meta]` call enables those two meta properties on the enum
- Each case must have a defined description & color (in this example)

#### Access the metadata

```php
TaskStatus::INCOMPLETE->description(); // 'Incomplete Task'
TaskStatus::COMPLETED->color(); // 'green'
```

#### Creating meta properties

Each meta property (= attribute used on a case) needs to exist as a class.
```php
#[Attribute]
class Color extends MetaProperty {}

#[Attribute]
class Description extends MetaProperty {}
```

Inside the class, you can customize a few things. For instance, you may want to use a different method name than the one derived from the class name (`Description` becomes `description()` by default). To do that, override the `method()` method on the meta property:
```php
#[Attribute]
class Description extends MetaProperty
{
    public static function method(): string
    {
        return 'note';
    }
}
```

With the code above, the description of a case will be accessible as `TaskStatus::INCOMPLETE->note()`.

Another thing you can customize is the passed value. For instance, to wrap a color name like `text-{$color}-500`, you'd add the following `transform()` method:
```php
#[Attribute]
class Color extends MetaProperty
{
    protected function transform(mixed $value): mixed
    {
        return "text-{$value}-500";
    }
}
```

And now the returned color will be correctly transformed:
```php
TaskStatus::COMPLETED->color(); // 'text-green-500'
```

#### Use the `fromMeta()` method
```php
TaskStatus::fromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::fromMeta(Color::make('blue')); // Error: ValueError
```

#### Use the `tryFromMeta()` method
```php
TaskStatus::tryFromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::tryFromMeta(Color::make('blue')); // null
```

#### Recommendation: use annotations and traits

If you'd like to add better IDE support for the metadata getter methods, you can use `@method` annotations:

```php
/**
 * @method string description()
 * @method string color()
 */
#[Meta(Description::class, Color::class)]
enum TaskStatus: int
{
    use Metadata;

    #[Description('Incomplete Task')] #[Color('red')]
    case INCOMPLETE = 0;

    #[Description('Completed Task')] #[Color('green')]
    case COMPLETED = 1;

    #[Description('Canceled Task')] #[Color('gray')]
    case CANCELED = 2;
}
```

And if you're using the same meta property in multiple enums, you can create a dedicated trait that includes this `@method` annotation.

### Comparable

This trait lets you compare enums using `is()`, `isNot()`, `in()` and `notIn()`.

#### Apply the trait on your enum
```php
use ArchTech\Enums\Comparable;

enum TaskStatus: int
{
    use Comparable;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use Comparable;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `is()` method
```php
TaskStatus::INCOMPLETE->is(TaskStatus::INCOMPLETE); // true
TaskStatus::INCOMPLETE->is(TaskStatus::COMPLETED); // false
Role::ADMINISTRATOR->is(Role::ADMINISTRATOR); // true
Role::ADMINISTRATOR->is(Role::NOBODY); // false
```

#### Use the `isNot()` method
```php
TaskStatus::INCOMPLETE->isNot(TaskStatus::INCOMPLETE); // false
TaskStatus::INCOMPLETE->isNot(TaskStatus::COMPLETED); // true
Role::ADMINISTRATOR->isNot(Role::ADMINISTRATOR); // false
Role::ADMINISTRATOR->isNot(Role::NOBODY); // true
```

#### Use the `in()` method
```php
TaskStatus::INCOMPLETE->in([TaskStatus::INCOMPLETE, TaskStatus::COMPLETED]); // true
TaskStatus::INCOMPLETE->in([TaskStatus::COMPLETED, TaskStatus::CANCELED]); // false
Role::ADMINISTRATOR->in([Role::ADMINISTRATOR, Role::GUEST]); // true
Role::ADMINISTRATOR->in([Role::SUBSCRIBER, Role::GUEST]); // false
```

#### Use the `notIn()` method
```php
TaskStatus::INCOMPLETE->notIn([TaskStatus::INCOMPLETE, TaskStatus::COMPLETED]); // false
TaskStatus::INCOMPLETE->notIn([TaskStatus::COMPLETED, TaskStatus::CANCELED]); // true
Role::ADMINISTRATOR->notIn([Role::ADMINISTRATOR, Role::GUEST]); // false
Role::ADMINISTRATOR->notIn([Role::SUBSCRIBER, Role::GUEST]); // true
```

## PHPStan

To assist PHPStan when using invokable cases, you can include the PHPStan extensions into your own `phpstan.neon` file:

```yaml
includes:
  - ./vendor/archtechx/enums/extension.neon
```

## Development

Run all checks locally:

```sh
./check
```

Code style will be automatically fixed by php-cs-fixer.
