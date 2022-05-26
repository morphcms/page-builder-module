<?php

namespace Modules\PageBuilder\Casts;

use Modules\PageBuilder\Facades\PageBuilder;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class BlocksFlexibleCast extends FlexibleCast
{
    protected function getLayoutMapping()
    {
        return PageBuilder::blocks()->toArray();
    }
}
