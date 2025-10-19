<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            
            // Role management
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            
            // Content management
            'content-list',
            'content-create',
            'content-edit',
            'content-delete',
            
            // Settings
            'settings-edit',
            
            // Reports
            'reports-view',
            'reports-export',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // 1. Super Admin - tüm yetkiler
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        
        // 2. Admin - çoğu yetki
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'user-list',
            'user-create',
            'user-edit',
            'content-list',
            'content-create',
            'content-edit',
            'content-delete',
            'reports-view',
        ]);
        
        // 3. Editor - içerik yönetimi
        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'content-list',
            'content-create',
            'content-edit',
        ]);
        
        // 4. Viewer - sadece görüntüleme
        $viewerRole = Role::create(['name' => 'viewer']);
        $viewerRole->givePermissionTo([
            'content-list',
            'reports-view',
        ]);

        // Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@el-bar.com',
            'password' => Hash::make('password123'),
        ]);
        $superAdmin->assignRole('super-admin');

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@el-bar.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        // Create Editor User
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@el-bar.com',
            'password' => Hash::make('password123'),
        ]);
        $editor->assignRole('editor');
    }
}