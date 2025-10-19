<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>QR Scanner - el-bar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 min-h-screen">
    
    <!-- Header -->
    <div class="bg-black bg-opacity-30 backdrop-blur-md border-b border-white border-opacity-10 sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/el-bar-logo.png') }}" alt="el-bar" class="h-8">
                <span class="text-white font-bold text-lg">QR Scanner</span>
            </div>
            <form action="{{ route('scanner.logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        style="padding: 8px 16px; background-color: rgba(239, 68, 68, 0.8); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='rgba(220, 38, 38, 0.9)'"
                        onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.8)'">
                    Çıkış
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-lg mx-auto p-4 pb-20">
        
        <!-- Welcome Card -->
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white border-opacity-20">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-white text-xl font-bold">Hoş Geldiniz!</h2>
                    <p class="text-white text-opacity-75">{{ $user->full_name }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <!-- Bugünkü Taramalar -->
            <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl p-6 shadow-xl">
                <div class="text-center">
                    <svg class="w-8 h-8 mx-auto mb-2 text-white text-opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-white text-opacity-75 text-xs mb-1">Bugün</p>
                    <p class="text-white text-3xl font-bold">{{ $todayScans ?? 0 }}</p>
                </div>
            </div>

            <!-- Toplam Tarama -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 shadow-xl">
                <div class="text-center">
                    <svg class="w-8 h-8 mx-auto mb-2 text-white text-opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-white text-opacity-75 text-xs mb-1">Toplam</p>
                    <p class="text-white text-3xl font-bold">{{ $user->scan_count }}</p>
                </div>
            </div>
        </div>

        <!-- QR Scanner Button -->
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-8 mb-6 border border-white border-opacity-20">
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-purple-400 to-indigo-600 flex items-center justify-center shadow-2xl">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <h3 class="text-white text-2xl font-bold mb-3">QR Kod Tarama</h3>
                <p class="text-white text-opacity-75 mb-6">QR kod taramak için aşağıdaki butona tıklayın</p>
                <a href="{{ route('scanner.scan') }}"
                   style="display: inline-block; width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 16px; font-size: 18px; font-weight: 700; box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4); transition: all 0.3s;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 30px rgba(102, 126, 234, 0.5)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(102, 126, 234, 0.4)'">
                    <svg style="width: 24px; height: 24px; display: inline; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Taramayı Başlat
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 gap-4">
            <!-- Tarama Geçmişi -->
            <a href="{{ route('scanner.history') }}"
               class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-4 border border-white border-opacity-20 flex items-center justify-between"
               style="text-decoration: none;">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">Tarama Geçmişi</h4>
                        <p class="text-white text-opacity-60 text-sm">Tüm taramalarınızı görün</p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-white text-opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

    </div>

    <!-- Footer -->
    <div class="fixed bottom-0 left-0 right-0 bg-black bg-opacity-30 backdrop-blur-md border-t border-white border-opacity-10">
        <div class="max-w-lg mx-auto px-4 py-3">
            <p class="text-white text-opacity-50 text-xs text-center">
                © {{ date('Y') }} el-bar QR Scanner - Tüm hakları saklıdır
            </p>
        </div>
    </div>

</body>
</html>