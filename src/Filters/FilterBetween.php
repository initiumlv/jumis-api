<?php

namespace Initium\Jumis\Api\Filters;

class FilterBetween extends Filter
{
    public function __construct(string $name, mixed $from, mixed $to, ?string $applyMode = null)
    {
        parent::__construct($name, 'Between', $applyMode);
        $this->params[] = $from;
        $this->params[] = $to;
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 