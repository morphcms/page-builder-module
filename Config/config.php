<?php

return [
    'name' => 'PageBuilder',
    'table_prefix' => 'page_builder_',

    'layouts_searchable_threshold' => 10,

    'resource_types' => [],

    'read_time_resolver' => \Modules\PageBuilder\Resolvers\DefaultContentReadTimeResolver::class,

    'blocks' => [
        \Modules\PageBuilder\Layouts\Blocks\HeadingBlock::class,
        \Modules\PageBuilder\Layouts\Blocks\TextBlock::class,
        \Modules\PageBuilder\Layouts\Blocks\ImagesBlock::class,
        \Modules\PageBuilder\Layouts\Blocks\VideoEmbedBlock::class,
    ],
];
