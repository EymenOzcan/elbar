<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Grup Lideri Paneli - Hoşgeldiniz {{ auth()->user()->name }}
            </h2>
            <a href="{{ route('group-leader.teams.create') }}" style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                + Yeni Takım
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- İstatistikler -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Toplam Takımlar</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_teams'] }}</p>
                        </div>
                        <div class="text-4xl text-blue-500">👥</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Aktif Takımlar</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['active_teams'] }}</p>
                        </div>
                        <div class="text-4xl text-green-500">✅</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Toplam Personel</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_personels'] }}</p>
                        </div>
                        <div class="text-4xl text-purple-500">👤</div>
                    </div>
                </div>
            </div>

            <!-- Takımlar Listesi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Yönetilen Takımlar</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Takım Adı</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Takım Lideri</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Personel</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Durum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($teams as $team)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <td class="px-6 py-4">
                                        <strong class="text-gray-900 dark:text-gray-100">{{ $team->name }}</strong>
                                        <br>
                                        <small class="text-gray-500 dark:text-gray-400">{{ $team->description }}</small>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                        {{ $team->leader?->name ?? 'Belirtilmemiş' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            {{ $team->personels_count }} kişi
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($team->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                                Pasif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('group-leader.teams.show', $team) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm">
                                                Görüntüle
                                            </a>
                                            <a href="{{ route('group-leader.teams.edit', $team) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium text-sm">
                                                Düzenle
                                            </a>
                                            <form action="{{ route('group-leader.teams.destroy', $team) }}" method="POST" style="display: inline;" onsubmit="return confirm('Takımı silmek istediğinize emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                                                    Sil
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Henüz yönettiğiniz takım bulunmamaktadır.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
