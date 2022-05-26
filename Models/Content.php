<?php

namespace Modules\PageBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\PageBuilder\Casts\BlocksFlexibleCast;
use Modules\PageBuilder\Contracts\IndexBlock;
use Modules\PageBuilder\Enum\ContentStatus;
use Modules\PageBuilder\Utils\Table;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use Whitecube\NovaFlexibleContent\Layouts\Collection;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Whitecube\NovaFlexibleContent\Layouts\LayoutInterface;

/**
 * @property Collection<LayoutInterface> $data
 * @property string $locale
 * @property int $read_time
 * @property Carbon $created_at
 * @property Carbon $update_at
 * @property \Illuminate\Support\Collection<array> $blocks
 */
class Content extends Model implements HasMedia
{
    use InteractsWithMedia, HasFlexible;

    protected $guarded = [];

    protected $touches = ['contentable'];

    protected $with = ['media'];

    protected $casts = [
       'data' => BlocksFlexibleCast::class,
    ];

    public function getTable(): string
    {
        return Table::contents();
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(ContentStatus::Published->value);
    }

    public function contentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function blocks(): Attribute
    {
        return new Attribute(
            get: fn() => $this->data->map(function(Layout $layout) {

                $layout->setModel($this);

                $result =  [
                    'name' => $layout->name(),
                    'data' => $this->getLayoutDataLocalized($layout),
                ];

                if($layout instanceof HasMedia) {
                    $result['data']['media'] = $layout->getMedia('images')->map(fn(Media $media) => [
                        'url' => $media->getFullUrl(),
                        'meta' => $media->custom_properties,
                    ]);
                }

                return $result;
            })
        );
    }

    private function getLayoutDataLocalized($layout): \Illuminate\Support\Collection
    {
        // This is needed to work with the package spatie/translations
        return collect($layout->toArray())
            ->mapWithKeys(fn($value, $key) => [$key => $layout->{$key}])
            ;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('default');
    }


    public function getIndexData(): string
    {
        return $this->data
            ->filter(fn($layout) => $layout instanceof IndexBlock)
            ->map(fn(IndexBlock $layout) => $layout->getIndexValue())
            ->join(PHP_EOL);

    }
}
