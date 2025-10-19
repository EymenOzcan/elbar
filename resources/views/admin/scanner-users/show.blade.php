<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $scannerUser->full_name }} - Detaylar
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    QR Scanner Kullanıcı Bilgileri
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.scanner-users.edit', $scannerUser) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold text-sm">
                    Düzenle
                </a>
                <a href="{{ route('admin.scanner-users.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-semibold text-sm">
                    ← Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kullanıcı Bilgileri -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Kullanıcı Bilgileri</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ad Soyad</label>
                            <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $scannerUser->full_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kullanıcı Adı</label>
                            <p class="mt-1">
                                <code class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $scannerUser->username }}</code>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Durum</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $scannerUser->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $scannerUser->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toplam Tarama</label>
                            <p class="mt-1 text-2xl font-bold text-purple-600">{{ $scannerUser->scan_count }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kayıt Tarihi</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $scannerUser->created_at->format('d.m.Y H:i') }}
                                <span class="text-xs text-gray-500">({{ $scannerUser->created_at->diffForHumans() }})</span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Son Giriş</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                @if($scannerUser->last_login_at)
                                    {{ $scannerUser->last_login_at->format('d.m.Y H:i') }}
                                    <span class="text-xs text-gray-500">({{ $scannerUser->last_login_at->diffForHumans() }})</span>
                                @else
                                    <span class="text-gray-400">Hiç giriş yapmadı</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Toplam Tarama</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $scannerUser->scan_count }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-{{ $scannerUser->is_active ? 'green' : 'red' }}-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($scannerUser->is_active)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                @endif
                            </svg>
                        </div>
                        <div class="ml-5">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Durum</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $scannerUser->is_active ? 'Aktif' : 'Pasif' }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Hesap Yaşı</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $scannerUser->created_at->diffInDays(now()) }} gün</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- İşlemler -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">İşlemler</h3>

                    <div class="flex space-x-4">
                        <form action="{{ route('admin.scanner-users.toggle-status', $scannerUser) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-{{ $scannerUser->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $scannerUser->is_active ? 'red' : 'green' }}-700 text-white px-4 py-2 rounded-md font-semibold text-sm">
                                {{ $scannerUser->is_active ? 'Pasif Yap' : 'Aktif Yap' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.scanner-users.destroy', $scannerUser) }}" method="POST" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold text-sm">
                                Kullanıcıyı Sil
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
