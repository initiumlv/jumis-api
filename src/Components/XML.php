<?php

namespace Initium\Jumis\Api\Components;

use Initium\Jumis\Api\Filters\Filter;

class XML
{
    public static function prepareAttributes(array $attrs): string
    {
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

            $xml .= "<$key>" . htmlspecialchars((string)$value) . "</$key>\n";
        }

        if ($tag) {
            $tagLine = $index !== null ? "<$tag TagID=\"$index\">\n" : "<$tag>\n";
            return $tagLine . $xml . "</$tag>\n";
        }

        return $xml;
    }

    public static function prepareFilters(array $filters): string
    {
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

    public static function prepareFields(array $fields):string
    {
        return collect($fields)->map(function ($field, $key) {
            if (is_array($field)) {
                $fieldName = $key;
                $nestedFields = collect($field)->map(function ($nestedField) {
                    return "<Field Name=\"$nestedField\"/>";
                })->implode("");
                return "<$fieldName>$nestedFields</$fieldName>";
            } else {
                return "<Field Name=\"$field\"/>";
            }
        })->implode("");
    }

}