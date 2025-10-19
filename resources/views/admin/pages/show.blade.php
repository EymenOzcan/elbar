<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                @if($page->image)
                <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->translations->first()->title ?? 'Sayfa' }}" class="h-12 w-12 rounded-lg object-cover shadow">
                @else
                <div class="h-12 w-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white text-xl font-bold shadow">
                    📄
                </div>
                @endif
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $page->translations->first()->title ?? 'Sayfa Detayları' }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $page->slug }}</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pages.edit', $page) }}" 
                   style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center;"
                   onmouseover="this.style.backgroundColor='#1d4ed8'"
                   onmouseout="this.style.backgroundColor='#2563eb'">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Düzenle
                </a>
                <a href="{{ route('admin.pages.index') }}" 
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
                    <!-- Durum -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 {{ $page->is_active ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-full mb-3">
                            @if($page->is_active)
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                        <p class="text-2xl font-bold {{ $page->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $page->is_active ? 'Aktif' : 'Pasif' }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Durum</p>
                    </div>

                    <!-- Şablon -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full mb-3">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ ucfirst($page->template) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Şablon</p>
                    </div>

                    <!-- Kategoriler -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-3">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $page->categories->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kategoriler</p>
                    </div>

                    <!-- Sıra -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 dark:bg-indigo-900/30 rounded-full mb-3">
                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $page->sort_order }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sıra</p>
                    </div>
                </div>
            </div>

            <!-- Detay Bilgileri -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sol Kolon -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Kategoriler -->
                    @if($page->categories->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Kategoriler
                            </h3>
                            
                            <div class="space-y-2">
                                @foreach($page->categories as $category)
                                <a href="{{ route('admin.categories.show', $category) }}" class="flex items-center p-3 bg-gray-50 dark:bg-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-2xl mr-3" style="background-color: {{ $category->color }}20;">
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
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $category->translations->first()->name ?? $category->slug }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $category->slug }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

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
                                    <p class="text-gray-900 dark:text-gray-100 font-medium mt-1">{{ $page->created_at->format('d.m.Y H:i') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $page->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                                    <p class="text-gray-500 dark:text-gray-400">Son Güncelleme</p>
                                    <p class="text-gray-900 dark:text-gray-100 font-medium mt-1">{{ $page->updated_at->format('d.m.Y H:i') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $page->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sağ Kolon: İçerik -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Görsel -->
                    @if($page->image)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->translations->first()->title ?? 'Sayfa görseli' }}" class="w-full h-64 object-cover">
                    </div>
                    @endif

                    <!-- Çeviriler -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                                Dil Çevirileri ve İçerik
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($page->translations as $translation)
                                <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-5 border-l-4 border-indigo-500">
                                    
                                    <!-- Dil Başlığı -->
                                    <div class="flex items-center mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                                        <span class="text-3xl mr-3">{{ $translation->language->flag }}</span>
                                        <div>
                                            <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $translation->language->name }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $translation->language->code }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Başlık -->
                                    <div class="bg-white dark:bg-gray-900/50 rounded-lg p-4 mb-4">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Sayfa Başlığı</p>
                                        <h5 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $translation->title }}</h5>
                                    </div>

                                    <!-- İçerik -->
                                    @if($translation->content)
                                    <div class="bg-white dark:bg-gray-900/50 rounded-lg p-4 mb-4">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">İçerik</p>
                                        <div class="prose prose-sm max-w-none dark:prose-invert text-gray-700 dark:text-gray-300">
                                            {!! $translation->content !!}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- SEO -->
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
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>