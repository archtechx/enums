# Enums

A collection\* of enum helpers for PHP.

\* Currently there's only one helper — [`InvokableCases`](#invokablecases) — but the goal of the package is to provide general purpose enum helpers.

You can read more about the idea on [Twitter](https://twitter.com/archtechx/status/1495158228757270528). I originally wanted to include that helper in [`archtechx/helpers`](https://github.com/archtechx/helpers), but it makes more sense to make this a separate dependency and use it *inside* the other package.

## Installation

Laravel 8 or 9 are required. PHP 8.1+ is required.

```sh
composer require archtechx/enums
```

## Usage

### InvokableCases

This helper lets you get the value of a backed enum by "invoking it" — either statically (`MyEnum::FOO()` instead of `MyEnum::FOO`), or as an instance (`$enum()`).

That way, you can use enums as array keys:
```php
'statuses' => [
    TaskStatus::INCOMPLETE() => ['some configuration'],
    TaskStatus::COMPLETED() => ['some configuration'],
],
```

Or just the underlying primitives for any other use cases:
```php
public function updateStatus(int $status): void;

$task->updateStatus(TaskStatus::COMPLETED());
```

Without [having to append](https://twitter.com/archtechx/status/1495158237137494019) `->value` to everything.

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

## Development

Run all checks locally:

```sh
./check
```

Code style will be automatically fixed by php-cs-fixer.
