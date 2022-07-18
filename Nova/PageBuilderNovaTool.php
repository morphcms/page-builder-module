<?php

namespace Modules\PageBuilder\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Modules\PageBuilder\Nova\Resources\Content;

class PageBuilderNovaTool extends Tool
{
    protected static array $resources = [
        Content::class,
    ];

    public function boot()
    {
        Nova::resources(self::$resources);
    }

    public function menu(Request $request)
    {
    }
}
