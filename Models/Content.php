<?php

namespace Modules\PageBuilder\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Morphling\Traits\HasOwner;
use Modules\PageBuilder\Casts\BlocksFlexibleCast;
use Modules\PageBuilder\Contracts\IndexBlock;
use Modules\PageBuilder\Enum\ContentStatus;
use Modules\PageBuilder\Resolvers\BlocksResolver;
use Modules\PageBuilder\Utils\Table;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
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
    use InteractsWithMedia, HasFlexible, SortableTrait, HasOwner;

    protected $guarded = [];

    protected $touches = ['contentable'];

    protected $with = ['media'];

    protected $casts = [
        'data' => BlocksFlexibleCast::class,
        'status' => ContentStatus::class,
    ];

    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
        'sort_on_has_many' => true,
    ];

    public function getTable(): string
    {
        return Table::contents();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(ContentStatus::Published->value);
    }

    public function scopeReview($query)
    {
        return $query->whereStatus(ContentStatus::Review);
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(ContentStatus::Draft);
    }

    public function contentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function blocks(): Attribute
    {
        return new Attribute(
            get: fn () => app(BlocksResolver::class)($this)
        );
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('default');
    }

    public function getIndexData(): string
    {
        return $this->data
            ->filter(fn ($layout) => $layout instanceof IndexBlock)
            ->map(fn (IndexBlock $layout) => $layout->getIndexValue())
            ->join(PHP_EOL);
    }
}
