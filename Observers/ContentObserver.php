<?php

namespace Modules\PageBuilder\Observers;

use Modules\PageBuilder\Jobs\CalculateReadTimeJob;
use Modules\PageBuilder\Models\Content;

class ContentObserver
{
    public function updated(Content $content)
    {
        //  dispatch(new CalculateReadTimeJob($content));
    }
}
