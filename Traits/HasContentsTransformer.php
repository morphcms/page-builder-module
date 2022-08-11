<?php

namespace Modules\PageBuilder\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\PageBuilder\Transformers\ContentResource;
use Orion\Http\Resources\Resource;

/**
 * @mixin JsonResource|Resource
 */
trait HasContentsTransformer
{
    public function contentsTransformer()
    {
        return $this->whenLoaded('contentsPublished', fn() => ContentResource::collection($this->contentsPublished));
    }

    public function contentTransformer()
    {
        return $this->whenLoaded('contentPublished', fn() => ContentResource::make($this->contentPublished));
    }
}
