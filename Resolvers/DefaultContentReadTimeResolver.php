<?php

namespace Modules\PageBuilder\Resolvers;

use Modules\PageBuilder\Contracts\ContentReadTimeResolver;
use Modules\PageBuilder\Contracts\CountsWords;
use Modules\PageBuilder\Models\Content;

class DefaultContentReadTimeResolver implements ContentReadTimeResolver
{

    public function calculate(Content $content, int $wordsPerMinute = 265): int
    {
        $totalWords = $content->data->sum(fn ($layout) => $layout instanceof CountsWords ? $layout->countWords() : 0);

        if ($totalWords === 0) return 0;

        $result = round($totalWords / $wordsPerMinute);

        return $result > 0 ? $result : 1;
    }
}
