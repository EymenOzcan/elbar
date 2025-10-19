<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

echo "📝 Roller oluşturuluyor...\n";

// Create Roles
$groupLeaderRole = Role::firstOrCreate(
    ['name' => 'group-leader'],
    ['guard_name' => 'web']
);
echo "✅ group-leader rolü oluşturuldu\n";

$teamLeaderRole = Role::firstOrCreate(
    ['name' => 'team-leader'],
    ['guard_name' => 'web']
);
echo "✅ team-leader rolü oluşturuldu\n";

$personnelRole = Role::firstOrCreate(
    ['name' => 'personnel'],
    ['guard_name' => 'web']
);
echo "✅ personnel rolü oluşturuldu\n";

// Create Test Users
echo "\n👥 Test kullanıcıları oluşturuluyor...\n\n";

$groupLeader = User::firstOrCreate(
    ['email' => 'grup-lideri@test.local'],
    [
        'name' => 'Ahmet Yılmaz (Grup Lideri)',
        'password' => Hash::make('password123')
    ]
);
$groupLeader->syncRoles(['group-leader']);
echo "✅ Grup Lideri: grup-lideri@test.local / password123\n";

$teamLeader1 = User::firstOrCreate(
    ['email' => 'takim-lideri-1@test.local'],
    [
        'name' => 'Fatih Kaya (Takım Lideri 1)',
        'password' => Hash::make('password123')
    ]
);
$teamLeader1->syncRoles(['team-leader']);
echo "✅ Takım Lideri 1: takim-lideri-1@test.local / password123\n";

$teamLeader2 = User::firstOrCreate(
    ['email' => 'takim-lideri-2@test.local'],
    [
        'name' => 'Zeynep Demir (Takım Lideri 2)',
        'password' => Hash::make('password123')
    ]
);
$teamLeader2->syncRoles(['team-leader']);
echo "✅ Takım Lideri 2: takim-lideri-2@test.local / password123\n";

$personnel = User::firstOrCreate(
    ['email' => 'personel@test.local'],
    [
        'name' => 'Emre Sözen (Personel)',
        'password' => Hash::make('password123')
    ]
);
$personnel->syncRoles(['personnel']);
echo "✅ Personel: personel@test.local / password123\n";

echo "\n✨ Tüm roller ve kullanıcılar oluşturuldu!\n";
