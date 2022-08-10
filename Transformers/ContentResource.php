<?php

namespace Modules\PageBuilder\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\SeoSorcery\Transformers\SeoEntityResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'read_time' => $this->read_time,
            'blocks' => $this->blocks,
            'seo' => $this->whenLoaded('seo', fn() => new SeoEntityResource($this->seo)),
        ];
    }
}
