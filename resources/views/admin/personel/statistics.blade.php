<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Personel İstatistikleri
            </h2>
            <a href="{{ route('admin.personel.index') }}" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                Personel Listesi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tarih Filtresi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tarih Filtresi</h3>
                    <form method="GET" action="{{ route('admin.personel.statistics') }}" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Başlangıç Tarihi</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                   class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bitiş Tarihi</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                   class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; display: inline-flex; align-items: center;">
                                Filtrele
                            </button>
                            <a href="{{ route('admin.personel.statistics') }}" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center;">
                                Temizle
                            </a>
                        </div>
                    </form>
                    @if($startDate || $endDate)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                            <strong>Aktif Filtre:</strong>
                            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d.m.Y') : '...' }} -
                            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d.m.Y') : '...' }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Platform Bazında İstatistikler -->
            @php
                $platformColors = [
                    'instagram' => ['from' => '#E4405F', 'to' => '#C13584', 'label' => 'Instagram'],
                    'facebook' => ['from' => '#1877F2', 'to' => '#0C63D4', 'label' => 'Facebook'],
                    'tiktok' => ['from' => '#000000', 'to' => '#69C9D0', 'label' => 'TikTok'],
                    'x' => ['from' => '#000000', 'to' => '#1DA1F2', 'label' => 'X'],
                    'linkedin' => ['from' => '#0077B5', 'to' => '#005E93', 'label' => 'LinkedIn'],
                    'youtube' => ['from' => '#FF0000', 'to' => '#CC0000', 'label' => 'YouTube'],
                    'whatsapp' => ['from' => '#25D366', 'to' => '#128C7E', 'label' => 'WhatsApp'],
                ];
            @endphp
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                @foreach($platformColors as $key => $colors)
                    <div style="background: linear-gradient(135deg, {{ $colors['from'] }}, {{ $colors['to'] }}); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                        <h3 style="color: white; font-size: 0.875rem; font-weight: 500; opacity: 0.9;">{{ $colors['label'] }}</h3>
                        <p style="color: white; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">{{ $platformTotals[$key] ?? 0 }}</p>
                    </div>
                @endforeach
            </div>

            <!-- En Çok Takip Toplayan Personeller -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">En Çok Takip Toplayan Personeller (Top 10)</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Sıra</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Ad Soyad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Çalışan Tipi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Toplam Takip</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Detay</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($topPersonels as $index => $personel)
                                    <tr class="{{ $index < 3 ? 'bg-yellow-50 dark:bg-yellow-900' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                                            {{ $index + 1 }}
                                            @if($index === 0) 🥇
                                            @elseif($index === 1) 🥈
                                            @elseif($index === 2) 🥉
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $personel->full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <span class="inline-block px-2 py-1 text-xs rounded {{ $personel->employment_type === 'primli' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ ucfirst($personel->employment_type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400">
                                            {{ $personel->social_media_follows_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('admin.personel.show', $personel) }}" title="Detay" class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Son Takipler -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Son Takipler (50)</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Personel</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Platform</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tarih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentFollows as $follow)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $follow->name }} {{ $follow->surname }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                                {{ ucfirst($follow->platform) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $follow->created_at ? \Carbon\Carbon::parse($follow->created_at)->format('d.m.Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
