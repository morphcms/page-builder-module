<?php

namespace Modules\PageBuilder\Layouts\Blocks;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use function __;

class ImagesBlock extends Layout implements HasMedia
{
    use HasMediaLibrary;


    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'images-block';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Images';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make(__('Type'), 'type')
                ->options([
                    'stack' => 'Stacked',
                    'grid' => 'Grid',
                ])
                ->default(fn() => 'stack')
                ->displayUsingLabels()
                ->required(),

            Images::make('Images', 'images')->customPropertiesFields([
                Text::make(__('Alt Text'), 'alt')->nullable(),
                Textarea::make(__('Fig Caption'), 'description')->nullable()->rows(2),
            ]),
        ];
    }
}
