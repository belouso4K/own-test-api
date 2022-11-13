<?php

namespace App\Http\Resources\Admin\Post;

use App\Http\Resources\Admin\Tag\TagResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap = '';

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('DD.MM.YYYY'),
            'title' => $this->title,
            'desc' => $this->desc,
            'img' => env('APP_URL'). '/storage/posts/' . $this->img,
            'status' => $this->status,
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
