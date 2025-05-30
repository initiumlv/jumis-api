<?php

namespace Initium\Jumis\Api\Filters;

class FilterBetween extends Filter
{
    public function __construct(string $name, mixed $start, mixed $end, ?string $applyMode = null)
    {
        parent::__construct($name, self::TYPE_BETWEEN, $applyMode);
        $this->params[] = $start;
        $this->params[] = $end;
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 