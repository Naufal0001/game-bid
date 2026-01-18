<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles & permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * PERMISSIONS
         */
        $userPermissions = [
            'bid auction',
            'buyout auction',
            'view transaction',
            'view auction',
        ];

        $sellerPermissions = [
            'create item',
            'create auction',
            'edit own auction',
            'delete own auction',
        ];

        $adminPermissions = [
            'manage auction',
            'manage item',
            'manage user',
            'verify seller',
            'view reports',
        ];

        // Create all permissions
        foreach (array_merge(
            $userPermissions,
            $sellerPermissions,
            $adminPermissions
        ) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /**
         * ROLES
         */
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        /**
         * ASSIGN PERMISSIONS
         */
        // Admin gets all permissions
        $adminRole->syncPermissions(Permission::all());

        // User gets default permissions only
        $userRole->syncPermissions($userPermissions);
    }
}
