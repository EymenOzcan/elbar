<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modül Yönetimi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Etkinlik Modülleri</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Önyüz ana panelde aktif olacak modülü seçin. Sadece bir modül aktif olabilir.
                        </p>
                    </div>

                    @if($modules->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Modül Adı</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Sıralama</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Durum</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">İşlem</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($modules as $module)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $module->label }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $module->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $module->sort_order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $module->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ $module->is_active ? 'Aktif' : 'Pasif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <form action="{{ route('admin.modules.toggle-status', $module) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    style="background-color: {{ $module->is_active ? '#ef4444' : '#10b981' }}; color: white; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; border: none; cursor: pointer;"
                                                    onmouseover="this.style.backgroundColor='{{ $module->is_active ? '#dc2626' : '#059669' }}'"
                                                    onmouseout="this.style.backgroundColor='{{ $module->is_active ? '#ef4444' : '#10b981' }}'">
                                                {{ $module->is_active ? 'Pasif Yap' : 'Aktif Yap' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">Henüz modül oluşturulmamış</p>
                    </div>
                    @endif

                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-md">
                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-2">Bilgi:</h4>
                        <ul class="text-xs text-blue-800 dark:text-blue-400 space-y-1">
                            <li>• Sadece bir modül aktif olabilir.</li>
                            <li>• Aktif modül önyüz ana panelde görüntülenir.</li>
                            <li>• Tüm modüller pasif olabilir.</li>
                            <li>• <strong>QR Kodlar:</strong> Etkinlik giriş sistemi - QR kod ile giriş kontrolü</li>
                            <li>• <strong>Görsel Show:</strong> Medya gösterimi - Resim ve video slayt gösterimi</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
