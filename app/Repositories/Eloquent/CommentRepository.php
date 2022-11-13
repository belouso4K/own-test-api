<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment as Model;
use App\Repositories\Contracts\IComment;

class CommentRepository extends BaseRepository implements IComment
{

    public function model()
    {
        return Model::class;
    }

}
