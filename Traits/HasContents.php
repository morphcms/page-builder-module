<?php

namespace Modules\PageBuilder\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Morphling\Contracts\CanBeOwned;
use Modules\PageBuilder\Models\Content;

/**
 * @mixin Model
 */
trait HasContents
{

    protected static function bootHasContents(): void
    {
        // Create a default content after this model is crated
        static::created(function ($model) {
            if(config('page-builder.create_default')){
                $model->contents()->create([
                    'user_id' => $model instanceof CanBeOwned ? $model->ownerId() : auth()->id(),
                    'handle' => 'default',
                ]);
            }
        });

        // Remove all contents related to this model.
        static::deleted(function ($model) {
            $model->contents()->delete();
        });
    }

    /**
     * Returns the latest published content
     *
     * @return MorphOne
     */
    public function content(): MorphOne
    {
        return $this->morphOne(Content::class, 'contentable');
    }

    public function contentLatestPublished()
    {
        return $this->content()->latest()->published();
    }

    public function contents(): MorphMany
    {
        return $this->morphMany(Content::class, 'contentable');
    }
}
