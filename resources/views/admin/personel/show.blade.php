<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $personel->full_name }} - İstatistikler
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.personel.edit', $personel) }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    Düzenle
                </a>
                <a href="{{ route('admin.personel.index') }}" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    Geri
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Personel Bilgileri -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Personel Bilgileri</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Ad Soyad</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $personel->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Çalışan Tipi</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($personel->employment_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pozisyon</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $personel->position ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $personel->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Telefon</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $personel->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">QR Kod</p>
                            <p class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ $personel->qr_code }}</p>
                            <a href="{{ route('personel.social-media', $personel->qr_code) }}" target="_blank" class="text-xs text-blue-600 hover:underline">
                                Sosyal Medya Sayfasını Görüntüle →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Kod -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">QR Kod</h3>
                    <div class="flex items-center gap-6">
                        <div id="qr-code" class="bg-white p-4 rounded-lg"></div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                Bu QR kodu taratarak personelin sosyal medya sayfasına erişilebilir.
                            </p>
                            <button onclick="downloadQR()" style="background-color: #16a34a; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; border: none;">
                                QR Kodu İndir
                            </button>
                            <button onclick="shareQR()" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; border: none; margin-left: 0.5rem;">
                                Paylaş
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Toplam Takip</h3>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $personel->socialMediaFollows->count() }}</p>
                </div>
                @foreach(['instagram', 'facebook', 'tiktok', 'x', 'linkedin', 'youtube', 'whatsapp'] as $platform)
                    @if($personel->{$platform.'_username'} || $platform === 'whatsapp' && $personel->whatsapp_number)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ ucfirst($platform) }}</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $platformStats[$platform] ?? 0 }}</p>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Son 30 Gün Grafik -->
            @if($dailyStats->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Son 30 Günlük Takip Trendi</h3>
                        <canvas id="followChart" height="80"></canvas>
                    </div>
                </div>
            @endif

            <!-- Son Takipler -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Son Takipler</h3>
                    @if($personel->socialMediaFollows->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Platform</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">IP Adresi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tarih</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($personel->socialMediaFollows->take(20) as $follow)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ ucfirst($follow->platform) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $follow->ip_address }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $follow->created_at->format('d.m.Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Henüz takip kaydı yok.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // QR Code oluştur
        const qrcode = new QRCode(document.getElementById('qr-code'), {
            text: '{{ route("personel.social-media", $personel->qr_code) }}',
            width: 200,
            height: 200,
        });

        function downloadQR() {
            const canvas = document.querySelector('#qr-code canvas');
            const url = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = 'qr-{{ $personel->qr_code }}.png';
            link.href = url;
            link.click();
        }

        function shareQR() {
            const url = '{{ route("personel.social-media", $personel->qr_code) }}';
            if (navigator.share) {
                navigator.share({
                    title: '{{ $personel->full_name }} - Sosyal Medya',
                    url: url
                });
            } else {
                navigator.clipboard.writeText(url);
                alert('Link kopyalandı!');
            }
        }

        // Grafik
        @if($dailyStats->count() > 0)
            const ctx = document.getElementById('followChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dailyStats->pluck('date')) !!},
                    datasets: [{
                        label: 'Takip Sayısı',
                        data: {!! json_encode($dailyStats->pluck('count')) !!},
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        @endif
    </script>
</x-app-layout>
