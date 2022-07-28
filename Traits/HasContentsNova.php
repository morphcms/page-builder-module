<?php

namespace Modules\PageBuilder\Traits;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Modules\PageBuilder\Nova\Resources\Content;

trait HasContentsNova
{
    /**
     * This allows to have multiple contents.
     *
     * @return HasMany
     */
    public function contentsField(): HasMany
    {
        return HasMany::make(__('Contents'), 'contents', Content::class);
    }

    /**
     * This allows only one content per resource
     *
     * @return HasOne
     */
    public function contentField(): HasOne
    {
        return HasOne::make(__('Content'), 'content', Content::class);
    }
}
