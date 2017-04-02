<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \HttpOz\Roles\Models\Role::create([
            'name' => 'Super Admin',
            'slug' => 'super',
         ]);
         
         \HttpOz\Roles\Models\Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
         ]);
         
         \HttpOz\Roles\Models\Role::create([
            'name' => 'Member',
            'slug' => 'member',
         ]);
         
         \HttpOz\Roles\Models\Role::create([
            'name' => 'Deactivated',
            'slug' => 'deactivated',
         ]);
    }
}
