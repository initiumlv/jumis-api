<?php

namespace Initium\Jumis\Api\Filters;

class FilterLike extends Filter
{
    public function __construct(string $name, string $value, ?string $applyMode = null)
    {
        parent::__construct($name, 'Equal', $applyMode);
        $this->params[] = $value;
        $this->params[] = 'Like';
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 