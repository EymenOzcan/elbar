<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Scanner Kullanıcısı Düzenle') }}
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

                    <form action="{{ route('admin.scanner-users.update', $scannerUser) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Kullanıcı Bilgisi -->
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Kullanıcı ID</p>
                                    <p class="text-lg font-bold">{{ $scannerUser->id }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Toplam Tarama</p>
                                    <p class="text-lg font-bold text-purple-600">{{ $scannerUser->scan_count }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Kayıt Tarihi</p>
                                    <p class="text-lg font-bold">{{ $scannerUser->created_at->format('d.m.Y') }}</p>
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
                                   value="{{ old('full_name', $scannerUser->full_name) }}"
                                   required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Kullanıcı Adı -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kullanıcı Adı *
                            </label>
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   value="{{ old('username', $scannerUser->username) }}"
                                   required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Şifre (Opsiyonel) -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold mb-4">Şifre Değiştir (Opsiyonel)</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Yeni Şifre
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                           placeholder="Boş bırakırsanız şifre değişmez">
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Yeni Şifre Tekrar
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation" 
                                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Durum -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       {{ $scannerUser->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                            </label>
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
                                    style="padding: 12px 32px; background-color: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#2563eb'"
                                    onmouseout="this.style.backgroundColor='#3b82f6'">
                                Güncelle
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>