<?php

namespace Modules\PageBuilder\Services;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;
use Modules\PageBuilder\Contracts\IContentReadTimeResolver;
use Modules\PageBuilder\Models\Content;
use Whitecube\NovaFlexibleContent\Layouts\LayoutInterface;

class PageBuilderService
{
    private Collection $layouts;

    private int $searchableThreshold;

    private array $types;

    private array $config;

    public function __construct(array $config)
    {
        $this->layouts = collect();
        $this->config = $config;
        $this->searchableThreshold = $config['layouts_searchable_threshold'];
        $this->types = $config['resource_types'];

        $this->register($config['blocks']);
    }

    public function preset()
    {
        return $this->config['preset'];
    }


    public function calculateReadTime(Content $content): int
    {
        return app(IContentReadTimeResolver::class)->calculate($content, $this->config['words_per_minute']);
    }

    public function register(array|Collection $blocks): static
    {
        foreach ($blocks as $blockClass) {
            $instance = app($blockClass);

            if ($instance instanceof LayoutInterface) {
                $this->layouts->put($instance->name(), $blockClass);
            }
        }

        return $this;
    }

    public function types(array|string $types = [])
    {
        if (empty($types)) {
            return $this->types;
        }

        $this->types = array_merge($this->types, is_string($types) ? [$types] : $types);

        return $this;
    }

    public function blocks(): Collection
    {
        return $this->layouts;
    }

    #[Pure]
    public function hasAnyBlocks(): bool
    {
        return $this->layouts->count() > 0;
    }

    #[Pure]
    public function hasSearchableLayouts(): bool
    {
        return $this->layouts->count() > $this->searchableThreshold;
    }
}
