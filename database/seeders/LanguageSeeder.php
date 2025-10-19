<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            [
                'name' => 'Türkçe',
                'code' => 'tr',
                'flag' => '🇹🇷',
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'English',
                'code' => 'en',
                'flag' => '🇬🇧',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 2
            ],
            [
                'name' => 'Deutsch',
                'code' => 'de',
                'flag' => '🇩🇪',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 3
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}