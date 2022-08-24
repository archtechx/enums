<?php

declare(strict_types=1);

namespace ArchTech\Enums\PHPStan\InvokableCases;

use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;

class StaticInvokableCaseMethodReflection implements MethodReflection
{
    private readonly MethodReflection $callStaticMethod;

    public function __construct(
        private readonly ClassReflection $classReflection,
        private readonly string $name,
    ) {
        $this->callStaticMethod = $this->classReflection->getMethod('__callStatic', new OutOfClassScope());
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->classReflection;
    }

    public function isStatic(): bool
    {
        return true;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getDocComment(): ?string
    {
        return $this->callStaticMethod->getDocComment();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    /**
     * @return ParametersAcceptor[]
     */
    public function getVariants(): array
    {
        return [
            new FunctionVariant(
                TemplateTypeMap::createEmpty(),
                TemplateTypeMap::createEmpty(),
                [],
                false,
                $this->classReflection->getBackedEnumType() ?? new StringType()
            ),
        ];
    }

    public function isDeprecated(): TrinaryLogic
    {
        return $this->callStaticMethod->isDeprecated();
    }

    public function getDeprecatedDescription(): ?string
    {
        return $this->callStaticMethod->getDeprecatedDescription();
    }

    public function isFinal(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function isInternal(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function getThrowType(): ?Type
    {
        return $this->callStaticMethod->getThrowType();
    }

    public function hasSideEffects(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }
}
