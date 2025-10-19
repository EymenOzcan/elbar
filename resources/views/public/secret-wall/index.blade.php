<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gizli Duvar - EL-BAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen" style="background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 50%, #ea580c 100%);">

    <div class="container mx-auto px-4 py-12">

        <!-- Header -->
        <div class="text-center mb-12">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/el-bar-logo.png') }}" alt="EL-BAR" class="h-24 drop-shadow-2xl">
            </div>
            <h1 class="text-5xl font-bold text-white mb-4 drop-shadow-lg">🎭 Gizli Duvar</h1>
            <p class="text-xl text-white/90 drop-shadow">Sosyal medya bilgilerinizi paylaşın ve duvarda yer alın!</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="max-w-2xl mx-auto mb-8 bg-white border-l-4 p-6 rounded-lg shadow-2xl" style="border-color: #ea580c;">
            <div class="flex items-center">
                <svg class="h-8 w-8 mr-4" style="color: #ea580c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-medium" style="color: #1e3a8a;">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="max-w-2xl mx-auto mb-8 bg-white border-l-4 p-6 rounded-lg shadow-2xl" style="border-color: #ef4444;">
            <div class="flex items-start">
                <svg class="h-8 w-8 mr-4 flex-shrink-0" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <p class="text-lg font-medium text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-8">

            <form action="{{ route('secret-wall.public.store') }}" method="POST" enctype="multipart/form-data" id="secretWallForm">
                @csrf

                <!-- Honeypot - Botlar için gizli alan -->
                <input type="text" name="website" style="display:none !important; position:absolute; left:-9999px;" tabindex="-1" autocomplete="off">

                <!-- Zaman bazlı koruma - Form yüklenme zamanı -->
                <input type="hidden" name="form_load_time" value="{{ time() }}">

                <!-- İsim Soyisim -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        İsim Soyisim <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="isimsoyisim" value="{{ old('isimsoyisim') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent"
                           style="outline: none;"
                           onfocus="this.style.borderColor='#7c3aed'; this.style.boxShadow='0 0 0 3px rgba(124, 58, 237, 0.1)'"
                           onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'"
                           placeholder="Adınız ve soyadınız">
                    @error('isimsoyisim')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resim Upload -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Profil Resmi (İsteğe Bağlı)
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Tıklayın</span> veya sürükleyin</p>
                                <p class="text-xs text-gray-500">PNG, JPG (Max. 5MB)</p>
                            </div>
                            <input type="file" name="resim" accept="image/*" class="hidden" onchange="showFileName(this)">
                        </label>
                    </div>
                    <p id="file-name" class="text-sm text-gray-600 mt-2"></p>
                    @error('resim')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sosyal Medya Linkleri -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">📱 Sosyal Medya Hesapları</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Instagram -->
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                Instagram
                            </label>
                            <input type="text" name="instagram_link" value="{{ old('instagram_link') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="https://instagram.com/kullaniciadi">
                        </div>

                        <!-- Facebook -->
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </label>
                            <input type="url" name="facebook_link" value="{{ old('facebook_link') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="https://facebook.com/...">
                        </div>

                        <!-- LinkedIn -->
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn
                            </label>
                            <input type="url" name="linkedin_link" value="{{ old('linkedin_link') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="https://linkedin.com/in/...">
                        </div>

                        <!-- TikTok -->
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                                TikTok
                            </label>
                            <input type="url" name="tiktok_link" value="{{ old('tiktok_link') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="https://tiktok.com/@...">
                        </div>

                        <!-- WhatsApp -->
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                WhatsApp
                            </label>
                            <input type="text" name="whatsapp_link" value="{{ old('whatsapp_link') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="https://wa.me/905xxxxxxxxx">
                        </div>

                        <!-- X (Twitter) -->
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                X (Twitter)
                            </label>
                            <input type="url" name="x_link" value="{{ old('x_link') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="https://x.com/...">
                        </div>

                        <!-- YouTube -->
                        <div>
                            <label class="block text-gray-600 text-sm font-semibold mb-2">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                YouTube
                            </label>
                            <input type="url" name="youtube_link" value="{{ old('youtube_link') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="https://youtube.com/@...">
                        </div>

                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit"
                            class="w-full text-white font-bold py-4 px-6 rounded-lg transform transition hover:scale-105 shadow-lg"
                            style="background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 50%, #ea580c 100%);"
                            onmouseover="this.style.opacity='0.9'"
                            onmouseout="this.style.opacity='1'">
                        🎭 Gizli Duvara Ekle
                    </button>
                </div>

                <p class="text-center text-sm text-gray-500 mt-4">
                    * Kaydınız admin onayından sonra gizli duvarda görüntülenecektir.
                </p>

            </form>

        </div>

    </div>

    <script>
        function showFileName(input) {
            const fileName = input.files[0]?.name;
            const fileNameEl = document.getElementById('file-name');
            if (fileName) {
                fileNameEl.textContent = '✓ ' + fileName;
                fileNameEl.classList.add('text-green-600', 'font-medium');
            }
        }
    </script>

</body>
</html>
