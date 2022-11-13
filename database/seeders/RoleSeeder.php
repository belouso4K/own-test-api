<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = new Role();
        $superAdmin->name = 'Супер админ';
        $superAdmin->slug = 'super-admin';
        $superAdmin->save();

        $admin = new Role();
        $admin->name = 'Админ';
        $admin->slug = 'admin';
        $admin->save();
    }
}
