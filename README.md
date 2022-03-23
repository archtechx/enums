# Enums

A collection of enum helpers for PHP.

- [`InvokableCases`](#invokablecases)
- [`Names`](#names)
- [`Values`](#values)
- [`Options`](#options)

You can read more about the idea on [Twitter](https://twitter.com/archtechx/status/1495158228757270528). I originally wanted to include the `InvokableCases` helper in [`archtechx/helpers`](https://github.com/archtechx/helpers), but it makes more sense to make it a separate dependency and use it *inside* the other package.

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

## Development

Run all checks locally:

```sh
./check
```

Code style will be automatically fixed by php-cs-fixer.
