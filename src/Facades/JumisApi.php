<?php

namespace Initium\Jumis\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed read(string $block, array $fields, array $filters = [], string $structureType = 'Tree', ?string $requestId = null, bool $readAll = false, bool $returnId = false, bool $returnSync = false)
 * @method static mixed insert(string $block, string $xmlData, string $structureType = 'Tree', ?string $requestId = null)
 * @method static mixed update(string $block, string $xmlData, string $structureType = 'Tree', ?string $requestId = null)
 * @method static mixed delete(string $block, string $xmlData, string $structureType = 'Tree', ?string $requestId = null)
 * @method static string buildDataBlock(string $blockName, array $data, string $tagId)
 * @method static string buildNestedBlock(string $blockName, string $lineBlockName, array $data, string $tagId, string $lineTagId)
 *
 * @see \Initium\Jumis\Api\ApiService
 */
class JumisApi extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \Initium\Jumis\Api\ApiService::class;
    }
} 