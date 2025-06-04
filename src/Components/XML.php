<?php

namespace Initium\Jumis\Api\Components;

use Initium\Jumis\Api\Filters\Filter;

class XML
{
    public static function prepareAttributes(array $attrs): string
    {
        if (empty($attrs)) {
            return '';
        }

        return collect($attrs)
            ->map(fn($v, $k) => $v === null ? '' : "$k=\"$v\"")
            ->filter()
            ->implode(' ');
    }

    public static function buildXmlElements(array $data, ?string $tag = null, ?int $index = null): string
    {
        $xml = '';

        foreach ($data as $key => $value) {

            if (is_array($value) && array_is_list($value)) {
                foreach ($value as $i => $item) {
                    $xml .= self::buildXmlElements($item, $key, $i);
                }
                continue;
            }

            if (is_array($value)) {
                $xml .= self::buildXmlElements($value, $key);
                continue;
            }

            $xml .= "<$key>" . htmlspecialchars((string)$value) . "</$key>";
        }

        if ($tag) {
            $tagLine = $index !== null ? "<$tag TagID=\"$index\">" : "<$tag>";
            return $tagLine . $xml . "</$tag>";
        }

        return $xml;
    }

    public static function prepareFilters(array $filters): string
    {
        if (empty($filters)) {
            return '';
        }

        return collect($filters)->map(function ($filter) {
            if ($filter instanceof Filter) {
                $filter = $filter->toArray();
            }
            $attrs = collect($filter)
                ->filter(fn($v) => $v !== null)
                ->map(function ($v, $k) {
                    $v = htmlspecialchars((string)$v, ENT_XML1 | ENT_QUOTES, 'UTF-8');
                    return "$k=\"$v\"";
                })
                ->implode(' ');
            return "<Filter $attrs />";
        })->implode("");
    }

    private static function generateFieldXml(mixed $fieldDefinition): string
    {
        if (is_string($fieldDefinition)) {
            return "<Field Name=\"" . htmlspecialchars($fieldDefinition, ENT_XML1) . "\"/>";
        }

        if (is_array($fieldDefinition) && isset($fieldDefinition['name'])) {
            // Sortable field: ['name' => 'Name', 'sort' => 'Asc', 'sortLevel' => 1]
            $fieldName = htmlspecialchars($fieldDefinition['name'], ENT_XML1);
            $attributes = "Name=\"$fieldName\"";
            if (isset($fieldDefinition['sort'])) {
                $sortOrder = htmlspecialchars($fieldDefinition['sort'], ENT_XML1);
                if (in_array($sortOrder, ['Asc', 'Desc'], true)) {
                    $attributes .= " Sort=\"$sortOrder\"";
                }
            }
            if (isset($fieldDefinition['sortLevel'])) {
                $sortLevelVal = filter_var($fieldDefinition['sortLevel'], FILTER_VALIDATE_INT);
                if ($sortLevelVal !== false && $sortLevelVal > 0) {
                    $attributes .= " SortLevel=\"$sortLevelVal\"";
                }
            }
            return "<Field $attributes/>";
        }
        return '';
    }

    public static function prepareFields(array $fields): string
    {
        return collect($fields)->map(function ($fieldValue, $fieldKey) {

            if (is_string($fieldKey) && !is_numeric($fieldKey) && is_array($fieldValue) && !isset($fieldValue['name'])) {
                $groupTagName = htmlspecialchars($fieldKey, ENT_XML1);

                $nestedFieldsXml = self::prepareFields($fieldValue);
                if (!empty($nestedFieldsXml)) {
                    return "<$groupTagName>$nestedFieldsXml</$groupTagName>";
                }
                return '';
            }
         else {
                return self::generateFieldXml($fieldValue);
            }
        })->filter()->implode("");
    }
}