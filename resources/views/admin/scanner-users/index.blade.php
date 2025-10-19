<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('QR Scanner Kullanıcıları') }}
            </h2>
            <a href="{{ route('admin.scanner-users.create') }}" 
               style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #10b981; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
               onmouseover="this.style.backgroundColor='#059669'"
               onmouseout="this.style.backgroundColor='#10b981'">
                <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Kullanıcı
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- İstatistikler -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: linear-gradient(135deg, #6b7280, #4b5563); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Toplam Kullanıcı</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['total'] }}</p>
                </div>
                <div style="background: linear-gradient(135deg, #10b981, #059669); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Aktif</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['active'] }}</p>
                </div>
                <div style="background: linear-gradient(135deg, #ef4444, #dc2626); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Pasif</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['inactive'] }}</p>
                </div>
                <div style="background: linear-gradient(135deg, #a855f7, #9333ea); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Toplam Tarama</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['total_scans'] }}</p>
                </div>
            </div>

            <!-- Filtreler -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.scanner-users.index') }}" class="flex gap-4">
                        <input type="text" 
                               name="search" 
                               placeholder="Kullanıcı adı veya ad soyad ara..." 
                               value="{{ request('search') }}" 
                               class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        
                        <select name="status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Tüm Durumlar</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Pasif</option>
                        </select>
                        
                        <button type="submit" 
                                style="padding: 8px 16px; background-color: #6366f1; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;"
                                onmouseover="this.style.backgroundColor='#4f46e5'"
                                onmouseout="this.style.backgroundColor='#6366f1'">
                            Filtrele
                        </button>
                        <a href="{{ route('admin.scanner-users.index') }}" 
                           style="padding: 8px 16px; background-color: #6b7280; color: white; border-radius: 6px; font-weight: 600; text-decoration: none;"
                           onmouseover="this.style.backgroundColor='#4b5563'"
                           onmouseout="this.style.backgroundColor='#6b7280'">
                            Temizle
                        </a>
                    </form>
                </div>
            </div>

            <!-- Kullanıcı Listesi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($scannerUsers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Kullanıcı</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Kullanıcı Adı</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tarama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Son Giriş</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Durum</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($scannerUsers as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-semibold">{{ $user->full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->created_at->format('d.m.Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <code class="text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $user->username }}</code>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold text-purple-600">{{ $user->scan_count }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($user->last_login_at)
                                            {{ $user->last_login_at->format('d.m.Y H:i') }}
                                            <div class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</div>
                                        @else
                                            <span class="text-gray-400">Hiç giriş yapmadı</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.scanner-users.toggle-status', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Pasif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.scanner-users.show', $user) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-md hover:bg-indigo-200 dark:hover:bg-indigo-800 transition"
                                               title="Detay">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span class="ml-1.5">Detay</span>
                                            </a>
                                            <a href="{{ route('admin.scanner-users.edit', $user) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-md hover:bg-blue-200 dark:hover:bg-blue-800 transition"
                                               title="Düzenle">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span class="ml-1.5">Düzenle</span>
                                            </a>
                                            <form action="{{ route('admin.scanner-users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Silmek istediğinize emin misiniz?')"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md hover:bg-red-200 dark:hover:bg-red-800 transition"
                                                        title="Sil">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span class="ml-1.5">Sil</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $scannerUsers->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">Henüz scanner kullanıcısı oluşturulmamış</p>
                        <a href="{{ route('admin.scanner-users.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            İlk Kullanıcıyı Oluştur
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>