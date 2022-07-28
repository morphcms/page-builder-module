<?php

namespace Modules\PageBuilder\Contracts;

use Modules\PageBuilder\Models\Content;

interface IBlocksResolver
{
    public function resolve(Content $model): \Illuminate\Support\Collection|\Whitecube\NovaFlexibleContent\Layouts\Collection;
}
