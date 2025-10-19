<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Sayfa Düzenle: {{ $page->translations->first()->title ?? $page->slug }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pages.show', $page) }}" 
                   style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center;"
                   onmouseover="this.style.backgroundColor='#2563eb'"
                   onmouseout="this.style.backgroundColor='#3b82f6'">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Görüntüle
                </a>
                <a href="{{ route('admin.pages.index') }}" 
                   style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center;"
                   onmouseover="this.style.backgroundColor='#4b5563'"
                   onmouseout="this.style.backgroundColor='#6b7280'">
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded">
                <div class="flex">
                    <svg class="h-6 w-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300 mb-2">Formda hatalar var:</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                Genel Bilgiler
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Slug (URL) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="slug" 
                                           id="slug"
                                           value="{{ old('slug', $page->slug) }}"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                           required>
                                </div>

                                <div>
                                    <label for="template" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Şablon <span class="text-red-500">*</span>
                                    </label>
                                    <select name="template" 
                                            id="template"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                        @foreach($templates as $tpl)
                                        <option value="{{ $tpl }}" @if(old('template', $page->template) == $tpl) selected @endif>
                                            {{ ucfirst(str_replace('-', ' ', $tpl)) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Sayfa Görseli
                                    </label>
                                    @if($page->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $page->image) }}" alt="Mevcut görsel" class="h-20 w-auto rounded border">
                                    </div>
                                    @endif
                                    <input type="file" 
                                           name="image" 
                                           id="image"
                                           accept="image/*"
                                           class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>

                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Sıra
                                    </label>
                                    <input type="number" 
                                           name="sort_order" 
                                           id="sort_order"
                                           value="{{ old('sort_order', $page->sort_order ?? 0) }}"
                                           min="0"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div class="flex items-center pt-6">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="is_active"
                                           value="1"
                                           @if(old('is_active', $page->is_active)) checked @endif
                                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Sayfa Aktif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                Kategoriler
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($categories as $category)
                                <div class="flex items-start">
                                    <input type="checkbox" 
                                           name="categories[]" 
                                           id="category_{{ $category->id }}"
                                           value="{{ $category->id }}"
                                           @if($page->categories->contains($category->id)) checked @endif
                                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mt-1">
                                    <label for="category_{{ $category->id }}" class="ml-2 text-sm">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $category->translations->first()->name ?? $category->slug }}
                                        </span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                İçerik ve Çeviriler
                            </h3>

                            <div class="border-b border-gray-200 dark:border-gray-700">
                                <nav class="-mb-px flex space-x-8">
                                    @foreach($languages as $index => $language)
                                    <button type="button"
                                            onclick="switchLanguageTab('lang-{{ $language->id }}')"
                                            id="tab-lang-{{ $language->id }}"
                                            class="language-tab @if($index === 0) border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                        <span class="text-2xl mr-2">{{ $language->flag }}</span>
                                        {{ $language->name }}
                                    </button>
                                    @endforeach
                                </nav>
                            </div>

                            <div class="mt-6">
                                @foreach($languages as $index => $language)
                                @php
                                    $translation = $translations[$language->id] ?? new \App\Models\PageTranslation();
                                @endphp
                                <div id="content-lang-{{ $language->id }}" 
                                     class="language-content @if($index !== 0) hidden @endif space-y-6">
                                    
                                    <div>
                                        <label for="translations_{{ $language->id }}_title" 
                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Sayfa Başlığı ({{ $language->name }}) <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               name="translations[{{ $language->id }}][title]" 
                                               id="translations_{{ $language->id }}_title"
                                               value="{{ old('translations.'.$language->id.'.title', $translation->title) }}"
                                               class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                               @if($index === 0) required @endif>
                                    </div>

                                    <div>
                                        <label for="translations_{{ $language->id }}_content" 
                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            İçerik ({{ $language->name }})
                                        </label>
                                        <textarea name="translations[{{ $language->id }}][content]" 
                                                  id="translations_{{ $language->id }}_content"
                                                  class="ckeditor w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('translations.'.$language->id.'.content', $translation->content) }}</textarea>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">SEO Ayarları</h4>
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Başlık</label>
                                                <input type="text" 
                                                       name="translations[{{ $language->id }}][meta_title]"
                                                       value="{{ old('translations.'.$language->id.'.meta_title', $translation->meta_title) }}"
                                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Açıklama</label>
                                                <textarea name="translations[{{ $language->id }}][meta_description]" rows="2"
                                                          class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('translations.'.$language->id.'.meta_description', $translation->meta_description) }}</textarea>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Anahtar Kelimeler</label>
                                                <input type="text" 
                                                       name="translations[{{ $language->id }}][meta_keywords]"
                                                       value="{{ old('translations.'.$language->id.'.meta_keywords', $translation->meta_keywords) }}"
                                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Bu sayfayı silmek istediğinizden emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background-color: #dc2626; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 500; font-size: 14px; border: none; cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='#b91c1c'"
                                        onmouseout="this.style.backgroundColor='#dc2626'">
                                    Sayfayı Sil
                                </button>
                            </form>
                            
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.pages.index') }}" 
                                   style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 500; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center;"
                                   onmouseover="this.style.backgroundColor='#4b5563'"
                                   onmouseout="this.style.backgroundColor='#6b7280'">
                                    İptal
                                </a>
                                
                                <button type="submit"
                                        style="background-color: #10b981; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 14px; border: none; cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='#059669'"
                                        onmouseout="this.style.backgroundColor='#10b981'">
                                    Güncelle
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>
        function switchLanguageTab(tabId) {
            document.querySelectorAll('.language-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            document.querySelectorAll('.language-tab').forEach(tab => {
                tab.classList.remove('border-indigo-500', 'text-indigo-600');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            
            document.getElementById('content-' + tabId).classList.remove('hidden');
            document.getElementById('tab-' + tabId).classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('tab-' + tabId).classList.add('border-indigo-500', 'text-indigo-600');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                });
            }
        });

        window.addEventListener('load', function() {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].destroy(true);
            }
            
            setTimeout(function() {
                document.querySelectorAll('.ckeditor').forEach(function(textarea) {
                    if (CKEDITOR.instances[textarea.id]) {
                        return;
                    }
                    
                    CKEDITOR.replace(textarea.id, {
                        height: 300,
                        language: 'tr',
                        removePlugins: 'exportpdf,easyimage,cloudservices',
                        allowedContent: true,
                        extraAllowedContent: '*(*);*{*}',
                        versionCheck: false
                    });
                });
            }, 100);
        });
    </script>
</x-app-layout>