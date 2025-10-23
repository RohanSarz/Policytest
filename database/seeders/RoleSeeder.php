<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::findOrCreate('admin');
        $moderator = Role::findOrCreate('moderator');
        $editor = Role::findOrCreate('editor');
        $user = Role::findOrCreate('user');

        $permissions = ['manage-users','manage-roles', 'manage-permissions','show-posts', 'edit-posts', 'create-posts', 'delete-posts',  ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $admin->givePermissionTo($permissions);
        $moderator->givePermissionTo(['show-posts', 'edit-posts', 'create-posts', 'delete-posts']);
        $user->givePermissionTo(['show-posts', 'create-posts', 'edit-posts']);

        Role::findByName('admin')->givePermissionTo();
    }
}
