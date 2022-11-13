<?php

namespace App\Repositories\Contracts;

interface IRole
{
    public function getRoles();
    public function getRoleForEdit($id);
}
