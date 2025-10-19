<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Takımım') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($team)
                <!-- Team Information Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Team Name Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Takım Adı</div>
                        <div class="mt-2 text-xl font-bold text-gray-900 dark:text-gray-100">{{ $team->name }}</div>
                    </div>

                    <!-- Team Leader Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Takım Lideri</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $team->leader?->name ?? 'Atanmadı' }}
                        </div>
                    </div>

                    <!-- Group Leader Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Grup Lideri</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $team->groupLeader?->name ?? 'Atanmadı' }}
                        </div>
                    </div>

                    <!-- Total Colleagues Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Takım Üyeleri</div>
                        <div class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ count($personnel) }}</div>
                    </div>
                </div>

                <!-- Team Colleagues Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Takım Arkadaşları</h3>

                        @if (count($personnel) > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Ad Soyad</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">E-mail</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Telefon</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">İşe Alım Türü</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($personnel as $person)
                                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <td class="py-3 px-4">
                                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $person->full_name }}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                    {{ $person->email ?? '-' }}
                                                </td>
                                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                    {{ $person->phone ?? '-' }}
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                                        @if($person->employment_type === 'kadrolu')
                                                            bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                                        @elseif($person->employment_type === 'part_time')
                                                            bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                        @else
                                                            bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
                                                        @endif
                                                    ">
                                                        @switch($person->employment_type)
                                                            @case('kadrolu')
                                                                Kadrolu
                                                                @break
                                                            @case('part_time')
                                                                Yarı Zamanlı
                                                                @break
                                                            @default
                                                                Belirsiz
                                                        @endswitch
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Henüz başka takım arkadaşı bulunmamaktadır.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Team Description (if available) -->
                @if ($team->description)
                    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Takım Açıklaması</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $team->description }}</p>
                    </div>
                @endif
            @else
                <!-- No Team Assigned -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Takım Bulunamadı</h3>
                        <p class="text-gray-600 dark:text-gray-400">Henüz herhangi bir takıma atanmamışsınız.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
