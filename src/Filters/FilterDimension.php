<?php

namespace Initium\Jumis\Api\Filters;

class FilterDimension extends Filter
{
    public function __construct(string $name, string $dimension, string $value, bool $includeChildren = false, ?string $applyMode = null)
    {
        parent::__construct($name, 'Equal', $applyMode);
        $this->params[] = $dimension;
        $this->params[] = $value;
        if ($includeChildren) {
            $this->params[] = 'IncludeChildren';
        }
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 