<?php
namespace App\Repositories\Eloquent;

use App\Models\User as Model;
use App\Repositories\Contracts\IUser;

class UserRepository extends BaseRepository implements IUser {

    public function model()
    {
        return Model::class;
    }

    public function getAllUsersDoesntHaveRole()
    {
       return $this->model
           ->doesntHave('roles')
           ->orderBy('created_at', 'DESC')
           ->paginate();
    }

    public function search($query)
    {
        return $this->model
            ->doesntHave('roles')
            ->where('email', 'like', "%$query%")
            ->orderBy('created_at', 'DESC')
            ->paginate();
    }

}
