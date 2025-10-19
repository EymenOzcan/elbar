<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            EL-BAR Sosyal Medya Hesapları
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Sosyal Medya Ayarları</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Personellerin QR kodları ile yönlendirilen kullanıcılar bu hesapları takip edecek.
                            Lütfen hesap linklerinizi tam URL olarak girin.
                        </p>
                    </div>

                    <form action="{{ route('admin.company-social-media.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <!-- Instagram -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    Instagram URL
                                </label>
                                <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                                       placeholder="https://instagram.com/elbar"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('instagram_url') border-red-500 @enderror">
                                @error('instagram_url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Facebook -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    Facebook URL
                                </label>
                                <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                                       placeholder="https://facebook.com/elbar"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('facebook_url') border-red-500 @enderror">
                                @error('facebook_url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TikTok -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    TikTok URL
                                </label>
                                <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}"
                                       placeholder="https://tiktok.com/@elbar"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('tiktok_url') border-red-500 @enderror">
                                @error('tiktok_url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- X (Twitter) -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    X (Twitter) URL
                                </label>
                                <input type="url" name="x_url" value="{{ old('x_url', $settings['x_url'] ?? '') }}"
                                       placeholder="https://x.com/elbar"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('x_url') border-red-500 @enderror">
                                @error('x_url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- LinkedIn -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    LinkedIn URL
                                </label>
                                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"
                                       placeholder="https://linkedin.com/company/elbar"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('linkedin_url') border-red-500 @enderror">
                                @error('linkedin_url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- YouTube -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    YouTube URL
                                </label>
                                <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                                       placeholder="https://youtube.com/@elbar"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('youtube_url') border-red-500 @enderror">
                                @error('youtube_url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    WhatsApp URL
                                </label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}"
                                       placeholder="https://wa.me/905xxxxxxxxx"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('whatsapp_number') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Format: https://wa.me/905xxxxxxxxx</p>
                                @error('whatsapp_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex gap-2">
                            <button type="submit" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; border: none; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                                    onmouseout="this.style.backgroundColor='#2563eb'">
                                Kaydet
                            </button>
                            <a href="{{ route('dashboard') }}" style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-block;"
                               onmouseover="this.style.backgroundColor='#4b5563'"
                               onmouseout="this.style.backgroundColor='#6b7280'">
                                Geri Dön
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
