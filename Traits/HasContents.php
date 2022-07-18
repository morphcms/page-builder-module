<?php

namespace Modules\PageBuilder\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\PageBuilder\Models\Content;

trait HasContents
{
    /**
     * Returns the latest published content
     *
     * @return MorphOne
     */
    public function content(): MorphOne
    {
        return $this->morphOne(Content::class, 'contentable')
            ->published()
            ->latest();
    }

    public function contents(): MorphMany
    {
        return $this->morphMany(Content::class, 'contentable');
    }
}
