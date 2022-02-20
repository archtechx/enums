<?php

declare(strict_types=1);

namespace ArchTech\Enums\Exceptions;

use Error;

class UndefinedCaseError extends Error
{
    public function __construct(string $enum, string $case)
    {
        // Matches the error message of invalid Foo::BAR access
        parent::__construct("Undefined constant $enum::$case");
    }
}
