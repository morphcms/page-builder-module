<?php

namespace Modules\PageBuilder\Nova\Resources;

use App\Nova\Resource;
use App\Nova\User;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Modules\Morphling\Nova\Actions\UpdateStatus;
use Modules\Morphling\Nova\Filters\ByStatus;
use Modules\PageBuilder\Enum\ContentStatus;
use Modules\PageBuilder\Facades\PageBuilder;
use Modules\PageBuilder\Models\Content as ContentModel;
use Outl1ne\NovaSortable\Traits\HasSortableRows;
use Whitecube\NovaFlexibleContent\Flexible;

/**
 * @mixin ContentModel
 */
class Content extends Resource
{
    use HasSortableRows;

    public static string $model = ContentModel::class;

    public static $title = 'handle';

    public static $displayInNavigation = false;

    public static $search = ['id', 'handle'];

    public static $tableStyle = 'tight';

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            MorphTo::make(__('Contentable'))
                ->types(PageBuilder::types())
                ->searchable(),

            BelongsTo::make(__('Author'), 'user', User::class)
                ->searchable()
                ->filterable()
                ->sortable()
                ->nullable(),

            Text::make(__('Handle'), 'handle')
                ->help(__('Used by system as a reference.'))
                ->nullable(),

            Badge::make(__('Status'), 'status')
                ->displayUsing(fn () => $this->status->value)
                ->map(ContentStatus::getNovaBadgeColors())
                ->exceptOnForms(),

            Text::make(__('Created At'), fn () => $this->created_at->toFormattedDateString())
                ->exceptOnForms(),

            Text::make(__('Last Updated At'), fn () => $this->update_at?->diffForHumans() ?? 'N/A')->exceptOnForms(),

            Number::make(__('Read Time'), 'read_time')
                ->onlyOnDetail(),

            Panel::make(__('Blocks'), [
                Flexible::make('', 'data')->preset(PageBuilder::preset()),
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
            UpdateStatus::make(ContentStatus::class)->showInline(),
        ];
    }
}
