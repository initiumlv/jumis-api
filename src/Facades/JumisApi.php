<?php

namespace Initium\Jumis\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed read(string $table, array $fields = [], array $filters = [], ?string $requestId = null, array $flags = []): mixed
 * @method static mixed insert(string $table, array $fields, ?string $requestId = null): mixed
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