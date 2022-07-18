<?php

namespace Modules\PageBuilder\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Morphling\Events\BootModulesNovaTools;
use Modules\PageBuilder\Listeners\RegisterPageBuilderNovaTool;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BootModulesNovaTools::class => [
            RegisterPageBuilderNovaTool::class,
        ],
    ];
}
