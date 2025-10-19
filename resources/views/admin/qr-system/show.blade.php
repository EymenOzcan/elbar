<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('QR Kod Detayları') }}
            </h2>
            <a href="{{ route('admin.qr-system.index') }}"  style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #6366f1; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
           onmouseover="this.style.backgroundColor='#4f46e5'"
           onmouseout="this.style.backgroundColor='#6366f1'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                QR Listesine Dön
            </a>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg p-4">
                {{ session('success') }}
            </div>
            @endif

            <!-- QR Durum Kartı -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">QR Kod: {{ $qrCode->code }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Oluşturulma: {{ $qrCode->created_at->format('d.m.Y H:i:s') }}
                            </p>
                        </div>
                        <div class="text-right">
                            @if($qrCode->isValid())
                                <span class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Aktif
                                </span>
                            @elseif($qrCode->isExpired())
                                <span class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Süresi Dolmuş
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Pasif</span>
                            @endif
                        </div>
                    </div>

                    <!-- Countdown Timer (Aktifse) -->
                    @if($qrCode->isValid())
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Kalan Süre</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400">{{ $qrCode->expires_at->format('d.m.Y H:i:s') }} tarihine kadar geçerli</p>
                            </div>
                            <div id="countdown" class="text-3xl font-bold text-blue-600 dark:text-blue-400" data-expires="{{ $qrCode->expires_at->timestamp }}">
                                --:--
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Sol: QR Görsel -->
                        <div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-8 text-center">
                                <img src="{{ asset('storage/' . $qrCode->qr_image_path) }}" 
                                     alt="QR Code" 
                                     class="mx-auto max-w-full h-auto rounded-lg shadow-lg">
                                
                                <div class="mt-6 space-y-3">
                                    <a href="{{ asset('storage/' . $qrCode->qr_image_path) }}" 
                                       download="qr_{{ $qrCode->code }}.png"
                                       style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #6366f1; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
           onmouseover="this.style.backgroundColor='#4f46e5'"
           onmouseout="this.style.backgroundColor='#6366f1'">
            <svg style="width: 16px; height: 16px; margin-right: 8px;">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        QR Kodunu İndir
                                    </a>
                                    
                                    <button onclick="copyToClipboard('{{ route('qr.redirect', ['code' => $qrCode->code]) }}')"
                                           style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #56f80bff; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
           onmouseover="this.style.backgroundColor='rgba(155, 248, 118, 1)'"
           onmouseout="this.style.backgroundColor='#62d108ff'">
            <svg style="width: 16px; height: 16px; margin-right: 8px;">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        QR URL'i Kopyala
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sağ: Bilgiler -->
                        <div class="space-y-4">
                            
                            <!-- Hedef URL -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-2">Hedef URL</label>
                                <a href="{{ $qrCode->target_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline break-all">
                                    {{ $qrCode->target_url }}
                                </a>
                            </div>

                            <!-- QR URL -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-2">QR Yönlendirme URL'i</label>
                                <code class="text-sm bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded break-all">
                                    {{ route('qr.redirect', ['code' => $qrCode->code]) }}
                                </code>
                            </div>

                            <!-- İstatistikler -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Taranma Sayısı</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $qrCode->scan_count }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Kullanım Durumu</p>
                                    <p class="text-2xl font-bold {{ $qrCode->is_used ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $qrCode->is_used ? 'Kullanıldı' : 'Beklemede' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Son Kullanım Bilgileri -->
                            @if($qrCode->is_used && $qrCode->used_at)
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-2">Son Kullanım</label>
                                <div class="text-sm space-y-1">
                                    <p><strong>Tarih:</strong> {{ $qrCode->used_at->format('d.m.Y H:i:s') }}</p>
                                    @if($qrCode->ip_address)
                                    <p><strong>IP:</strong> {{ $qrCode->ip_address }}</p>
                                    @endif
                                    @if($qrCode->user_agent)
                                    <p><strong>Tarayıcı:</strong> <span class="text-xs">{{ Str::limit($qrCode->user_agent, 50) }}</span></p>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Silme Butonu -->
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4">
                                <form action="{{ route('admin.qr-system.destroy', $qrCode) }}" method="POST" onsubmit="return confirm('Bu QR kodu silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        QR Kodu Sil
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Countdown Timer Script -->
    @if($qrCode->isValid())
    <script>
        const countdownElement = document.getElementById('countdown');
        const expiresAt = parseInt(countdownElement.dataset.expires);
        
        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const diff = expiresAt - now;
            
            if (diff <= 0) {
                countdownElement.textContent = 'Süresi Doldu';
                countdownElement.classList.add('text-red-600');
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

    <!-- Copy to Clipboard Script -->
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('URL kopyalandı!');
            }).catch(err => {
                console.error('Kopyalama hatası:', err);
            });
        }
    </script>
</x-app-layout>