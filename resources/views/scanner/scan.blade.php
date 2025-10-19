<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>QR Kod Tarama - el-bar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <style>
        body {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }
        #reader {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        #reader video {
            border-radius: 1rem;
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
            <h1 class="text-white font-bold text-lg">QR Kod Tarama</h1>
            <div style="width: 44px;"></div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-lg mx-auto p-4 pb-20">

        <!-- Scanner Area -->
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white border-opacity-20">

            <!-- Start Button -->
            <div id="startButton" class="text-center mb-4">
                <button onclick="initCamera()"
                        class="w-full px-6 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl text-lg transition shadow-lg">
                    📷 Kamerayı Başlat
                </button>
                <p class="text-white text-opacity-60 text-sm mt-2">Kamera izni gereklidir</p>
            </div>

            <div id="reader" class="mb-4 hidden"></div>

            <!-- Scan Status -->
            <div id="scanStatus" class="text-center hidden">
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold">
                    <svg class="animate-spin h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-white">Taranıyor...</span>
                </div>
            </div>

            <!-- Result -->
            <div id="result" class="hidden">
                <div id="resultCard" class="p-4 rounded-xl mb-4">
                    <h3 class="text-white font-bold text-lg mb-2">Tarama Sonucu</h3>
                    <p id="resultMessage" class="text-white text-opacity-90 mb-2"></p>
                    <p id="resultDetails" class="text-white text-opacity-60 text-sm"></p>
                </div>

                <!-- Action Buttons -->
                <div id="actionButtons" class="hidden space-y-2 mb-4">
                    <button id="allowBtn" onclick="allowEntry()"
                            class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition">
                        ✓ Giriş İzni Ver
                    </button>
                    <button id="denyBtn" onclick="denyEntry()"
                            class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition">
                        ✕ Giriş Reddet
                    </button>
                </div>

                <button onclick="resetScanner()"
                        style="width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer;">
                    Yeni Tarama Yap
                </button>
            </div>
        </div>

        <!-- Instructions -->
        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-6 border border-white border-opacity-20">
            <h3 class="text-white font-bold text-lg mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Kullanım Talimatları
            </h3>
            <ul class="text-white text-opacity-75 text-sm space-y-2">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    QR kodu kamera çerçevesinin içine yerleştirin
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Kameranın QR kodu net görmesini sağlayın
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Otomatik olarak taranacak ve doğrulanacaktır
                </li>
            </ul>
        </div>

    </div>

    <script>
        let html5Qrcode;
        let currentQrCodeId = null;
        let isScanning = false;

        function onScanSuccess(decodedText, decodedResult) {
            if (isScanning) return; // Çift tarama önleme
            isScanning = true;

            // Tarama başarılı
            document.getElementById('scanStatus').classList.add('hidden');

            // Scanner'ı durdur
            html5Qrcode.stop().then(() => {
                console.log('Scanner durduruldu');
            }).catch(err => {
                console.error('Scanner durdurma hatası:', err);
            });

            // Backend'de doğrula
            verifyQrCode(decodedText);
        }

        function onScanFailure(error) {
            // Hata mesajını gösterme (sürekli log olmasın)
            // console.warn(`QR tarama hatası: ${error}`);
        }

        function initCamera() {
            // Başlat butonunu gizle
            document.getElementById('startButton').classList.add('hidden');
            document.getElementById('reader').classList.remove('hidden');
            document.getElementById('scanStatus').classList.remove('hidden');

            // Html5Qrcode oluştur
            html5Qrcode = new Html5Qrcode("reader");

            // Kamera ile başlat
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length > 0) {
                    const cameraId = cameras[cameras.length - 1].id; // Arka kamera

                    html5Qrcode.start(
                        cameraId,
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 250 }
                        },
                        onScanSuccess,
                        onScanFailure
                    ).then(() => {
                        console.log('Kamera başlatıldı');
                    }).catch(err => {
                        console.error('Kamera başlatma hatası:', err);
                        alert('Kamera başlatılamadı: ' + err);
                        document.getElementById('startButton').classList.remove('hidden');
                        document.getElementById('reader').classList.add('hidden');
                        document.getElementById('scanStatus').classList.add('hidden');
                    });
                } else {
                    alert('Kamera bulunamadı!');
                    document.getElementById('startButton').classList.remove('hidden');
                    document.getElementById('reader').classList.add('hidden');
                    document.getElementById('scanStatus').classList.add('hidden');
                }
            }).catch(err => {
                console.error('Kamera listeleme hatası:', err);
                alert('Kamera erişimi reddedildi: ' + err);
                document.getElementById('startButton').classList.remove('hidden');
                document.getElementById('reader').classList.add('hidden');
                document.getElementById('scanStatus').classList.add('hidden');
            });
        }

        function resetScanner() {
            document.getElementById('result').classList.add('hidden');
            document.getElementById('actionButtons').classList.add('hidden');
            document.getElementById('scanStatus').classList.remove('hidden');
            currentQrCodeId = null;
            isScanning = false;

            // Kamerayı yeniden başlat
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length > 0) {
                    const cameraId = cameras[cameras.length - 1].id;

                    html5Qrcode.start(
                        cameraId,
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 250 }
                        },
                        onScanSuccess,
                        onScanFailure
                    ).then(() => {
                        console.log('Kamera yeniden başlatıldı');
                    }).catch(err => {
                        console.error('Kamera yeniden başlatma hatası:', err);
                    });
                }
            });
        }

        function verifyQrCode(qrCode) {
            fetch('{{ route("scanner.qr.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    qr_code: qrCode
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Doğrulama sonucu:', data);

                // Sonuç göster
                showResult(data);
            })
            .catch(error => {
                console.error('Doğrulama hatası:', error);
                showError('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
        }

        function showResult(data) {
            const resultCard = document.getElementById('resultCard');
            const resultMessage = document.getElementById('resultMessage');
            const resultDetails = document.getElementById('resultDetails');
            const actionButtons = document.getElementById('actionButtons');

            // Renk belirleme
            const colorClasses = {
                'green': 'bg-green-500 bg-opacity-20 border border-green-400',
                'red': 'bg-red-500 bg-opacity-20 border border-red-400',
                'orange': 'bg-orange-500 bg-opacity-20 border border-orange-400',
                'yellow': 'bg-yellow-500 bg-opacity-20 border border-yellow-400',
                'gray': 'bg-gray-500 bg-opacity-20 border border-gray-400'
            };

            resultCard.className = 'p-4 rounded-xl mb-4 ' + (colorClasses[data.color] || colorClasses['gray']);
            resultMessage.textContent = data.message;

            // Detaylar
            if (data.status === 'valid') {
                currentQrCodeId = data.qr_code_id;
                resultDetails.textContent = `Son kullanma: ${data.expires_at} | Tarama: ${data.scan_count}`;
                actionButtons.classList.remove('hidden');
            } else {
                currentQrCodeId = null;
                actionButtons.classList.add('hidden');

                if (data.expires_at) {
                    resultDetails.textContent = `Son kullanma tarihi: ${data.expires_at}`;
                } else if (data.used_at) {
                    resultDetails.textContent = `Kullanım tarihi: ${data.used_at}`;
                } else {
                    resultDetails.textContent = '';
                }
            }

            document.getElementById('result').classList.remove('hidden');
        }

        function showError(message) {
            const resultCard = document.getElementById('resultCard');
            const resultMessage = document.getElementById('resultMessage');
            const resultDetails = document.getElementById('resultDetails');

            resultCard.className = 'p-4 rounded-xl mb-4 bg-red-500 bg-opacity-20 border border-red-400';
            resultMessage.textContent = message;
            resultDetails.textContent = '';

            document.getElementById('result').classList.remove('hidden');
            document.getElementById('actionButtons').classList.add('hidden');
        }

        function allowEntry() {
            if (!currentQrCodeId) return;

            fetch(`{{ url('etkinlik-gorevlisi/giris-izni-ver') }}/${currentQrCodeId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`✓ ${data.message}\nSaat: ${data.entry_time}`);
                    resetScanner();
                } else {
                    alert(`✕ ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Giriş izni hatası:', error);
                alert('Bir hata oluştu!');
            });
        }

        function denyEntry() {
            if (!currentQrCodeId) return;

            const reason = prompt('Red nedeni (opsiyonel):');

            fetch(`{{ url('etkinlik-gorevlisi/giris-reddet') }}/${currentQrCodeId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    reason: reason || 'Belirtilmedi'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`✕ ${data.message}\nSaat: ${data.denied_at}`);
                    resetScanner();
                } else {
                    alert(`✕ Bir hata oluştu`);
                }
            })
            .catch(error => {
                console.error('Giriş reddetme hatası:', error);
                alert('Bir hata oluştu!');
            });
        }

        // Sayfa yüklendiğinde otomatik başlatma YOK
        // Kullanıcı "Kamerayı Başlat" butonuna tıklayacak
        document.addEventListener('DOMContentLoaded', function() {
            // Hazır
        });
    </script>

</body>
</html>
