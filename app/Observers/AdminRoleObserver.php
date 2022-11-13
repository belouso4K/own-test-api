<?php

namespace App\Observers;

use App\Models\Role;

class AdminRoleObserver
{
    public function creating(Role $role)
    {
        $this->getAlias($role);
    }
    /**
     * Handle the Role "created" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        $role->permissions()->attach([6,2,10]);
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        //
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }

    public function getAlias(Role $role)
    {
        if (empty($role->slug)) {
            $role->slug = \Str::slug($role->title);
            $check = Role::where('slug', '=', $role->slug)->exists();
            if ($check) {
                $role->slug = \Str::slug($role->title) . time();
            }
        }
    }
}
