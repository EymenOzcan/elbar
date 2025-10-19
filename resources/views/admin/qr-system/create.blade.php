<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    {{ __('Yeni QR Kod Oluştur') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Logolu QR kod oluşturun, 2 dakika geçerli olacak</p>
            </div>
            <a href="{{ route('admin.qr-system.index') }}" 
           style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #6366f1; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
           onmouseover="this.style.backgroundColor='#4f46e5'"
           onmouseout="this.style.backgroundColor='#6366f1'">
            <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            QR Listesine Dön
        </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            
            <!-- Ana Form Kartı -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    
                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-2">Hata!</h3>
                                <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-2">Hata!</h3>
                                <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-green-800 dark:text-green-300 mb-2">Başarılı!</h3>
                                <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('admin.qr-system.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Bilgilendirme Banner -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-300 mb-2">QR Kod Özellikleri</h3>
                                    <div class="text-sm text-blue-800 dark:text-blue-400 space-y-2">
                                        <p class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            QR kod <strong>2 dakika</strong> süreyle geçerli olacaktır
                                        </p>
                                        <p class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            QR kodun ortasında <strong>el-bar logosu</strong> görünecektir
                                        </p>
                                        <p class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Kullanıcılar QR'ı tarayarak belirlediğiniz URL'e yönlendirilecektir
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hedef URL Input -->
                        <!-- Hedef URL Input -->
                            <div class="p-6 space-y-2">
                                <label for="target_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Hedef URL *
                                </label>
                                <input type="url" 
                                    name="target_url" 
                                    id="target_url" 
                                    value="{{ old('target_url') }}"
                                    placeholder="https://example.com"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition-all">
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    QR kod tarandığında kullanıcılar bu adrese yönlendirilecektir
                                </p>
                            </div>

                   <!-- Butonlar -->
                        <div class="flex items-center justify-between pt-6" style="border-top: 2px solid #e5e7eb; padding-top: 24px;">
                            <a href="{{ route('admin.qr-system.index') }}" 
                            style="display: inline-flex; align-items: center; padding: 12px 24px; background-color: #eab308; color: white; border-radius: 8px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.2s;"
                            onmouseover="this.style.backgroundColor='#ca8a04'; this.style.boxShadow='0 6px 8px rgba(0,0,0,0.15)'"
                            onmouseout="this.style.backgroundColor='#eab308'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                                <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                İptal
                            </a>
                            <button type="submit" 
                                    style="display: inline-flex; align-items: center; padding: 12px 32px; background-color: #16a34a; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.2s;"
                                    onmouseover="this.style.backgroundColor='#15803d'; this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 10px rgba(0,0,0,0.2)'"
                                    onmouseout="this.style.backgroundColor='#16a34a'; this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                                <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                QR Kod Oluştur
                            </button>
</div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>