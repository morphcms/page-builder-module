<?php

namespace Modules\PageBuilder\Resolvers;

use Modules\PageBuilder\Contracts\IContentReadTimeResolver;
use Modules\PageBuilder\Contracts\ICountsWords;
use Modules\PageBuilder\Models\Content;

class DefaultContentReadTimeResolver implements IContentReadTimeResolver
{
    public function calculate(Content $content, int $wordsPerMinute = 265): int
    {
        $totalWords = $content->data->sum(fn ($layout) => $layout instanceof ICountsWords ? $layout->countWords() : 0);

        if ($totalWords === 0) {
            return 0;
        }

        $result = round($totalWords / $wordsPerMinute);

        return max(1, $result);
    }
}
