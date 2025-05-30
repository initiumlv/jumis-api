<?php

namespace Initium\Jumis\Api\Filters;

class FilterDimension extends Filter
{
    public function __construct(string $name, string $dimension, string $value, bool $includeChildren = true, ?string $applyMode = null)
    {
        parent::__construct($name, self::TYPE_DIMENSION, $applyMode);
        $this->params[] = $dimension;
        $this->params[] = $value;
        $this->params[] = $includeChildren ? 'IncludeChildren' : null;
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 