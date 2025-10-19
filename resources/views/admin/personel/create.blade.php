<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Yeni Personel Ekle
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.personel.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Ad -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Ad *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Soyad -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Soyad *</label>
                                <input type="text" name="surname" value="{{ old('surname') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('surname') border-red-500 @enderror">
                                @error('surname')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telefon -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Telefon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Çalışan Tipi -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Çalışan Tipi *</label>
                                <select name="employment_type" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                    <option value="">Seçiniz</option>
                                    <option value="primli" {{ old('employment_type') === 'primli' ? 'selected' : '' }}>Primli</option>
                                    <option value="kadrolu" {{ old('employment_type') === 'kadrolu' ? 'selected' : '' }}>Kadrolu</option>
                                </select>
                            </div>

                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-700">

                        <!-- Dil Sekmeleri - Pozisyon ve Açıklama -->
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pozisyon ve Açıklama (Çok Dilli)</h3>

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
                                        Pozisyon ({{ $language->name }})
                                    </label>
                                    <input type="text"
                                           name="translations[{{ $language->id }}][position]"
                                           value="{{ old('translations.'.$language->id.'.position') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                        Açıklama ({{ $language->name }})
                                    </label>
                                    <textarea name="translations[{{ $language->id }}][description]"
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('translations.'.$language->id.'.description') }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-700">

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Sosyal Medya Hesapları</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Instagram -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Instagram Kullanıcı Adı</label>
                                <input type="text" name="instagram_username" value="{{ old('instagram_username') }}" placeholder="@kullaniciadi" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>

                            <!-- Facebook -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Facebook Kullanıcı Adı</label>
                                <input type="text" name="facebook_username" value="{{ old('facebook_username') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>

                            <!-- TikTok -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">TikTok Kullanıcı Adı</label>
                                <input type="text" name="tiktok_username" value="{{ old('tiktok_username') }}" placeholder="@kullaniciadi" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>

                            <!-- X (Twitter) -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">X (Twitter) Kullanıcı Adı</label>
                                <input type="text" name="x_username" value="{{ old('x_username') }}" placeholder="@kullaniciadi" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>

                            <!-- LinkedIn -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">LinkedIn Kullanıcı Adı</label>
                                <input type="text" name="linkedin_username" value="{{ old('linkedin_username') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>

                            <!-- YouTube -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">YouTube Kanal Adı</label>
                                <input type="text" name="youtube_username" value="{{ old('youtube_username') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>

                            <!-- WhatsApp -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">WhatsApp Numarası</label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="+90 5xx xxx xx xx" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                            </div>
                        </div>

                        <hr class="my-6 border-gray-300 dark:border-gray-700">

                        <!-- Aktif -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Aktif</span>
                            </label>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600;">Kaydet</button>
                            <a href="{{ route('admin.personel.index') }}" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none;">İptal</a>
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
    </script>
</x-app-layout>
