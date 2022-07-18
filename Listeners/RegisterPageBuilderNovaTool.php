<?php

namespace Modules\PageBuilder\Listeners;

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
     * @param  object  $event
     * @return array
     */
    public function handle($event): array
    {
        return [
            PageBuilderNovaTool::class,
        ];
    }
}
