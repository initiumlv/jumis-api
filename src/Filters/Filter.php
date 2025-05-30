<?php

namespace Initium\Jumis\Api\Filters;

abstract class Filter
{
    // Filter types as constants
    public const TYPE_EQUAL = 'Equal';
    public const TYPE_LESS_THAN = '<=';
    public const TYPE_GREATER_THAN = '>=';
    public const TYPE_BETWEEN = 'Between';
    public const TYPE_LIKE = 'Like';
    public const TYPE_TREE = 'Tree';
    public const TYPE_DIMENSION = 'Dimension';

    protected string $name;
    protected string $type;
    protected array $params = [];
    protected ?string $applyMode = null;

    public function __construct(string $name, string $type = self::TYPE_EQUAL, ?string $applyMode = null)
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
        ];

        if ($this->type !== self::TYPE_EQUAL) {
            $attrs['Type'] = $this->type;
        }

        foreach ($this->params as $key => $value) {
            if ($value !== null) {
                $attrs["Param" . ($key + 1)] = $value;
            }
        }

        if ($this->applyMode) {
            $attrs['ApplyMode'] = $this->applyMode;
        }

        return $attrs;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getParams(): array
    {
        return $this->params;
    }
} 