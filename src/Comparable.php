<?php

declare(strict_types=1);

namespace ArchTech\Enums;

use Exception;
use Iterator;
use IteratorAggregate;

trait Comparable
{
    public function is(mixed $enum): bool
    {
        return $this === $enum;
    }

    public function isNot(mixed $enum): bool
    {
        return ! $this->is($enum);
    }

    public function in(array|object $enums): bool
    {
        $iterator = $enums;

        if (! is_array($enums)) {
            if ($enums instanceof Iterator) {
                $iterator = $enums;
            } elseif ($enums instanceof IteratorAggregate) {
                $iterator = $enums->getIterator();
            } else {
                throw new Exception('in() expects an iterable value');
            }
        }

        foreach ($iterator as $item) {
            if ($item === $this) {
                return true;
            }
        }

        return false;
    }

    public function notIn(array|object $enums): bool
    {
        return ! $this->in($enums);
    }
}
