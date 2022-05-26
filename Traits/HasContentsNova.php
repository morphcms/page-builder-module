<?php

namespace Modules\PageBuilder\Traits;

use Laravel\Nova\Fields\HasMany;
use Modules\PageBuilder\Nova\Resources\Content;

trait HasContentsNova
{
    public function contentsField(): HasMany
    {
        return  HasMany::make(__('Contents'), 'contents', Content::class);
    }
}
