<?php

namespace Initium\Jumis\Api\Filters;

class FilterTree extends Filter
{
    public function __construct(string $name, string $code, bool $includeChildren = true, ?string $dimension = null, ?string $applyMode = null)
    {
        parent::__construct($name, self::TYPE_TREE, $applyMode);
        $this->params[] = $code;
        $this->params[] = $includeChildren ? 'IncludeChildren' : null;
        $this->params[] = $dimension;
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 