<?php

namespace Initium\Jumis\Api\Filters;

class FilterLike extends Filter
{
    public function __construct(string $name, string $pattern, ?string $applyMode = null)
    {
        parent::__construct($name, self::TYPE_LIKE, $applyMode);
        $this->params[] = $pattern;
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 