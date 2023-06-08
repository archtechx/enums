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

    public function in(array $enums): bool
    {
        return [] !== array_filter($enums, fn (mixed $enum) => $this->is($enum));
    }

    public function notIn(array $enums): bool
    {
        return ! $this->in($enums);
    }
}
