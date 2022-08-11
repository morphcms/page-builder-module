<?php

namespace Modules\PageBuilder\Traits;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\MorphOne;
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
     * @return MorphOne
     */
    public function contentField(): MorphOne
    {
        return MorphOne::make(__('Content'), 'content', Content::class);
    }
}
