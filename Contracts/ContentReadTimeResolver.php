<?php

namespace Modules\PageBuilder\Contracts;

use Modules\PageBuilder\Models\Content;

interface ContentReadTimeResolver
{
    public function calculate(Content $content, int $wordsPerMinute = 265): int;
}
