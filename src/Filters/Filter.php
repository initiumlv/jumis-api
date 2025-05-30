<?php

namespace Initium\Jumis\Api\Filters;

abstract class Filter
{
    protected string $name;
    protected string $type;
    protected array $params = [];
    protected ?string $applyMode = null;

    public function __construct(string $name, string $type = 'Equal', ?string $applyMode = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->applyMode = $applyMode;
    }

    abstract public function toArray(): array;

    protected function buildAttributes(): array
    {
        $attrs = [
            'Name' => $this->name,
            'Type' => $this->type
        ];

        // Add parameters
        foreach ($this->params as $key => $value) {
            $attrs["Param" . ($key + 1)] = $value;
        }

        // Add apply mode if specified
        if ($this->applyMode) {
            $attrs['ApplyMode'] = $this->applyMode;
        }

        return $attrs;
    }
} 