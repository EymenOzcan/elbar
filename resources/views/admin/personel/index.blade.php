<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Personel Yönetimi
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.personel.statistics') }}"
                   style="background-color: #16a34a; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    İstatistikler
                </a>
                <a href="{{ route('admin.personel.create') }}"
                   style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    + Yeni Personel Ekle
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- İstatistikler -->
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: linear-gradient(135deg, #6b7280, #4b5563); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Toplam Personel</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['total'] }}</p>
                </div>
                <div style="background: linear-gradient(135deg, #10b981, #059669); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Aktif</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['active'] }}</p>
                </div>
                <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Primli</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['primli'] }}</p>
                </div>
                <div style="background: linear-gradient(135deg, #a855f7, #9333ea); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Kadrolu</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['kadrolu'] }}</p>
                </div>
                <div style="background: linear-gradient(135deg, #f97316, #ea580c); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">Toplam Takip</h3>
                    <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['total_follows'] }}</p>
                </div>
            </div>

            <!-- Personel Listesi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($personels->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ad Soyad</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pozisyon</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Çalışan Tipi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Toplam Takipçi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">QR Kod</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Durum</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($personels as $personel)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $personel->full_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $personel->email ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $personel->position ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-block px-2 py-1 text-xs rounded {{ $personel->employment_type === 'primli' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ ucfirst($personel->employment_type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                <span class="font-semibold text-green-600">{{ $personel->social_media_follows_count }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400 font-mono">
                                                {{ $personel->qr_code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-block px-2 py-1 text-xs rounded {{ $personel->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $personel->is_active ? 'Aktif' : 'Pasif' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('admin.personel.show', $personel) }}" title="İstatistik" class="text-green-600 hover:text-green-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admin.personel.edit', $personel) }}" title="Düzenle" class="text-blue-600 hover:text-blue-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admin.personel.destroy', $personel) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Silmek istediğinize emin misiniz?')" title="Sil" class="text-red-600 hover:text-red-900">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $personels->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Henüz personel eklenmemiş.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
