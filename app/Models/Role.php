<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $perPage = 15;

    protected $fillable = [
        'name',
        'desc',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'users_roles', 'role_id', 'user_id');
    }

//    public function getPermissionsGroupAttribute() {
//        $permissions = array();
//
//        foreach ($this->permissions as $permission) {
//            if(!in_array($permission['group_slug'], array_keys($permissions))) {
//
//                $permissions[$permission['group_slug']] = [
//                    'group_slug' => $permission['group_slug'],
//                    'group_name' => $permission['group_name'],
//                    'actions' => [$permission['name']]
//                ];
//            } else {
//                $permissions[$permission['group_slug']]['actions'][] = $permission['name'];
//            }
//        }
//        return $permissions;
//    }



    public function getPermissionsGroupAttribute() {
        $permissions = $this->allFieldsWithPermissions();

        foreach ($this->permissions as $permission) {
            $permissions[$permission['group_slug']]['actions'][] = $permission['name'];
        }

        return $permissions;
    }

    public function allFieldsWithPermissions() {
        $permissions = array();
        $permissions_db = Permission::distinct()->get(['group_slug', 'group_name']);

        foreach ($permissions_db as $permission) {
            $permissions[$permission['group_slug']] = [
                'group_slug' => $permission['group_slug'],
                'group_name' => $permission['group_name'],
                'actions' => []
            ];
        }
        return $permissions;
    }

//    public function permissionsGroup($permission) {
//        $permissions = array();
//
//        if(!in_array($permission['group_slug'], array_keys($permissions))) {
//
//            $permissions[$permission['group_slug']] = [
//                'group_slug' => $permission['group_slug'],
//                'group_name' => $permission['group_name'],
//                'actions' => [$permission['name']]
//            ];
//        } else {
//            $permissions[$permission['group_slug']]['actions'][] = $permission['name'];
//        }
//
//        return $permissions;
//    }

}
