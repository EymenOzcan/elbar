<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Takım Lideri Paneli - Hoşgeldiniz {{ auth()->user()->name }}
            </h2>
            @if($team)
                <a href="{{ route('team-leader.personel.index') }}" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    👥 Personel Yönetimi
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($team)
                <!-- Takım Bilgileri -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Yönettiğiniz Takım</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $team->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $team->description ?: 'Açıklama belirtilmemiş' }}</p>
                        
                        @if($team->groupLeader)
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Grup Lideri:</strong> {{ $team->groupLeader->name }}
                            </p>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Takım İstatistikleri</h3>
                        <p class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $stats['total_personels'] }}</p>
                        <p class="text-gray-600 dark:text-gray-400">personel bulunmaktadır</p>
                    </div>
                </div>

                <!-- Personeller -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Takım Personeli</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Yönettiğiniz personelleriniz aşağıda listelenmiştir</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Adı Soyadı</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Pozisyon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">İletişim</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($team->personels as $teamPersonel)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <strong class="text-gray-900 dark:text-gray-100">{{ $teamPersonel->personel->full_name }}</strong>
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                            {{ $teamPersonel->personel->translations->first()?->position ?? 'Belirtilmemiş' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                @if($teamPersonel->personel->email)
                                                    <div>{{ $teamPersonel->personel->email }}</div>
                                                @endif
                                                @if($teamPersonel->personel->phone)
                                                    <div>{{ $teamPersonel->personel->phone }}</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Takımınızda henüz personel bulunmamaktadır.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Takım Ataması Yok</h3>
                    <p class="text-gray-600 dark:text-gray-400">Henüz size atanmış bir takım bulunmamaktadır. Lütfen yönetim ekibiyle iletişime geçiniz.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
