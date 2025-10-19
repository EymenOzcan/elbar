<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div style="font-size: 40px;">
                    @if($category->icon == 'phone')
                        📞
                    @elseif($category->icon == 'server')
                        🖥️
                    @elseif($category->icon == 'film')
                        🎬
                    @elseif($category->icon == 'palette')
                        🎨
                    @elseif($category->icon == 'music')
                        🎵
                    @elseif($category->icon == 'cpu')
                        💻
                    @else
                        📁
                    @endif
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $category->translations->where('language_id', 1)->first()->name ?? 'Kategori' }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $category->slug }}</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.categories.edit', $category) }}" 
                   style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center;"
                   onmouseover="this.style.backgroundColor='#1d4ed8'"
                   onmouseout="this.style.backgroundColor='#2563eb'">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Düzenle
                </a>
                <a href="{{ route('admin.categories.index') }}" 
                   style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center;"
                   onmouseover="this.style.backgroundColor='#4b5563'"
                   onmouseout="this.style.backgroundColor='#6b7280'">
                    ← Geri
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- İstatistik Kartları -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
                    <!-- Sayfalar -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-3">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $category->pages->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sayfalar</p>
                    </div>

                    <!-- Hizmetler -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full mb-3">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $category->services->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Hizmetler</p>
                    </div>

                    <!-- Alt Kategoriler -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full mb-3">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $category->children->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Alt Kategoriler</p>
                    </div>

                    <!-- Durum -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 {{ $category->is_active ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-full mb-3">
                            @if($category->is_active)
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                        <p class="text-2xl font-bold {{ $category->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            @if($category->is_active)
                                Aktif
                            @else
                                Pasif
                            @endif
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Durum</p>
                    </div>
                </div>
            </div>

            <!-- Detay Bilgileri -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sol Kolon: Genel Bilgiler -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Kategori Ayarları -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Ayarlar
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Menüde Göster</span>
                                    @if($category->show_in_menu)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✓ Evet</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">✗ Hayır</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Ana Sayfada Göster</span>
                                    @if($category->show_in_home)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✓ Evet</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">✗ Hayır</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Sıra</span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $category->sort_order }}</span>
                                </div>

                                @if($category->color)
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Tema Rengi</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-lg border-2 border-gray-300 shadow-sm" style="background-color: {{ $category->color }};"></div>
                                        <span class="text-xs font-mono text-gray-500">{{ $category->color }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tarihler -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Zaman Bilgisi
                            </h3>
                            
                            <div class="space-y-3 text-sm">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Oluşturulma</p>
                                    <p class="text-gray-900 dark:text-gray-100 font-medium mt-1">{{ $category->created_at->format('d.m.Y H:i') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $category->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                                    <p class="text-gray-500 dark:text-gray-400">Son Güncelleme</p>
                                    <p class="text-gray-900 dark:text-gray-100 font-medium mt-1">{{ $category->updated_at->format('d.m.Y H:i') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $category->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Silme Butonu -->
                    @if($category->pages->count() == 0 && $category->services->count() == 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-red-600 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Tehlikeli Bölge
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Bu işlem geri alınamaz. Kategoriyi kalıcı olarak sileceksiniz.</p>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Bu kategoriyi kalıcı olarak silmek istediğinizden emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background-color: #dc2626; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; width: 100%; justify-content: center; border: none; cursor: pointer; transition: all 0.3s;"
                                        onmouseover="this.style.backgroundColor='#b91c1c'; this.style.transform='scale(1.02)'"
                                        onmouseout="this.style.backgroundColor='#dc2626'; this.style.transform='scale(1)'">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Kategoriyi Sil
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sağ Kolon: İçerik -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Çeviriler -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                                Dil Çevirileri
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($category->translations as $translation)
                                <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-5 border-l-4" style="border-left-color: {{ $category->color ?? '#6b7280' }};">
                                    
                                    <!-- Dil Başlığı -->
                                    <div class="flex items-center mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                                        <span class="text-3xl mr-3">{{ $translation->language->flag }}</span>
                                        <div>
                                            <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $translation->language->name }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $translation->language->code }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- İçerik -->
                                    <div class="space-y-4">
                                        <!-- Kategori Adı -->
                                        <div class="bg-white dark:bg-gray-900/50 rounded-lg p-4">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-5 h-5 text-indigo-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Kategori Adı</p>
                                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $translation->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Açıklama -->
                                        @if($translation->description)
                                        <div class="bg-white dark:bg-gray-900/50 rounded-lg p-4">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Açıklama</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $translation->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- SEO Bilgileri -->
                                        @if($translation->meta_title || $translation->meta_description || $translation->meta_keywords)
                                        <div class="bg-amber-50 dark:bg-amber-900/10 rounded-lg p-4 border border-amber-200 dark:border-amber-800">
                                            <div class="flex items-start mb-3">
                                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                                <p class="ml-2 text-xs font-bold text-amber-700 dark:text-amber-500 uppercase tracking-wider">SEO Bilgileri</p>
                                            </div>
                                            <div class="space-y-2 ml-7">
                                                @if($translation->meta_title)
                                                <div>
                                                    <p class="text-xs font-semibold text-amber-600 dark:text-amber-500">Meta Başlık</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $translation->meta_title }}</p>
                                                </div>
                                                @endif
                                                @if($translation->meta_description)
                                                <div>
                                                    <p class="text-xs font-semibold text-amber-600 dark:text-amber-500">Meta Açıklama</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $translation->meta_description }}</p>
                                                </div>
                                                @endif
                                                @if($translation->meta_keywords)
                                                <div>
                                                    <p class="text-xs font-semibold text-amber-600 dark:text-amber-500">Anahtar Kelimeler</p>
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @foreach(explode(',', $translation->meta_keywords) as $keyword)
                                                        <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs rounded">{{ trim($keyword) }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Bağlı Sayfalar -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Bağlı Sayfalar
                                    <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $category->pages->count() }}</span>
                                </h3>
                                
                                <a href="{{ route('admin.pages.create') }}" 
                                   style="background-color: #10b981; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
                                   onmouseover="this.style.backgroundColor='#059669'; this.style.transform='translateY(-2px)'"
                                   onmouseout="this.style.backgroundColor='#10b981'; this.style.transform='translateY(0)'">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Yeni Sayfa
                                </a>
                            </div>
                            
                            @if($category->pages->count() > 0)
                            <div class="space-y-2">
                                @foreach($category->pages->take(10) as $page)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $page->translations->first()->title ?? 'Başlıksız' }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-1">{{ $page->slug }}</p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        @if($page->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">Pasif</span>
                                        @endif
                                        <a href="{{ route('admin.pages.show', $page) }}" 
                                           class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-medium text-sm">
                                            Görüntüle →
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @if($category->pages->count() > 10)
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Ve {{ $category->pages->count() - 10 }} sayfa daha...
                                </p>
                            </div>
                            @endif
                            @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Bu kategoride henüz sayfa yok</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Bu kategoriye ait ilk sayfayı oluşturun.</p>
                                <div class="mt-6">
                                    <a href="{{ route('admin.pages.create') }}"
                                       style="background-color: #10b981; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
                                       onmouseover="this.style.backgroundColor='#059669'; this.style.transform='scale(1.05)'"
                                       onmouseout="this.style.backgroundColor='#10b981'; this.style.transform='scale(1)'">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        İlk Sayfayı Oluştur
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>