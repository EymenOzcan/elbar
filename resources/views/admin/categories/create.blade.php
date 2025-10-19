<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Yeni Kategori Ekle') }}
            </h2>
            <a href="{{ route('admin.categories.index') }}" 
               style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
               onmouseover="this.style.backgroundColor='#4b5563'" 
               onmouseout="this.style.backgroundColor='#6b7280'">
                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Sol Kolon - Genel Bilgiler -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Genel Bilgiler</h3>
                                
                                <!-- Slug -->
                                <div class="mb-4">
                                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span style="color: #dc2626;">*</span> Slug (URL)
                                    </label>
                                    <input type="text" 
                                           name="slug" 
                                           id="slug" 
                                           value="{{ old('slug') }}" 
                                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                           required 
                                           placeholder="ornek-kategori">
                                    <p class="text-xs text-gray-500 mt-1">URL'de kullanılacak benzersiz isim</p>
                                    @error('slug')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ana Kategori -->
                                <div class="mb-4">
                                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Ana Kategori
                                    </label>
                                    <select name="parent_id" 
                                            id="parent_id" 
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                        <option value="">Ana Kategori (Yok)</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->translations->first()->name ?? $parent->slug }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- İkon Seçimi -->
                                <div class="mb-4">
                                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        İkon
                                    </label>
                                    <select name="icon" 
                                            id="icon" 
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                        <option value="">İkon Seçin</option>
                                        <option value="phone" {{ old('icon') == 'phone' ? 'selected' : '' }}>📞 Telefon</option>
                                        <option value="server" {{ old('icon') == 'server' ? 'selected' : '' }}>🖥️ Sunucu</option>
                                        <option value="film" {{ old('icon') == 'film' ? 'selected' : '' }}>🎬 Film</option>
                                        <option value="palette" {{ old('icon') == 'palette' ? 'selected' : '' }}>🎨 Palet</option>
                                        <option value="music" {{ old('icon') == 'music' ? 'selected' : '' }}>🎵 Müzik</option>
                                        <option value="cpu" {{ old('icon') == 'cpu' ? 'selected' : '' }}>💻 İşlemci</option>
                                        <option value="briefcase" {{ old('icon') == 'briefcase' ? 'selected' : '' }}>💼 Çanta</option>
                                        <option value="chart" {{ old('icon') == 'chart' ? 'selected' : '' }}>📊 Grafik</option>
                                    </select>
                                </div>

                                <!-- Renk -->
                                <div class="mb-4">
                                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Tema Rengi
                                    </label>
                                    <input type="color" 
                                           name="color" 
                                           id="color" 
                                           value="{{ old('color', '#3b82f6') }}" 
                                           class="w-full h-10 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                </div>

                                <!-- Görsel -->
                                <div class="mb-4">
                                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Kategori Görseli
                                    </label>
                                    <input type="file" 
                                           name="image" 
                                           id="image" 
                                           accept="image/*"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                </div>

                                <!-- Sıralama -->
                                <div class="mb-4">
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Sıralama
                                    </label>
                                    <input type="number" 
                                           name="sort_order" 
                                           id="sort_order" 
                                           value="{{ old('sort_order', 0) }}" 
                                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                </div>

                                <!-- Seçenekler -->
                                <div class="space-y-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Aktif</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="show_in_menu" 
                                               value="1" 
                                               {{ old('show_in_menu', true) ? 'checked' : '' }}
                                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Menüde Göster</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="show_in_home" 
                                               value="1" 
                                               {{ old('show_in_home') ? 'checked' : '' }}
                                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ana Sayfada Göster</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sağ Kolon - Çeviriler -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Çeviriler</h3>

                                <!-- Dil Sekmeleri -->
                                <div class="border-b border-gray-200 dark:border-gray-700">
                                    <nav class="-mb-px flex space-x-8">
                                        @foreach($languages as $index => $language)
                                        <button type="button"
                                                onclick="showTab('{{ $language->code }}')"
                                                id="tab-{{ $language->code }}"
                                                class="tab-button {{ $index === 0 ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            {{ $language->flag }} {{ $language->name }}
                                        </button>
                                        @endforeach
                                    </nav>
                                </div>

                                <!-- Dil İçerikleri -->
                                @foreach($languages as $index => $language)
                                <div id="content-{{ $language->code }}" class="tab-content {{ $index !== 0 ? 'hidden' : '' }} mt-6">
                                    <div class="space-y-4">
                                        <!-- Kategori Adı -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <span style="color: #dc2626;">*</span> Kategori Adı ({{ $language->name }})
                                            </label>
                                            <input type="text" 
                                                   name="translations[{{ $language->id }}][name]" 
                                                   value="{{ old('translations.'.$language->id.'.name') }}" 
                                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                                   required>
                                            @error('translations.'.$language->id.'.name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Açıklama -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Açıklama ({{ $language->name }})
                                            </label>
                                            <textarea name="translations[{{ $language->id }}][description]" 
                                                      rows="3"
                                                      class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('translations.'.$language->id.'.description') }}</textarea>
                                        </div>

                                        <!-- SEO Başlık -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Meta Başlık ({{ $language->name }})
                                            </label>
                                            <input type="text" 
                                                   name="translations[{{ $language->id }}][meta_title]" 
                                                   value="{{ old('translations.'.$language->id.'.meta_title') }}" 
                                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                        </div>

                                        <!-- SEO Açıklama -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Meta Açıklama ({{ $language->name }})
                                            </label>
                                            <textarea name="translations[{{ $language->id }}][meta_description]" 
                                                      rows="2"
                                                      class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('translations.'.$language->id.'.meta_description') }}</textarea>
                                        </div>

                                        <!-- Anahtar Kelimeler -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Anahtar Kelimeler ({{ $language->name }})
                                            </label>
                                            <input type="text" 
                                                   name="translations[{{ $language->id }}][meta_keywords]" 
                                                   value="{{ old('translations.'.$language->id.'.meta_keywords') }}" 
                                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                                   placeholder="kelime1, kelime2, kelime3">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.categories.index') }}" 
                               style="padding: 10px 24px; background-color: #f3f4f6; color: #374151; border-radius: 6px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                               onmouseover="this.style.backgroundColor='#e5e7eb'"
                               onmouseout="this.style.backgroundColor='#f3f4f6'">
                                İptal
                            </a>
                            <button type="submit" 
                                    style="padding: 10px 24px; background-color: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                    onmouseover="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(-1px)'"
                                    onmouseout="this.style.backgroundColor='#3b82f6'; this.style.transform='translateY(0)'">
                                Kategori Oluştur
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showTab(lang) {
            // Tüm tab içeriklerini gizle
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Tüm tab butonlarının stillerini sıfırla
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Seçili tab'ı göster
            document.getElementById('content-' + lang).classList.remove('hidden');
            document.getElementById('tab-' + lang).classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('tab-' + lang).classList.add('border-indigo-500', 'text-indigo-600');
        }
    </script>
</x-app-layout>