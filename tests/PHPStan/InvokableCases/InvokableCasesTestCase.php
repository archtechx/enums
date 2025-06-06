<?php

declare(strict_types=1);

namespace ArchTech\Enums\Tests\PHPStan\InvokableCases;

use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Testing\PHPStanTestCase;

class InvokableCasesTestCase extends PHPStanTestCase
{
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../../src/PHPStan/InvokableCases/extension.neon'];
    }

    public function assertStaticallyCallable(string $enum, string $case, $exists = true, $static = true): void
    {
        $reflectionProvider = $this->createReflectionProvider();
        $class = $reflectionProvider->getClass($enum);

        if ($exists) {
            $this->assertTrue($class->hasMethod($case), sprintf('%s on class %s does not exist', $case, $enum));
            $method = $class->getMethod($case, new OutOfClassScope());
            if ($static) {
                $this->assertTrue($method->isStatic(), sprintf('%s on class %s is not static', $case, $enum));
            } else {
                $this->assertFalse($method->isStatic(), sprintf('%s on class %s is static', $case, $enum));
            }
        } else {
            $this->assertFalse($class->hasMethod($case), sprintf('%s on class %s exists', $case, $enum));
        }
    }

    public function assertStaticallyCallableType(string $enum, string $case, string $type): void
    {
        $reflectionProvider = $this->createReflectionProvider();
        $class = $reflectionProvider->getClass($enum);

        $method = $class->getMethod($case, new OutOfClassScope());
        $methodVariant = ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodReturnType = $methodVariant->getReturnType();
        $this->assertInstanceOf($type, $methodReturnType);
    }
}
