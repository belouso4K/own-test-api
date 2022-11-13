<?php

namespace App\Repositories\Contracts;

interface IUser
{
    public function getAllUsersDoesntHaveRole();
    public function search($query);
}
