<?php

declare(strict_types=1);

namespace ArchTech\Enums;

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

    public function in(iterable $enums): bool
    {
        foreach ($enums as $item) {
            if ($this->is($item)) {
                return true;
            }
        }

        return false;
    }

    public function notIn(iterable $enums): bool
    {
        return ! $this->in($enums);
    }
}
