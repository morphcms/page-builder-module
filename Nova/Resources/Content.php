<?php

namespace Modules\PageBuilder\Nova\Resources;

use App\Nova\Resource;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Modules\Blog\Enums\PostStatus;
use Modules\Morphling\Nova\Actions\UpdateStatus;
use Modules\Morphling\Nova\Filters\ByStatus;
use Modules\PageBuilder\Enum\ContentStatus;
use Modules\PageBuilder\Facades\PageBuilder;
use Modules\PageBuilder\Models\Content as ContentModel;
use Modules\PageBuilder\Presets\BlockPreset;
use Whitecube\NovaFlexibleContent\Flexible;

/**
 * @mixin ContentModel
 */
class Content extends Resource
{
    public static string $model = ContentModel::class;

    public static $title = 'id';

    public static $displayInNavigation = false;

    public static $search = ['id'];

    public static $tableStyle = 'tight';

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            MorphTo::make('Contentable')->types(PageBuilder::types()),

            Badge::make(__('Status'), 'status')
                ->displayUsing(fn () => PostStatus::from($this->status)->value)
                ->map(PostStatus::getNovaBadgeColors())
                ->exceptOnForms(),

            Text::make('Created At', fn () => $this->created_at->toFormattedDateString())

                ->exceptOnForms(),
            Text::make('Last Updated At', fn () => $this->update_at?->diffForHumans() ?? 'N/A')->exceptOnForms(),

            Number::make(__('Read Time'), 'read_time')
                ->onlyOnDetail(),

            Panel::make('Blocks', [
                Flexible::make('', 'data')->preset(BlockPreset::class),
            ]),
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            ByStatus::make(ContentStatus::class),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            UpdateStatus::make(ContentStatus::class),
        ];
    }
}
