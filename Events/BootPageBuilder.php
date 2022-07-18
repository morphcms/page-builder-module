<?php

namespace Modules\PageBuilder\Events;

use Illuminate\Queue\SerializesModels;
use Modules\PageBuilder\Services\PageBuilderService;

class BootPageBuilder
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public PageBuilderService $pageBuilder)
    {
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
