<?php

namespace Modules\PageBuilder\Contracts;

use Modules\PageBuilder\Models\Content;
use Modules\PageBuilder\Seo\ContentScanner;
use Modules\SeoSorcery\Contracts\IScanResult;
use Modules\SeoSorcery\Utils\SeoOptions;

interface IBlockHasSeo
{
    public function analyzeSeo(SeoOptions $options, IScanResult $result): void;
}
