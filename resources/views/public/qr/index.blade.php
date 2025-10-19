<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL-BAR QR Kod</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 50%, #ea580c 100%);">

    <div class="container mx-auto px-4 py-12">

        <div class="max-w-2xl mx-auto">

            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/el-bar-logo.png') }}" alt="EL-BAR" class="h-24 mx-auto drop-shadow-2xl">
            </div>

            <!-- QR Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-12">

                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold mb-3" style="background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 50%, #ea580c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        EL-BAR Official QR Code
                    </h1>
                    <p class="text-gray-600 text-lg">Resmi web sitemizi ziyaret edin</p>
                </div>

                <!-- QR Code -->
                <div class="bg-white p-8 rounded-2xl inline-block shadow-xl mx-auto mb-8" style="display: block; text-align: center;">
                    <img src="data:image/png;base64,{{ $qrCode }}" alt="EL-BAR QR Code" class="mx-auto" style="width: {{ $size }}px; height: {{ $size }}px;">
                </div>

                <!-- URL Info -->
                <div class="text-center mb-6">
                    <a href="{{ $url }}" target="_blank" class="text-2xl font-bold hover:underline" style="color: #7c3aed;">
                        {{ $url }}
                    </a>
                </div>

                <!-- Download Button -->
                <div class="text-center">
                    <a href="data:image/png;base64,{{ $qrCode }}" download="el-bar-qr-code.png"
                       class="inline-block text-white font-bold py-4 px-8 rounded-xl shadow-lg transform transition hover:scale-105"
                       style="background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 50%, #ea580c 100%);">
                        💾 QR Kodu İndir
                    </a>
                </div>

                <!-- Info -->
                <div class="mt-8 p-6 rounded-xl" style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.05) 0%, rgba(124, 58, 237, 0.1) 50%, rgba(234, 88, 12, 0.05) 100%);">
                    <p class="text-sm text-gray-600 text-center">
                        📱 Bu QR kodu tarayarak EL-BAR resmi web sitesine ulaşabilirsiniz
                    </p>
                </div>

            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-white/80 text-sm">© {{ date('Y') }} EL-BAR. Tüm hakları saklıdır.</p>
            </div>

        </div>

    </div>

</body>
</html>
