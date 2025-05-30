<?php

namespace Initium\Jumis\Api\Filters;

class FilterGreaterThan extends Filter
{
    public function __construct(string $name, mixed $value, ?string $applyMode = null)
    {
        parent::__construct($name, '>=', $applyMode);
        $this->params[] = $value;
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 