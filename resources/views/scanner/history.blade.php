<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Tarama Geçmişi - el-bar</title>
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
            <a href="{{ route('scanner.dashboard') }}" 
               style="padding: 8px 12px; background-color: rgba(255, 255, 255, 0.1); color: white; border-radius: 8px; text-decoration: none;"
               onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 0.2)'"
               onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.1)'">
                <svg style="width: 20px; height: 20px; display: inline;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-white font-bold text-lg">Tarama Geçmişi</h1>
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
        
        <!-- Stats Summary -->
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white border-opacity-20">
            <div class="text-center">
                <div class="text-white text-opacity-75 text-sm mb-2">Toplam Tarama</div>
                <div class="text-white text-5xl font-bold">{{ $user->scan_count }}</div>
            </div>
        </div>

        <!-- History List -->
        @if($scans->count() > 0)
        <div class="space-y-4">
            @foreach($scans as $scan)
            <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-4 border border-white border-opacity-20">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="text-white font-bold text-lg mb-1">
                            {{ $scan->qrCode ? $scan->qrCode->code : 'QR Kod Bulunamadı' }}
                        </h3>
                        <p class="text-white text-opacity-60 text-sm">
                            {{ $scan->created_at->format('d.m.Y H:i:s') }}
                        </p>
                        <p class="text-white text-opacity-50 text-xs">
                            {{ $scan->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $scan->status === 'valid' ? 'bg-green-500' : ($scan->status === 'expired' ? 'bg-orange-500' : 'bg-red-500') }} text-white">
                        {{ $scan->status === 'valid' ? 'GEÇERLİ' : ($scan->status === 'expired' ? 'SÜRESİ DOLMUŞ' : 'GEÇERSİZ') }}
                    </span>
                </div>
                
                @if($scan->qrCode)
                <div class="border-t border-white border-opacity-20 pt-3 mt-3 space-y-2">
                    <div class="flex items-center text-white text-opacity-75 text-sm">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <span class="break-all">{{ Str::limit($scan->qrCode->target_url, 40) }}</span>
                    </div>
                    <div class="flex items-center text-white text-opacity-75 text-sm">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>{{ $scan->qrCode->scan_count }} kez tarandı</span>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $scans->links() }}
        </div>
        @else
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-8 border border-white border-opacity-20 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-white text-opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-white text-opacity-75">Henüz tarama geçmişi yok</p>
        </div>
        @endif

    </div>

</body>
</html>