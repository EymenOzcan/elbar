<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Kodunuz - el-bar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            margin: 0; 
            padding: 0; 
            overflow-x: hidden;
        }
        .qr-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .qr-image {
            max-width: 90vw;
            max-height: 70vh;
            width: auto;
            height: auto;
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @media (max-width: 640px) {
            .qr-image {
                max-width: 85vw;
                max-height: 60vh;
            }
        }
    </style>
</head>
<body>
    
    <div class="qr-container">
        <div class="w-full max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
            
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/el-bar-logo.png') }}" alt="el-bar" class="h-12 sm:h-16 mx-auto mb-4 drop-shadow-lg">
                <h1 class="text-2xl sm:text-4xl font-bold text-white mb-2 drop-shadow-md">QR Kodunuz Hazır!</h1>
                
                @if($qrCode->isValid())
                <div class="inline-flex items-center bg-white bg-opacity-20 backdrop-blur-md rounded-full px-4 py-2 text-white">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span id="countdown" data-expires="{{ $qrCode->expires_at->timestamp }}" class="font-semibold">--:--</span>
                    <span class="ml-1">kaldı</span>
                </div>
                @else
                <div class="inline-flex items-center bg-red-500 bg-opacity-90 backdrop-blur-md rounded-full px-4 py-2 text-white">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Süresi Dolmuş
                </div>
                @endif
            </div>

            <!-- QR Code - Tam Ekran -->
            <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-12 mb-6">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('storage/' . $qrCode->qr_image_path) }}" 
                         alt="QR Code" 
                         class="qr-image rounded-2xl shadow-xl">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <a href="{{ asset('storage/' . $qrCode->qr_image_path) }}" 
                   download="qr_{{ $qrCode->code }}.png"
                   style="display: flex; align-items: center; justify-content: center; padding: 16px; background-color: #10b981; color: white; border-radius: 16px; font-weight: 600; text-decoration: none; box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: all 0.3s;"
                   onmouseover="this.style.backgroundColor='#059669'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.backgroundColor='#10b981'; this.style.transform='translateY(0)'">
                    <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    İndir
                </a>
                
                <button onclick="copyUrl()" 
                        style="display: flex; align-items: center; justify-content: center; padding: 16px; background-color: #6366f1; color: white; border: none; border-radius: 16px; font-weight: 600; cursor: pointer; box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: all 0.3s;"
                        onmouseover="this.style.backgroundColor='#4f46e5'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.backgroundColor='#6366f1'; this.style.transform='translateY(0)'">
                    <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Kopyala
                </button>

                <a href="{{ route('qr.generate') }}" 
                   style="display: flex; align-items: center; justify-content: center; padding: 16px; background-color: #f59e0b; color: white; border-radius: 16px; font-weight: 600; text-decoration: none; box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: all 0.3s;"
                   onmouseover="this.style.backgroundColor='#d97706'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.backgroundColor='#f59e0b'; this.style.transform='translateY(0)'">
                    <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Yeni QR
                </a>
            </div>

            <!-- Info -->
            <div class="text-center">
                <p class="text-white text-sm opacity-75">&copy; {{ date('Y') }} el-bar</p>
            </div>

        </div>
    </div>

    <!-- Countdown Script -->
    @if($qrCode->isValid())
    <script>
        const countdownElement = document.getElementById('countdown');
        const expiresAt = parseInt(countdownElement.dataset.expires);
        
        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const diff = expiresAt - now;
            
            if (diff <= 0) {
                countdownElement.textContent = 'Süresi Doldu';
                clearInterval(timer);
                setTimeout(() => location.reload(), 2000);
                return;
            }
            
            const minutes = Math.floor(diff / 60);
            const seconds = diff % 60;
            countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
        
        updateCountdown();
        const timer = setInterval(updateCountdown, 1000);
    </script>
    @endif

    <!-- Copy URL Script -->
    <script>
        function copyUrl() {
            const url = "{{ route('qr.redirect', ['code' => $qrCode->code]) }}";
            navigator.clipboard.writeText(url).then(() => {
                alert('✓ QR URL kopyalandı!');
            }).catch(err => {
                console.error('Hata:', err);
            });
        }
    </script>

</body>
</html>