<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                ⚙️ Medya Ayarları
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.media-settings.update') }}" method="POST" class="space-y-6">
                @csrf

                @foreach($groups as $groupKey => $group)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                        <!-- Group Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <span class="text-2xl mr-3">{{ $group['icon'] }}</span>
                                {{ $group['title'] }}
                            </h3>
                        </div>

                        <!-- Group Settings -->
                        <div class="p-6">
                            @if($groupKey === 'storage')
                                <!-- Storage Type Selection -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                        Depolama Tipi
                                    </label>
                                   <div class="flex flex-wrap gap-4">
                                        @php
                                            $storageTypes = [
                                                'local' => ['name' => 'Yerel Sunucu', 'icon' => '💻', 'color' => 'blue'],
                                                's3' => ['name' => 'Amazon S3', 'icon' => '☁️', 'color' => 'orange'],
                                                'cloudinary' => ['name' => 'Cloudinary', 'icon' => '📦', 'color' => 'green'],
                                                'custom' => ['name' => 'Özel URL', 'icon' => '🔗', 'color' => 'purple'],
                                            ];
                                            $currentType = $settings->get('default_storage_type')->value ?? 'local';
                                        @endphp

                                        @foreach($storageTypes as $type => $info)
                                            <label class="relative cursor-pointer">
                                                <input type="radio" 
                                                       name="settings[default_storage_type]" 
                                                       value="{{ $type }}"
                                                       class="peer sr-only"
                                                       {{ $currentType === $type ? 'checked' : '' }}
                                                       onchange="toggleStorageSettings('{{ $type }}')">
                                                <div class="p-4 border-2 rounded-xl text-center transition-all peer-checked:border-{{ $info['color'] }}-500 peer-checked:bg-{{ $info['color'] }}-50 dark:peer-checked:bg-{{ $info['color'] }}-900/20 hover:border-gray-400">
                                                    <div class="text-3xl mb-2">{{ $info['icon'] }}</div>
                                                    <div class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $info['name'] }}</div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Local Storage Settings -->
                                <div id="local-settings" class="storage-settings mb-6" style="display: {{ $currentType === 'local' ? 'block' : 'none' }}">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Yerel Sunucu Ayarları</h4>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            Dosyalar sunucunuzun <code class="bg-white dark:bg-gray-800 px-2 py-1 rounded">storage/app/public</code> klasörüne kaydedilecek.
                                        </p>
                                    </div>
                                </div>

                                <!-- S3 Settings -->
                                <div id="s3-settings" class="storage-settings space-y-4" style="display: {{ $currentType === 's3' ? 'block' : 'none' }}">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Amazon S3 Ayarları</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Access Key</label>
                                            <input type="text" name="settings[s3_key]" value="{{ $settings->get('s3_key')->value ?? '' }}"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Secret Key</label>
                                            <input type="password" name="settings[s3_secret]" value="{{ $settings->get('s3_secret')->value ?? '' }}"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Region</label>
                                            <input type="text" name="settings[s3_region]" value="{{ $settings->get('s3_region')->value ?? 'eu-central-1' }}"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bucket Name</label>
                                            <input type="text" name="settings[s3_bucket]" value="{{ $settings->get('s3_bucket')->value ?? '' }}"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        </div>
                                    </div>
                                    
                                    <button type="button" onclick="testConnection('s3')" 
                                            class="mt-4 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold">
                                        Bağlantıyı Test Et
                                    </button>
                                </div>

                                <!-- Cloudinary Settings -->
                                <div id="cloudinary-settings" class="storage-settings space-y-4" style="display: {{ $currentType === 'cloudinary' ? 'block' : 'none' }}">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Cloudinary Ayarları</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cloud Name</label>
                                            <input type="text" name="settings[cloudinary_cloud_name]" value="{{ $settings->get('cloudinary_cloud_name')->value ?? '' }}"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">API Key</label>
                                            <input type="text" name="settings[cloudinary_api_key]" value="{{ $settings->get('cloudinary_api_key')->value ?? '' }}"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">API Secret</label>
                                            <input type="password" name="settings[cloudinary_api_secret]" value="{{ $settings->get('cloudinary_api_secret')->value ?? '' }}"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        </div>
                                    </div>
                                    
                                    <button type="button" onclick="testConnection('cloudinary')" 
                                            class="mt-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold">
                                        Bağlantıyı Test Et
                                    </button>
                                </div>

                                <!-- Custom URL Settings -->
                                <div id="custom-settings" class="storage-settings space-y-4" style="display: {{ $currentType === 'custom' ? 'block' : 'none' }}">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Özel URL Ayarları</h4>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Base URL</label>
                                        <input type="url" name="settings[custom_url_base]" value="{{ $settings->get('custom_url_base')->value ?? '' }}"
                                               placeholder="https://cdn.example.com"
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                        <p class="mt-1 text-xs text-gray-500">Örnek: https://cdn.example.com</p>
                                    </div>
                                </div>

                            @else
                                <!-- Diğer grup ayarları -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($group['settings'] as $setting)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                            </label>
                                            
                                            @if($setting->type === 'boolean')
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" class="sr-only peer"
                                                           {{ $setting->value === 'true' || $setting->value === '1' ? 'checked' : '' }}>
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                </label>
                                            @elseif($setting->type === 'integer')
                                                <input type="number" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"
                                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                            @else
                                                <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"
                                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                            @endif
                                            
                                            @if($setting->description)
                                                <p class="mt-1 text-xs text-gray-500">{{ $setting->description }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Kaydet Butonu -->
                <div class="flex justify-end">
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 12px 32px; border-radius: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'">
                        💾 Ayarları Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleStorageSettings(type) {
            // Tüm storage settings divlerini gizle
            document.querySelectorAll('.storage-settings').forEach(el => {
                el.style.display = 'none';
            });
            
            // Seçili tipi göster
            const settingsDiv = document.getElementById(type + '-settings');
            if (settingsDiv) {
                settingsDiv.style.display = 'block';
            }
        }

        function testConnection(type) {
            fetch('{{ route("admin.media-settings.test-connection") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                alert('Hata: ' + error);
            });
        }
    </script>
</x-app-layout>