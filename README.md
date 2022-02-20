# REPLACE

Simple and flexible package template. Supports Laravel 8 and 9.

# Usage

- Replace all occurances of `REPLACE` (case sensitive) with the name of the package namespace. E.g. the `Foo` in `ArchTech\Foo`.
    - Also do this for file names, e.g. `REPLACEServiceProvider.php`.
- Replace all occurances of `replace` with the name of the package on composer, e.g. the `bar` in `archtechx/bar`.
- If MySQL is not needed, remove `docker-compose.yml`, remove the line that runs docker from `./check`, and remove it from the `.github/ci.yml` file.
    - If SQLite is wanted, change `DB_CONNECTION` in `phpunit.xml` to `sqlite`, and `DB_DATABASE` to `:memory:`.

---

## Installation

```sh
composer require archtechx/replace
```

## Usage

```php
// ...
```

## Development

Run all checks locally:

```sh
./check
```

Code style will be automatically fixed by php-cs-fixer.
