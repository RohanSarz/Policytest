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
        $suspended = Role::findOrCreate('suspended');
        // Define all permissions that can be assigned
        $permissions = [
            'manage-users', // Allows managing user accounts (e.g., editing roles, deactivating)
            'manage-roles', // Allows managing roles (e.g., creating, editing, deleting roles)
            'manage-permissions', // Allows managing permissions (e.g., assigning permissions to roles)
            'approve-posts', // Allows approving content (e.g., posts, comments)
            'show-posts', // Allows viewing posts
            'edit-posts', // Allows editing existing posts
            'create-posts', // Allows creating new posts
            'delete-posts', // Allows deleting posts
        ];

        foreach ($permissions as $permission) {
            // Create each permission if it doesn't already exist
            Permission::findOrCreate($permission);
        }

        $admin->givePermissionTo($permissions);
        $moderator->givePermissionTo(['approve-posts', 'show-posts', 'edit-posts', 'create-posts', 'delete-posts']);
        $editor->givePermissionTo(['show-posts', 'edit-posts', 'create-posts']);
        $user->givePermissionTo(['show-posts', 'create-posts']);
        $suspended->givePermissionTo(['show-posts']);
    }
}
