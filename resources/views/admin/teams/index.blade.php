<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Ekip Yönetimi
            </h2>
            <a href="{{ route('admin.teams.create') }}" style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                + Yeni Ekip Oluştur
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- İstatistikler -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Toplam Ekip</p>
                        <p style="color: #3b82f6; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['total_teams'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Aktif Ekip</p>
                        <p style="color: #10b981; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['active_teams'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Toplam Personel</p>
                        <p style="color: #06b6d4; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $stats['total_personels_in_teams'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Mesajlar -->
            @if ($message = Session::get('success'))
                <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900 p-4">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ $message }}</p>
                </div>
            @endif

            <!-- Ekipler Tablosu -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ekip Adı</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ekip Lideri</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Personel Sayısı</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Durum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Oluşturulma</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($teams as $team)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $team->name }}
                                        </div>
                                        @if ($team->description)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ Str::limit($team->description, 40) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($team->leader)
                                            <span style="background-color: #06b6d4; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                {{ $team->leader->name }}
                                            </span>
                                        @else
                                            <span style="background-color: #6b7280; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                Atanmamış
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span style="background-color: #f3f4f6; color: #1f2937; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $team->personels_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($team->is_active)
                                            <span style="background-color: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                Aktif
                                            </span>
                                        @else
                                            <span style="background-color: #ef4444; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                Pasif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $team->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.teams.show', $team) }}" style="color: #06b6d4;" class="hover:opacity-75">Görüntüle</a>
                                        <a href="{{ route('admin.teams.edit', $team) }}" style="color: #f59e0b;" class="hover:opacity-75">Düzenle</a>
                                        <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="inline" onsubmit="return confirm('Emin misiniz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #ef4444;" class="hover:opacity-75">Sil</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Henüz ekip bulunmamaktadır.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if ($teams->hasPages())
                <div class="mt-6">
                    {{ $teams->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
