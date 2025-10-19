<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        // İlk önce eski modülleri sil
        Module::whereIn('name', ['secret-wall', 'galleries'])->delete();

        $modules = [
            [
                'name' => 'qr-system',
                'label' => 'QR Kodlar',
                'is_active' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'visual-show',
                'label' => 'Görsel Show',
                'is_active' => false,
                'sort_order' => 2,
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate(
                ['name' => $module['name']],
                $module
            );
        }
    }
}
