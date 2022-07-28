<?php

namespace Modules\PageBuilder\Resolvers;

use Modules\PageBuilder\Models\Content;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class BlocksResolver
{
    public function __invoke(Content $model): \Illuminate\Support\Collection|\Whitecube\NovaFlexibleContent\Layouts\Collection
    {
        return $model->data->map(function (Layout $layout) use($model) {
            $layout->setModel($model);

            $result = [
                'name' => $layout->name(),
                'data' => $this->getLayoutDataLocalized($layout),
            ];

            if ($layout instanceof HasMedia) {
                $result['data']['media'] = $layout->getMedia('images')->map(fn(Media $media) => [
                    'url' => $media->getFullUrl(),
                    'meta' => $media->custom_properties,
                ]);
            }

            return $result;
        });
    }

    private function getLayoutDataLocalized($layout): \Illuminate\Support\Collection
    {
        // This is needed to work with the package spatie/translations
        return collect($layout->toArray())
            ->mapWithKeys(fn($value, $key) => [$key => $layout->{$key}]);
    }
}
