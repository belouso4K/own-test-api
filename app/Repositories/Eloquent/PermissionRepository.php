<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission as Model;
use App\Repositories\Contracts\IPermission;

class PermissionRepository extends BaseRepository implements IPermission
{

    public function model() {
        return Model::class;
    }
}
