<?php

namespace ArchTech\Enums\Meta;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Meta
{
    /** @var MetaProperty[] */
    public array $metaProperties;

    public function __construct(array|string ...$metaProperties) {
        // When an array is passed, it'll be wrapped in an outer array due to the ...variadic parameter
        if (isset($metaProperties[0]) && is_array($metaProperties[0])) {
            // Extract the inner array
            $metaProperties = $metaProperties[0];
        }

        $this->metaProperties = $metaProperties;
    }
}
