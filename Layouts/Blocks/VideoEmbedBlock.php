<?php

namespace Modules\PageBuilder\Layouts\Blocks;

use function __;
use Laravel\Nova\Fields\Code;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class VideoEmbedBlock extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'video-embed-block';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Video Embed';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Code::make(__('Embed Code'), 'value')
                ->language('html')
                ->required(),
            //Text::make(__('Video Url'), 'url')->rules(['required', 'active_url']),
        ];
    }
}
