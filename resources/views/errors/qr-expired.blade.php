<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Kod Geçersiz - el-bar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-8 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">QR Kod Geçersiz</h1>
                <p class="text-red-100">Bu QR kod artık kullanılamıyor</p>
            </div>

            <!-- Body -->
            <div class="p-8">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-red-800 mb-1">{{ $message ?? 'QR kod bulunamadı veya süresi dolmuş' }}</h3>
                            <p class="text-xs text-red-700">
                                Lütfen yeni bir QR kod talep edin veya yetkili kişi ile iletişime geçin.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bilgi Kartları -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">QR kodlarımız 2 dakika geçerlidir</p>
                            <p class="text-xs text-gray-500">Güvenlik nedeniyle kısa süreli kullanım</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Her QR kod tek kullanımlıktır</p>
                            <p class="text-xs text-gray-500">Maksimum güvenlik için</p>
                        </div>
                    </div>
                </div>

                <!-- Ana Sayfa Butonu -->
                <a href="/" class="block w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-center py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Ana Sayfaya Dön
                </a>

                <!-- İletişim -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        Yardım için: 
                        <a href="mailto:info@el-bar.com" class="text-indigo-600 hover:text-indigo-700 font-medium">info@el-bar.com</a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
                <div class="flex items-center justify-center text-xs text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Sayfa {{ now()->format('d.m.Y H:i:s') }} tarihinde yüklendi
                </div>
            </div>
        </div>

        <!-- Logo -->
        <div class="text-center mt-8">
            <img src="{{ asset('images/el-bar-logo.png') }}" alt="el-bar" class="h-12 mx-auto opacity-50">
        </div>
    </div>
</body>
</html>