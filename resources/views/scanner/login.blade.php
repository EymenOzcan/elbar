<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>QR Scanner Giriş - el-bar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="gradient-bg">
    
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/el-bar-logo.png') }}" alt="el-bar" class="h-16 mx-auto mb-4 drop-shadow-lg">
                <h1 class="text-3xl font-bold text-white mb-2">QR Scanner</h1>
                <p class="text-white text-opacity-80">Lütfen giriş yapın</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8">
                
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-sm text-red-800">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('scanner.login.post') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="mb-6">
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Kullanıcı Adı</label>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               value="{{ old('username') }}"
                               required
                               autocomplete="username"
                               class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 transition"
                               placeholder="Kullanıcı adınız">
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Şifre</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required
                               autocomplete="current-password"
                               class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 transition"
                               placeholder="Şifreniz">
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-3 text-sm text-gray-700">Beni Hatırla</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" 
                            style="width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 16px; font-size: 18px; font-weight: 700; cursor: pointer; box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4); transition: all 0.3s;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 30px rgba(102, 126, 234, 0.5)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(102, 126, 234, 0.4)'">
                        Giriş Yap
                    </button>
                </form>

            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-white text-sm opacity-75">&copy; {{ date('Y') }} el-bar QR Scanner</p>
            </div>

        </div>
    </div>

</body>
</html>