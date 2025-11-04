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
            'manage_users', // Allows managing user accounts (e.g., editing roles, deactivating)
            'manage_roles', // Allows managing roles (e.g., creating, editing, deleting roles)
            'manage_permissions', // Allows managing permissions (e.g., assigning permissions to roles)
            'approve_posts', // Allows approving content (e.g., posts, comments)
            'show_posts', // Allows viewing posts
            'edit_posts', // Allows editing existing posts
            'create_posts', // Allows creating new posts
            'delete_posts', // Allows deleting posts
        ];

        foreach ($permissions as $permission) {
            // Create each permission if it doesn't already exist
            Permission::findOrCreate($permission);
        }

        $admin->givePermissionTo($permissions);
        $moderator->givePermissionTo(['approve_posts', 'show_posts', 'edit_posts', 'create_posts', 'delete_posts']);
        $editor->givePermissionTo(['show_posts', 'edit_posts', 'create_posts']);
        $user->givePermissionTo(['show_posts', 'create_posts']);
        $suspended->givePermissionTo(['show_posts']);
    }
}
