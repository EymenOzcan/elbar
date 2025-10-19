<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Yeni Sabit Sayfa Ekle
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.static-pages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Sayfa Türü -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Sayfa Türü *</label>
                                <select name="page_type" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('page_type') border-red-500 @enderror">
                                    <option value="">Seçiniz</option>
                                    @foreach($pageTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('page_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('page_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Başlık -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Başlık *</label>
                                <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Resim Alanları (Sadece İletişim ve Hakkımızda için) -->
                        <div id="image-fields" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Sayfa Görseli</label>
                                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-1">Max 2MB (JPG, PNG, GIF)</p>
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Banner Görseli</label>
                                    <input type="file" name="banner_image" accept="image/*" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-1">Max 2MB (JPG, PNG, GIF)</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-700">

                        <!-- Dil Sekmeleri -->
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">İçerik (Çok Dilli)</h3>

                        <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                            <nav class="-mb-px flex space-x-8">
                                @foreach($languages as $index => $language)
                                <button type="button"
                                        onclick="switchLanguageTab('lang-{{ $language->id }}')"
                                        id="tab-lang-{{ $language->id }}"
                                        class="language-tab {{ $index === 0 ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                                    <span class="text-2xl mr-2">{{ $language->flag }}</span>
                                    {{ $language->name }}
                                </button>
                                @endforeach
                            </nav>
                        </div>

                        <div class="mb-6">
                            @foreach($languages as $index => $language)
                            <div id="content-lang-{{ $language->id }}"
                                 class="language-content {{ $index !== 0 ? 'hidden' : '' }} space-y-4">

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                        Başlık ({{ $language->name }}) *
                                    </label>
                                    <input type="text"
                                           name="translations[{{ $language->id }}][title]"
                                           value="{{ old('translations.'.$language->id.'.title') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                        İçerik ({{ $language->name }})
                                    </label>
                                    <textarea name="translations[{{ $language->id }}][content]"
                                              id="content_{{ $language->id }}"
                                              class="ckeditor w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('translations.'.$language->id.'.content') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                        Meta Açıklama ({{ $language->name }})
                                    </label>
                                    <textarea name="translations[{{ $language->id }}][meta_description]"
                                              rows="2"
                                              placeholder="SEO için kısa açıklama (160 karakter)"
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('translations.'.$language->id.'.meta_description') }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-700">

                        <!-- İletişim Bilgileri (Sadece İletişim sayfası için) -->
                        <div id="contact-fields" style="display: none;">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">İletişim Bilgileri</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Telefon</label>
                                    <input type="text" name="contact[phone]" value="{{ old('contact.phone') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                                    <input type="email" name="contact[email]" value="{{ old('contact.email') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">WhatsApp</label>
                                    <input type="text" name="contact[whatsapp]" value="{{ old('contact.whatsapp') }}" placeholder="+90 5xx xxx xx xx" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Şehir</label>
                                    <input type="text" name="contact[city]" value="{{ old('contact.city') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Ülke</label>
                                    <input type="text" name="contact[country]" value="{{ old('contact.country') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Posta Kodu</label>
                                    <input type="text" name="contact[postal_code]" value="{{ old('contact.postal_code') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Adres</label>
                                <textarea name="contact[address]" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('contact.address') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Enlem (Latitude)</label>
                                    <input type="text" name="contact[latitude]" value="{{ old('contact.latitude') }}" placeholder="41.0082" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Boylam (Longitude)</label>
                                    <input type="text" name="contact[longitude]" value="{{ old('contact.longitude') }}" placeholder="28.9784" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>
                            </div>

                            <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100 mb-3">Sosyal Medya</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Facebook URL</label>
                                    <input type="url" name="contact[facebook_url]" value="{{ old('contact.facebook_url') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Instagram URL</label>
                                    <input type="url" name="contact[instagram_url]" value="{{ old('contact.instagram_url') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Twitter URL</label>
                                    <input type="url" name="contact[twitter_url]" value="{{ old('contact.twitter_url') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">LinkedIn URL</label>
                                    <input type="url" name="contact[linkedin_url]" value="{{ old('contact.linkedin_url') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">YouTube URL</label>
                                    <input type="url" name="contact[youtube_url]" value="{{ old('contact.youtube_url') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>
                            </div>

                            <hr class="my-6 border-gray-300 dark:border-gray-700">
                        </div>

                        <!-- Aktif -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Aktif</span>
                            </label>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; border: none; cursor: pointer;">Kaydet</button>
                            <a href="{{ route('admin.static-pages.index') }}" style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-block;">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        // Show/hide fields based on page type
        document.querySelector('select[name="page_type"]').addEventListener('change', function() {
            const contactFields = document.getElementById('contact-fields');
            const imageFields = document.getElementById('image-fields');

            if (this.value === 'contact') {
                contactFields.style.display = 'block';
                imageFields.style.display = 'block';
            } else if (this.value === 'about') {
                contactFields.style.display = 'none';
                imageFields.style.display = 'block';
            } else {
                contactFields.style.display = 'none';
                imageFields.style.display = 'none';
            }
        });

        // Check on page load
        const pageType = document.querySelector('select[name="page_type"]').value;
        if (pageType === 'contact') {
            document.getElementById('contact-fields').style.display = 'block';
            document.getElementById('image-fields').style.display = 'block';
        } else if (pageType === 'about') {
            document.getElementById('image-fields').style.display = 'block';
        }

        // CKEditor form submit handler
        document.querySelector('form').addEventListener('submit', function(e) {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });
    </script>

    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replaceAll('ckeditor');
    </script>
</x-app-layout>
