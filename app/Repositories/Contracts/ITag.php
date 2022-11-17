<?php

namespace App\Repositories\Contracts;

interface ITag
{
    public function getTags();
    public function search($query);
}
