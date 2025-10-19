<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Kod Yönetimi') }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.qr-system.create') }}" 
               style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #2563eb; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
               onmouseover="this.style.backgroundColor='#1d4ed8'"
               onmouseout="this.style.backgroundColor='#2563eb'">
                <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Test QR Oluştur
            </a>
            <form action="{{ route('admin.qr-system.clean-expired') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" 
                        style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #eab308; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.backgroundColor='#ca8a04'"
                        onmouseout="this.style.backgroundColor='#eab308'">
                    <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Süresi Dolmuşları Temizle
                </button>
            </form>
        </div>
    </div>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- İstatistikler -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Toplam</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['total'] }}</div>
                        </div>
                        <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 overflow-hidden shadow-sm sm:rounded-lg p-4 border border-green-200 dark:border-green-800">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-xs font-medium text-green-600 dark:text-green-400 uppercase tracking-wide">Aktif</div>
                            <div class="text-2xl font-bold text-green-700 dark:text-green-300 mt-1">{{ $stats['active'] }}</div>
                        </div>
                        <div class="w-10 h-10 bg-green-200 dark:bg-green-800 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 overflow-hidden shadow-sm sm:rounded-lg p-4 border border-red-200 dark:border-red-800">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-xs font-medium text-red-600 dark:text-red-400 uppercase tracking-wide">Dolmuş</div>
                            <div class="text-2xl font-bold text-red-700 dark:text-red-300 mt-1">{{ $stats['expired'] }}</div>
                        </div>
                        <div class="w-10 h-10 bg-red-200 dark:bg-red-800 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 overflow-hidden shadow-sm sm:rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wide">Kullanılan</div>
                            <div class="text-2xl font-bold text-blue-700 dark:text-blue-300 mt-1">{{ $stats['used'] }}</div>
                        </div>
                        <div class="w-10 h-10 bg-blue-200 dark:bg-blue-800 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 overflow-hidden shadow-sm sm:rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-xs font-medium text-purple-600 dark:text-purple-400 uppercase tracking-wide">Tarama</div>
                            <div class="text-2xl font-bold text-purple-700 dark:text-purple-300 mt-1">{{ $stats['total_scans'] }}</div>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 dark:bg-purple-800 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtreler -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.qr-system.index') }}" class="flex gap-4">
                        <input type="text" name="search" placeholder="QR Kod veya URL ara..." value="{{ request('search') }}" class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        
                        <select name="status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Tüm Durumlar</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Süresi Dolmuş</option>
                            <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Kullanılmış</option>
                        </select>
                        
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Filtrele
                        </button>
                        <a href="{{ route('admin.qr-system.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Temizle
                        </a>
                    </form>
                </div>
            </div>

            <!-- QR Listesi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($qrCodes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">QR Kod</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Hedef URL</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Durum</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tarama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Son Kullanma</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($qrCodes as $qr)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ asset('storage/' . $qr->qr_image_path) }}" alt="QR" class="w-12 h-12 mr-3">
                                            <span class="text-sm font-mono">{{ $qr->code }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm max-w-xs truncate" title="{{ $qr->target_url }}">
                                            {{ $qr->target_url }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($qr->isValid())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @elseif($qr->isExpired())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Süresi Dolmuş</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Pasif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $qr->scan_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $qr->expires_at->format('d.m.Y H:i') }}
                                        <div class="text-xs text-gray-500">{{ $qr->expires_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.qr-system.show', $qr) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Görüntüle</a>
                                        <form action="{{ route('admin.qr-system.destroy', $qr) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Silmek istediğinize emin misiniz?')" class="text-red-600 hover:text-red-900">Sil</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $qrCodes->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">Henüz QR kod oluşturulmamış</p>
                        <a href="{{ route('admin.qr-system.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            İlk QR'ı Oluştur
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>