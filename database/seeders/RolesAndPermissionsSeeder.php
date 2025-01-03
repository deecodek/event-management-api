<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'create-events', 'read-events', 'update-events', 'delete-events',
            'create-artists', 'read-artists', 'update-artists', 'delete-artists',
            'create-locations', 'read-locations', 'update-locations', 'delete-locations',
            'create-organizers', 'read-organizers', 'update-organizers', 'delete-organizers',
            'manage-roles', 'manage-permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $organizer = Role::create(['name' => 'Organizer']);
        $organizer->givePermissionTo([
            'create-events', 'read-events', 'update-events', 'delete-events',
            'create-artists', 'read-artists', 'update-artists', 'delete-artists',
            'create-locations', 'read-locations', 'update-locations', 'delete-locations',
            'create-organizers', 'read-organizers', 'update-organizers', 'delete-organizers',
        ]);

        $user = Role::create(['name' => 'User']);
        $user->givePermissionTo(['read-events']);
    }
}
