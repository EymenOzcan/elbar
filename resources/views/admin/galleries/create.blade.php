<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    ✨ Yeni Galeri Oluştur
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Fotoğraf veya video galerinizi oluşturun ve medya dosyalarınızı yükleyin</p>
            </div>
            <a href="{{ route('admin.galleries.index') }}"
               style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
               onmouseover="this.style.backgroundColor='#4b5563'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)'"
               onmouseout="this.style.backgroundColor='#6b7280'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <svg class="h-6 w-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300 mb-2">⚠️ Formda hatalar var:</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.galleries.store') }}" method="POST">
                @csrf

                <!-- Ana Kart -->
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                    <div class="p-8">
                        <!-- Bilgi Banner -->
                        <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-l-4 border-blue-500 p-5 rounded-lg shadow-sm">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-7 w-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-1">💡 İpucu</h3>
                                    <p class="text-sm text-blue-700 dark:text-blue-300">
                                        Önce galeri bilgilerini oluşturun. Medya dosyalarını (fotoğraf/video) galeriye kaydettikten sonra yükleyebilirsiniz.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Genel Bilgiler Bölümü -->
                        <div class="mb-10">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Genel Bilgiler</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Galeri tipini ve temel bilgileri girin</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white dark:bg-gray-800/50 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                                <!-- Galeri Tipi -->
                                <div class="relative">
                                    <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Galeri Tipi <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <select name="type" 
                                            id="type" 
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all"
                                            required>
                                        <option value="photo" {{ old('type') == 'photo' ? 'selected' : '' }}>📷 Fotoğraf Galerisi</option>
                                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>🎥 Video Galerisi</option>
                                    </select>
                                </div>

                                <!-- Slug -->
                                <div class="relative">
                                    <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                                            </svg>
                                            Slug (URL) <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input type="text" 
                                           name="slug" 
                                           id="slug" 
                                           value="{{ old('slug') }}"
                                           placeholder="ornek: kurumsal-etkinlik-2024"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all"
                                           required>
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        URL'de kullanılacak benzersiz tanımlayıcı
                                    </p>
                                </div>

                                <!-- Sıra -->
                                <div class="relative">
                                    <label for="sort_order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"></path>
                                            </svg>
                                            Sıralama
                                        </span>
                                    </label>
                                    <input type="number" 
                                           name="sort_order" 
                                           id="sort_order" 
                                           value="{{ old('sort_order', 0) }}"
                                           min="0"
                                           placeholder="0"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all">
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Küçük sayılar önce gösterilir</p>
                                </div>

                                <!-- Durum -->
                                <div class="flex items-center pt-8">
                                    <div class="relative inline-block w-12 mr-3 align-middle select-none">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               id="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer transition-all duration-200 ease-in-out checked:right-0 checked:border-green-500"
                                               style="right: 1.5rem;">
                                        <label for="is_active" 
                                               class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out"
                                               style="background-color: {{ old('is_active', true) ? '#10b981' : '#d1d5db' }}"></label>
                                    </div>
                                    <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Galeri Aktif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Kategoriler Bölümü -->
                        <div class="mb-10">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Kategoriler</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Bu galeriyi kategorilere bağlayın</p>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800/50 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($categories as $category)
                                        <label for="category_{{ $category->id }}" 
                                               class="relative flex items-start p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer transition-all duration-200">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" 
                                                       name="categories[]" 
                                                       id="category_{{ $category->id }}" 
                                                       value="{{ $category->id }}"
                                                       {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}
                                                       class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 transition-all">
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <span class="font-semibold text-sm text-gray-900 dark:text-gray-100 block">
                                                    {{ $category->translations->first()->name ?? $category->slug }}
                                                </span>
                                                @if($category->translations->first() && $category->translations->first()->description)
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">
                                                        {{ Str::limit($category->translations->first()->description, 50) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Dil Çevirileri Bölümü -->
                        <div class="mb-8">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.578a18.87 18.87 0 01-1.724 4.78c.29.354.596.696.914 1.026a1 1 0 11-1.44 1.389c-.188-.196-.373-.396-.554-.6a19.098 19.098 0 01-3.107 3.567 1 1 0 01-1.334-1.49 17.087 17.087 0 003.13-3.733 18.992 18.992 0 01-1.487-2.494 1 1 0 111.79-.89c.234.47.489.928.764 1.372.417-.934.752-1.913.997-2.927H3a1 1 0 110-2h3V3a1 1 0 011-1zm6 6a1 1 0 01.894.553l2.991 5.982a.869.869 0 01.02.037l.99 1.98a1 1 0 11-1.79.895L15.383 16h-4.764l-.724 1.447a1 1 0 11-1.788-.894l.99-1.98.019-.038 2.99-5.982A1 1 0 0113 8zm-1.382 6h2.764L13 11.236 11.618 14z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Çoklu Dil İçeriği</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Galeri bilgilerini farklı dillerde girin</p>
                                </div>
                            </div>

                            <!-- Modern Dil Sekmeleri -->
                            <div class="bg-white dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                    <nav class="flex space-x-2 p-2">
                                        @foreach($languages as $index => $language)
                                            <button type="button"
                                                    onclick="switchLanguageTab('lang-{{ $language->id }}')"
                                                    id="tab-lang-{{ $language->id }}"
                                                    class="language-tab flex items-center px-6 py-3 rounded-lg font-semibold text-sm transition-all duration-200 {{ $index === 0 ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                                <span class="text-2xl mr-2">{{ $language->flag }}</span>
                                                <span>{{ $language->name }}</span>
                                            </button>
                                        @endforeach
                                    </nav>
                                </div>

                                <!-- Dil İçerikleri -->
                                <div class="p-6">
                                    @foreach($languages as $index => $language)
                                        <div id="content-lang-{{ $language->id }}"
                                             class="language-content {{ $index !== 0 ? 'hidden' : '' }} space-y-6">
                                            
                                            <!-- Başlık -->
                                            <div class="relative">
                                                <label for="translations_{{ $language->id }}_title"
                                                       class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Galeri Başlığı ({{ $language->name }}) 
                                                        @if($index === 0)<span class="text-red-500">*</span>@endif
                                                    </span>
                                                </label>
                                                <input type="text"
                                                       name="translations[{{ $language->id }}][title]"
                                                       id="translations_{{ $language->id }}_title"
                                                       value="{{ old('translations.'.$language->id.'.title') }}"
                                                       placeholder="Örnek: Kurumsal Etkinlik 2024"
                                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all text-lg font-medium"
                                                       {{ $index === 0 ? 'required' : '' }}>
                                            </div>

                                            <!-- Açıklama -->
                                            <div class="relative">
                                                <label for="translations_{{ $language->id }}_description"
                                                       class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Açıklama ({{ $language->name }})
                                                    </span>
                                                </label>
                                                <textarea name="translations[{{ $language->id }}][description]"
                                                          id="translations_{{ $language->id }}_description"
                                                          rows="4"
                                                          placeholder="Galeri hakkında kısa bir açıklama yazın..."
                                                          class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all">{{ old('translations.'.$language->id.'.description') }}</textarea>
                                            </div>

                                            <!-- SEO Ayarları -->
                                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 p-6 rounded-xl border-2 border-dashed border-amber-300 dark:border-amber-700">
                                                <div class="flex items-center mb-4">
                                                    <svg class="w-6 h-6 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    <h4 class="text-base font-bold text-amber-800 dark:text-amber-300">SEO Optimizasyonu</h4>
                                                </div>
                                                <div class="space-y-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meta Başlık</label>
                                                        <input type="text"
                                                               name="translations[{{ $language->id }}][meta_title]"
                                                               value="{{ old('translations.'.$language->id.'.meta_title') }}"
                                                               placeholder="Arama motorları için başlık"
                                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500 shadow-sm transition-all">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meta Açıklama</label>
                                                        <textarea name="translations[{{ $language->id }}][meta_description]"
                                                                  rows="2"
                                                                  placeholder="Arama sonuçlarında görünecek kısa açıklama"
                                                                  class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500 shadow-sm transition-all">{{ old('translations.'.$language->id.'.meta_description') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Aksiyon Butonları -->
                        <div class="flex items-center justify-between pt-8 border-t-2 border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.galleries.index') }}"
                               style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-size: 15px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)'"
                               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                İptal
                            </a>

                            <button type="submit"
                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; display: inline-flex; align-items: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(16, 185, 129, 0.4)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.3)'">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                ✨ Galeriyi Oluştur
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .toggle-checkbox:checked {
            right: 0;
            border-color: #10b981;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #10b981;
        }
    </style>

    <script>
        function switchLanguageTab(tabId) {
            // Tüm içerikleri gizle
            document.querySelectorAll('.language-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Tüm sekmeleri pasif yap
            document.querySelectorAll('.language-tab').forEach(tab => {
                tab.classList.remove('bg-gradient-to-r', 'from-indigo-500', 'to-purple-500', 'text-white', 'shadow-lg');
                tab.classList.add('bg-white', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300');
            });

            // Seçili içeriği göster
            document.getElementById('content-' + tabId).classList.remove('hidden');

            // Seçili sekmeyi aktif yap
            const activeTab = document.getElementById('tab-' + tabId);
            activeTab.classList.remove('bg-white', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300');
            activeTab.classList.add('bg-gradient-to-r', 'from-indigo-500', 'to-purple-500', 'text-white', 'shadow-lg');
        }

        // Form submit'te gizli sekmelerdeki required'ları kaldır
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    document.querySelectorAll('.language-content.hidden input[required]').forEach(input => {
                        input.removeAttribute('required');
                    });
                });
            }
        });
    </script>
</x-app-layout>