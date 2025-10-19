<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Takımlarım') }}
            </h2>
            <a href="{{ route('group-leader.teams.create') }}" style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                + Yeni Takım
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if ($teams->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($teams as $team)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $team->name }}</h3>
                                        @if ($team->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($team->description, 100) }}</p>
                                        @endif
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if($team->is_active)
                                            bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                        @else
                                            bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                        @endif
                                    ">
                                        {{ $team->is_active ? 'Aktif' : 'Pasif' }}
                                    </span>
                                </div>

                                <div class="space-y-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                                    @if ($team->leader)
                                        <div><strong>Takım Lideri:</strong> {{ $team->leader->name }}</div>
                                    @endif
                                    <div><strong>Personel Sayısı:</strong> {{ $team->personels_count }}</div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('group-leader.teams.show', $team) }}" 
                                        class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium text-sm">
                                        Görüntüle
                                    </a>
                                    <a href="{{ route('group-leader.teams.edit', $team) }}" 
                                        class="flex-1 text-center px-3 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium text-sm">
                                        Düzenle
                                    </a>
                                    <form action="{{ route('group-leader.teams.destroy', $team) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Takımı silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium text-sm">
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $teams->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="text-center">
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Henüz herhangi bir takım oluşturmamışsınız.</p>
                        <a href="{{ route('group-leader.teams.create') }}" 
                            style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                            Yeni Takım Oluştur
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
