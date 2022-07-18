<?php

namespace Modules\PageBuilder\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\PageBuilder\Nova\PageBuilderNovaTool;

class RegisterPageBuilderNovaTool
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return array
     */
    public function handle($event): array
    {
        return [
            PageBuilderNovaTool::make(),
        ];
    }
}
