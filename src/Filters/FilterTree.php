<?php

namespace Initium\Jumis\Api\Filters;

class FilterTree extends Filter
{
    public function __construct(string $name, mixed $value, bool $includeChildren = false, ?string $applyMode = null)
    {
        parent::__construct($name, 'Equal', $applyMode);
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