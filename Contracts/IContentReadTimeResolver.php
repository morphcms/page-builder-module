<?php

namespace Modules\PageBuilder\Contracts;

use Modules\PageBuilder\Models\Content;

interface IContentReadTimeResolver
{
    public function calculate(Content $content, int $wordsPerMinute = 265): int;
}
