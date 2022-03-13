# Enums

A collection of enum helpers for PHP.

- [`InvokableCases`](#invokablecases)
- [`Names`](#names)
- [`Values`](#values)
- [`Options`](#options)
- [`From`](#from)

You can read more about the idea on [Twitter](https://twitter.com/archtechx/status/1495158228757270528). I originally wanted to include the `InvokableCases` helper in [`archtechx/helpers`](https://github.com/archtechx/helpers), but it makes more sense to make it a separate dependency and use it *inside* the other package.

## Installation

PHP 8.1+ is required.

```sh
composer require archtechx/enums
```

## Usage

### InvokableCases

This helper lets you get the value of a backed enum by "invoking" it — either statically (`MyEnum::FOO()` instead of `MyEnum::FOO`), or as an instance (`$enum()`).

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
```

#### Use static calls to get the primitive value
```php
TaskStatus::INCOMPLETE(); // 0
TaskStatus::COMPLETED(); // 1
TaskStatus::CANCELED(); // 2
```

#### Invoke instances to get the primitive value
```php
public function updateStatus(TaskStatus $status)
{
    $this->record->setStatus($status());
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
```

#### Use the `names()` method
```php
TaskStatus::names(); // ['INCOMPLETE', 'COMPLETED', 'CANCELED']
```

### Values

This helper returns a list of case *values* in the enum.

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
```

#### Use the `values()` method
```php
TaskStatus::values(); // [0, 1, 2]
```

### Options

This helper returns an associative array of case names and values.

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
```

#### Use the `options()` method
```php
TaskStatus::options(); // ['INCOMPLETE' => 0, 'COMPLETED' => 1, 'CANCELED' => 2]
```

### From

This helper adds `from()` and `tryFrom()` to pure enums, and adds `fromName()` and `tryFromName()` to all enums.

#### Important Notes:
* `BackedEnum` instances already implement their own `from()` and `tryFrom()` methods, which will not be overridden by this trait. Attempting to override those methods in a `BackedEnum` causes a fatal error.
* Pure enums do not actually have an internal index, so rearranging the order of cases will not break other code but it will create inconsistent behaviour with the `from()` and `tryFrom()` methods

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
Role::from(0); // Role::ADMINISTRATOR
Role::from(5); // Error: \ValueError
```

#### Use the `tryFrom()` method
```php
Role::tryFrom(2); // Role::GUEST
Role::tryFrom(5); // null
```

#### Use the `fromName()` method
```php
TaskStatus::fromName('INCOMPLETE'); // TaskStatus::INCOMPLETE
Role::fromName('SUBSCRIBER'); // Role::SUBSCRIBER
TaskStatus::fromName('MISSING'); // Error: \ValueError
Role::fromName('HACKER'); // Error: \ValueError
```

#### Use the `tryFromName()` method
```php
TaskStatus::tryFromName('COMPLETED'); // TaskStatus::COMPLETED
TaskStatus::tryFromName('NOTHING'); // null
Role::tryFromName('GUEST'); // Role::GUEST
Role::tryFromName('TESTER'); // null
```

## Development

Run all checks locally:

```sh
./check
```

Code style will be automatically fixed by php-cs-fixer.
