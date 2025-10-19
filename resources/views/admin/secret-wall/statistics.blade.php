<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Sır Duvarı İstatistikleri
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Detaylı istatistik ve raporlar
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.secret-wall.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-semibold text-sm">
                    ← Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- İstatistik Kartları -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Toplam Kayıt -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Toplam Kayıt</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['total'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Onaylanmış -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Onaylanmış</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['approved'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Bekleyen -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Bekleyen</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['pending'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Reddedilen -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Reddedilen</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['rejected'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detaylı İstatistikler -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detaylı Bilgiler</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Onay Oranı</h4>
                        <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                            @php
                                $approvalRate = $stats['total'] > 0 ? ($stats['approved'] / $stats['total']) * 100 : 0;
                            @endphp
                            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $approvalRate }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($approvalRate, 1) }}%</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bekleyen Oranı</h4>
                        <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                            @php
                                $pendingRate = $stats['total'] > 0 ? ($stats['pending'] / $stats['total']) * 100 : 0;
                            @endphp
                            <div class="bg-yellow-500 h-4 rounded-full" style="width: {{ $pendingRate }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($pendingRate, 1) }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
