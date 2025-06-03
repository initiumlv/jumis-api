<?php

namespace Initium\Jumis\Api\Filters;

class FilterLessThan extends Filter
{
    public function __construct(string $name, mixed $value, ?string $applyMode = null)
    {
        parent::__construct($name, self::TYPE_LESS_THAN, $applyMode);
        $this->params[] = $value;
    }

    public function toArray(): array
    {
        return $this->buildAttributes();
    }
} 