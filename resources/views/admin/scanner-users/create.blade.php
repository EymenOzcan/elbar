<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Yeni Scanner Kullanıcısı') }}
            </h2>
            <a href="{{ route('admin.scanner-users.index') }}" 
               style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #6b7280; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
               onmouseover="this.style.backgroundColor='#4b5563'"
               onmouseout="this.style.backgroundColor='#6b7280'">
                <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.scanner-users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Bilgilendirme -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-1">QR Scanner Kullanıcısı</h3>
                                    <p class="text-sm text-blue-700 dark:text-blue-400">Bu kullanıcı sadece QR tarama paneline erişebilir. Admin panele erişimi olmayacaktır.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ad Soyad -->
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ad Soyad *
                            </label>
                            <input type="text" 
                                   name="full_name" 
                                   id="full_name" 
                                   value="{{ old('full_name') }}"
                                   required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Örn: Ahmet Yılmaz">
                        </div>

                        <!-- Kullanıcı Adı -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kullanıcı Adı *
                            </label>
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   value="{{ old('username') }}"
                                   required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Örn: ahmet.yilmaz">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Giriş yaparken kullanılacak</p>
                        </div>

                        <!-- Şifre -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Şifre *
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Minimum 6 karakter">
                        </div>

                        <!-- Şifre Tekrar -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Şifre Tekrar *
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Şifreyi tekrar girin">
                        </div>

                        <!-- Durum -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       checked
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pasif kullanıcılar giriş yapamaz</p>
                        </div>

                        <!-- Butonlar -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.scanner-users.index') }}" 
                               style="padding: 12px 24px; background-color: #6b7280; color: white; border-radius: 8px; font-weight: 600; text-decoration: none;"
                               onmouseover="this.style.backgroundColor='#4b5563'"
                               onmouseout="this.style.backgroundColor='#6b7280'">
                                İptal
                            </a>
                            <button type="submit" 
                                    style="padding: 12px 32px; background-color: #10b981; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#059669'"
                                    onmouseout="this.style.backgroundColor='#10b981'">
                                Kullanıcı Oluştur
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>