<?php

namespace Modules\PageBuilder\Layouts\Blocks;

use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\Text;
use Modules\PageBuilder\Contracts\IBlockIndexing;
use Modules\PageBuilder\Contracts\ICountsWords;
use Spatie\Translatable\HasTranslations;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

/**
 * @property string $value
 */
class HeadingBlock extends Layout implements ICountsWords, IBlockIndexing
{
    use HasTranslations;

    public array $translatable = ['value'];

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'heading-block';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Heading';

    protected $limit = 1;

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Text::make(__('Heading'), 'value')
                ->help(__('This is the main heading that will appear at the top/start of the page.'))
                ->translatable(),
        ];
    }

    #[Pure]
    public function countWords(): int
    {
        return Str::wordCount($this->value);
    }

    public function getIndexValue(): string
    {
        return $this->value;
    }
}
