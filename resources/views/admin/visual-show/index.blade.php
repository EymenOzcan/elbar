<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Görsel Show Yönetimi
            </h2>
            <a href="{{ route('admin.visual-show.create') }}"
               style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                + Yeni Görsel Ekle
            </a>
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Toplam Görsel</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Aktif Görsel</h3>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats['active'] }}</p>
                </div>
            </div>

            <!-- Görsel Listesi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($visuals->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($visuals as $visual)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <img src="{{ $visual->image_data }}" alt="{{ $visual->title }}" class="w-full h-48 object-cover rounded-md mb-3">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $visual->title ?? 'Başlıksız' }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Sıra: {{ $visual->order }}</p>
                                    <span class="inline-block px-2 py-1 text-xs rounded {{ $visual->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $visual->is_active ? 'Aktif' : 'Pasif' }}
                                    </span>
                                    <div class="mt-3 flex gap-2">
                                        <a href="{{ route('admin.visual-show.edit', $visual) }}" class="text-blue-600 hover:text-blue-900 text-sm">Düzenle</a>
                                        <form action="{{ route('admin.visual-show.destroy', $visual) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Silmek istediğinize emin misiniz?')" class="text-red-600 hover:text-red-900 text-sm">Sil</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $visuals->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Henüz görsel eklenmemiş.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
