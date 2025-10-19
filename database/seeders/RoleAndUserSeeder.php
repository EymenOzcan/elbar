<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        Role::firstOrCreate(
            ['name' => 'group-leader'],
            ['guard_name' => 'web']
        );

        Role::firstOrCreate(
            ['name' => 'team-leader'],
            ['guard_name' => 'web']
        );

        Role::firstOrCreate(
            ['name' => 'personnel'],
            ['guard_name' => 'web']
        );

        // Create Test Users
        
        // Grup Lideri
        $groupLeader = User::firstOrCreate(
            ['email' => 'grup-lideri@test.local'],
            [
                'name' => 'Ahmet Yılmaz (Grup Lideri)',
                'password' => Hash::make('password123')
            ]
        );
        $groupLeader->syncRoles(['group-leader']);

        // Takım Lideri 1
        $teamLeader1 = User::firstOrCreate(
            ['email' => 'takim-lideri-1@test.local'],
            [
                'name' => 'Fatih Kaya (Takım Lideri 1)',
                'password' => Hash::make('password123')
            ]
        );
        $teamLeader1->syncRoles(['team-leader']);

        // Takım Lideri 2
        $teamLeader2 = User::firstOrCreate(
            ['email' => 'takim-lideri-2@test.local'],
            [
                'name' => 'Zeynep Demir (Takım Lideri 2)',
                'password' => Hash::make('password123')
            ]
        );
        $teamLeader2->syncRoles(['team-leader']);

        // Personel
        $personnel = User::firstOrCreate(
            ['email' => 'personel@test.local'],
            [
                'name' => 'Emre Sözen (Personel)',
                'password' => Hash::make('password123')
            ]
        );
        $personnel->syncRoles(['personnel']);

        $this->command->info('✅ Roller ve test kullanıcıları oluşturuldu!');
    }
}
