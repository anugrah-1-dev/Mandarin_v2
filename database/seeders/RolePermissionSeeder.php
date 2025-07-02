<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat permission
        $permissions = ['akses admin', 'akses officer', 'akses leader camp', 'akses guest'];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Buat role dan berikan permission
        $roles = [
            'admin' => ['akses admin'],
            'officer' => ['akses officer'],
            'leader camp' => ['akses leader camp'],
            'user   ' => ['akses guest'],
        ];

        foreach ($roles as $role => $perms) {
            $role = Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }
    }
}
