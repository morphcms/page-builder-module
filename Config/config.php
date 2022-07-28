<?php

return [
    'name' => 'PageBuilder',
    'table_prefix' => 'page_builder_',

    'layouts_searchable_threshold' => 10,
    /**
     * If enabled, this will create a default content for each model that implements the trait 'HasContent'
     */
    'create_default' => true,

    /**
     * Defines how to calculate the read time based on words per minute.
     */
    'words_per_minute' => 265,

    'resource_types' => [],

    'read_time_resolver' => \Modules\PageBuilder\Resolvers\DefaultContentReadTimeResolver::class,
    'preset' => \Modules\PageBuilder\Presets\BlockPreset::class,
    'blocks' => [
        \Modules\PageBuilder\Layouts\Blocks\HeadingBlock::class,
        \Modules\PageBuilder\Layouts\Blocks\TextBlock::class,
        \Modules\PageBuilder\Layouts\Blocks\ImagesBlock::class,
        \Modules\PageBuilder\Layouts\Blocks\VideoEmbedBlock::class,
    ],
];
