<?php

namespace Modules\PageBuilder\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Modules\PageBuilder\Services\PageBuilderService;

/**
 * @see PageBuilderService
 *
 * @method static PageBuilderService register(array|Collection $blocks)
 * @method static PageBuilderService|array types(array|string $types = [])
 * @method static Collection blocks()
 * @method static bool hasAnyBlocks()
 * @method static bool hasSearchableLayouts()
 */
class PageBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PageBuilderService::class;
    }
}
