<?php

declare(strict_types=1);

namespace ArchTech\Enums\PHPStan\InvokableCases;

use ArchTech\Enums\InvokableCases;
use PHPStan\BetterReflection\Reflection\Adapter\ReflectionEnum;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

class ReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if (
            $classReflection->getNativeReflection() instanceof ReflectionEnum
            && $classReflection->hasTraitUse(InvokableCases::class)
        ) {
            return $classReflection->getNativeReflection()->hasCase($methodName);
        }

        return false;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new StaticInvokableCaseMethodReflection($classReflection, $methodName);
    }
}
