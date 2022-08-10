<?php

namespace Modules\PageBuilder\Layouts\Blocks;

use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\Trix;
use Modules\PageBuilder\Contracts\IBlockHasSeo;
use Modules\PageBuilder\Contracts\IBlockIndexing;
use Modules\PageBuilder\Contracts\ICountsWords;
use Modules\SeoSorcery\Contracts\IScanResult;
use Modules\SeoSorcery\Utils\SeoOptions;
use Spatie\Translatable\HasTranslations;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

/**
 * @property string $value
 */
class TextBlock extends Layout implements ICountsWords, IBlockIndexing, IBlockHasSeo
{
    use HasTranslations;

    public array $translatable = ['value'];

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'text-block';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Text';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Trix::make(null, 'value')->translatable()->stacked(),
        ];
    }

    #[Pure]
    public function countWords(): int
    {
        return Str::wordCount(strip_tags($this->value));
    }

    public function getIndexValue(): string
    {
        return strip_tags($this->value);
    }

    public function analyzeSeo(SeoOptions $options, IScanResult $result): void
    {
    }
}
