<?php

namespace Modules\PageBuilder\Seo;

use Modules\PageBuilder\Contracts\IBlockHasSeo;
use Modules\PageBuilder\Contracts\ICountsWords;
use Modules\PageBuilder\Layouts\Blocks\HeadingBlock;
use Modules\SeoSorcery\Contracts\ICanBeSeoAnalyzed;
use Modules\SeoSorcery\Contracts\IScanResult;
use Modules\SeoSorcery\Scanning\Scanner;
use Modules\SeoSorcery\Scanning\ScanResult;
use Whitecube\NovaFlexibleContent\Layouts\Collection;

class ContentScanner extends Scanner
{
    const MIN_WORDS = 60;

    /**
     * @throws \Exception
     */
    public function scan(ICanBeSeoAnalyzed $entity): IScanResult
    {
        $result = ScanResult::make(__('Content'));
        $options = $entity->getSeoOptions();
        $blocks = $options->getAttributeValue('content');

        if (empty($blocks) || ! ($blocks instanceof Collection)) {
            return $result->passed()->put(__('No Content'), __('The content is missing or empty.'));
        }

        $hasHeading = $blocks->filter(fn ($block) => $block instanceof HeadingBlock)->count() > 0;

        if (! $hasHeading) {
            $result->failed()->put(__('No Heading'), __('Heading is missing.'));
        }

        $totalWords = $blocks
            ->filter(fn ($block) => $block instanceof ICountsWords)
            ->sum(fn (ICountsWords $block) => $block->countWords());

        if ($totalWords < self::MIN_WORDS) {
            $result->put(__(':words Words', ['words' => $totalWords]), __('Content should be at least :words words long.', ['words' => self::MIN_WORDS]));
        }

        $blocks
            ->filter(fn ($block) => $block instanceof IBlockHasSeo)
            ->each(fn (IBlockHasSeo $block) => $block->analyzeSeo($options, $result));

        return $result->passed();
    }
}
