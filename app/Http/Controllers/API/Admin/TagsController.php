<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\AdminTagCreateRequest;
use App\Http\Requests\AdminTagUpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Tag\TagResource;
use App\Models\Tag;
use App\Repositories\Contracts\ITag;
use Illuminate\Http\Request;

class TagsController extends AdminController
{
    protected $tagRepository;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:viewAny,'.Tag::class)->except(['search']);
        $this->middleware('can:create,'.Tag::class)->only(['store']);
        $this->middleware('can:update,'.Tag::class)->only(['update']);
        $this->middleware('can:delete,'.Tag::class)->only(['delete']);
        $this->tagRepository = app(ITag::class);
    }

    public function index()
    {
        $tag = $this->tagRepository->getTags();

        return TagResource::collection($tag);
    }

    public function search(SearchRequest $request)
    {
        $query = $request->query('search');
        $tag = $this->tagRepository->search($query);

        return TagResource::collection($tag);
    }

    public function store(AdminTagCreateRequest $request)
    {
        $tag = Tag::create($request->all());
        return response()->json(null, 204);
    }

    public function update(AdminTagUpdateRequest $request, Tag $tag)
    {
        $tag->update($request->all());
        return new TagResource($tag);
    }

    public function delete($id)
    {
        $tag = $this->tagRepository
            ->delete(explode(",", $id));

       return response()->json(null, 204);
    }
}
