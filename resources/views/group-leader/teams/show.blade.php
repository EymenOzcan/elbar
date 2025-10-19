<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Takım Detayları: {{ $team->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('group-leader.teams.edit', $team) }}" 
                    style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    ✏️ Düzenle
                </a>
                <a href="{{ route('group-leader.teams.index') }}" 
                    style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    ← Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Takım Bilgileri -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Takım Bilgileri</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Takım Adı</dt>
                            <dd class="text-gray-900 dark:text-gray-100">{{ $team->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Takım Lideri</dt>
                            <dd class="text-gray-900 dark:text-gray-100">{{ $team->leader?->name ?? 'Belirtilmemiş' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Durum</dt>
                            <dd>
                                @if($team->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                        Pasif
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Açıklama</dt>
                            <dd class="text-gray-900 dark:text-gray-100">{{ $team->description ?: 'Belirtilmemiş' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Personel Sayısı</h3>
                    <p class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $team->personels->count() }}</p>
                    <p class="text-gray-600 dark:text-gray-400">kişi bu takımda görev yapıyor</p>
                </div>
            </div>

            <!-- Personel Listesi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Takım Personeli</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Adı Soyadı</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Pozisyon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">İletişim</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($team->personels as $teamPersonel)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                        <strong>{{ $teamPersonel->personel->full_name }}</strong>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                        {{ $teamPersonel->personel->translations->first()?->position ?? 'Belirtilmemiş' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            @if($teamPersonel->personel->email)
                                                <div>📧 {{ $teamPersonel->personel->email }}</div>
                                            @endif
                                            @if($teamPersonel->personel->phone)
                                                <div>📱 {{ $teamPersonel->personel->phone }}</div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Bu takıma henüz personel atanmamıştır.
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
