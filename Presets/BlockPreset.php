<?php

namespace Modules\PageBuilder\Presets;

use Modules\PageBuilder\Flexible\BlockResolver;
use Modules\PageBuilder\Services\PageBuilderService;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Preset;

class BlockPreset extends Preset
{

    /**
     * Create a new preset instance
     */
    public function __construct(protected PageBuilderService $builder)
    {

    }

    /**
     * @throws \Exception
     */
    public function handle(Flexible $field)
    {
        $field->button(__('Add Block'));
        $field->confirmRemove();
        $field->fullWidth();
        $field->collapsed();

        $this->builder->blocks()->each(fn($block) => $field->addLayout($block));

        if ($this->builder->hasSearchableLayouts()) {

            $field->menu(
                'flexible-search-menu',
                [
                    'selectLabel' => 'Press enter to select',
                    // the property on the layout entry
                    'label' => 'title',
                    // 'top', 'bottom', 'auto'
                    'openDirection' => 'auto',
                ]
            );
        }
    }
}
