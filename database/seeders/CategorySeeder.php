<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $languages = Language::all();
        
        if ($languages->isEmpty()) {
            $this->command->error('Önce dilleri eklemelisiniz: php artisan db:seed --class=LanguageSeeder');
            return;
        }
        
        $categories = [
            [
                'slug' => 'voip',
                'icon' => 'phone',
                'color' => '#3b82f6',
                'show_in_home' => true,
                'translations' => [
                    'tr' => ['name' => 'VoIP Çözümleri', 'description' => 'Kurumsal VoIP telefon sistemleri ve çözümleri'],
                    'en' => ['name' => 'VoIP Solutions', 'description' => 'Enterprise VoIP phone systems and solutions'],
                    'de' => ['name' => 'VoIP-Lösungen', 'description' => 'Enterprise VoIP-Telefonsysteme und Lösungen']
                ]
            ],
            [
                'slug' => 'server',
                'icon' => 'server',
                'color' => '#10b981',
                'show_in_home' => true,
                'translations' => [
                    'tr' => ['name' => 'Sunucu Hizmetleri', 'description' => 'Sunucu kiralama ve yönetim hizmetleri'],
                    'en' => ['name' => 'Server Services', 'description' => 'Server rental and management services'],
                    'de' => ['name' => 'Server-Dienste', 'description' => 'Server-Vermietung und Verwaltungsdienste']
                ]
            ],
            [
                'slug' => 'cinema',
                'icon' => 'film',
                'color' => '#f59e0b',
                'show_in_home' => true,
                'translations' => [
                    'tr' => ['name' => 'Sinema Sistemleri', 'description' => 'Profesyonel sinema ve projeksiyon sistemleri'],
                    'en' => ['name' => 'Cinema Systems', 'description' => 'Professional cinema and projection systems'],
                    'de' => ['name' => 'Kino-Systeme', 'description' => 'Professionelle Kino- und Projektionssysteme']
                ]
            ],
            [
                'slug' => 'art',
                'icon' => 'palette',
                'color' => '#8b5cf6',
                'show_in_home' => true,
                'translations' => [
                    'tr' => ['name' => 'Sanat Hizmetleri', 'description' => 'Sanat danışmanlığı ve galeri hizmetleri'],
                    'en' => ['name' => 'Art Services', 'description' => 'Art consulting and gallery services'],
                    'de' => ['name' => 'Kunstdienstleistungen', 'description' => 'Kunstberatung und Galeriedienste']
                ]
            ],
            [
                'slug' => 'entertainment',
                'icon' => 'music',
                'color' => '#ec4899',
                'show_in_home' => true,
                'translations' => [
                    'tr' => ['name' => 'Eğlence Sektörü', 'description' => 'Etkinlik organizasyonu ve sahne sistemleri'],
                    'en' => ['name' => 'Entertainment Industry', 'description' => 'Event organization and stage systems'],
                    'de' => ['name' => 'Unterhaltungsindustrie', 'description' => 'Veranstaltungsorganisation und Bühnensysteme']
                ]
            ],
            [
                'slug' => 'technology',
                'icon' => 'cpu',
                'color' => '#06b6d4',
                'show_in_home' => true,
                'translations' => [
                    'tr' => ['name' => 'Teknoloji Çözümleri', 'description' => 'Yazılım geliştirme ve teknoloji danışmanlığı'],
                    'en' => ['name' => 'Technology Solutions', 'description' => 'Software development and technology consulting'],
                    'de' => ['name' => 'Technologie-Lösungen', 'description' => 'Softwareentwicklung und Technologieberatung']
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $translations = $categoryData['translations'];
            unset($categoryData['translations']);
            
            // Kategori zaten var mı kontrol et
            $category = Category::where('slug', $categoryData['slug'])->first();
            
            if (!$category) {
                $category = Category::create($categoryData);
                $this->command->info("Kategori oluşturuldu: {$categoryData['slug']}");
            } else {
                $category->update($categoryData);
                $this->command->info("Kategori güncellendi: {$categoryData['slug']}");
            }
            
            foreach ($languages as $language) {
                if (isset($translations[$language->code])) {
                    CategoryTranslation::updateOrCreate(
                        [
                            'category_id' => $category->id,
                            'language_id' => $language->id
                        ],
                        [
                            'name' => $translations[$language->code]['name'],
                            'description' => $translations[$language->code]['description']
                        ]
                    );
                }
            }
        }
        
        $this->command->info('Kategoriler başarıyla eklendi/güncellendi!');
    }
}