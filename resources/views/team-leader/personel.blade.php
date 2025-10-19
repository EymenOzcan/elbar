<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Takım Personeli Yönetimi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if ($team)
                <!-- Takım Bilgisi -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $team->name }}</h3>
                    @if ($team->description)
                        <p class="text-gray-600 dark:text-gray-400">{{ $team->description }}</p>
                    @endif
                </div>

                <!-- Personel Ekleme Formu -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">👥 Takıma Personel Ekle</h3>
                    
                    <form action="{{ route('team-leader.team-personels.store', $team) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="search" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Kişi Ara</label>
                            <input 
                                type="text" 
                                id="search_input" 
                                placeholder="Ad veya email ile ara..." 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                        </div>

                        <div id="results" class="border rounded-md dark:bg-gray-900 dark:border-gray-700 max-h-64 overflow-y-auto">
                            @forelse($allUsers as $user)
                                <div class="flex items-center p-3 border-b dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 user-item" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                    <input type="checkbox" name="item_id[]" value="user_{{ $user->id }}" class="mr-3 w-4 h-4" id="user_{{ $user->id }}">
                                    <label for="user_{{ $user->id }}" class="cursor-pointer flex-1 text-gray-800 dark:text-gray-200">
                                        <div class="font-semibold">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </label>
                                </div>
                            @empty
                                <p class="p-3 text-gray-500 dark:text-gray-400">Kullanıcı bulunmamaktadır.</p>
                            @endforelse
                        </div>
                        
                        <div class="flex gap-3 justify-end mt-4">
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 font-medium">
                                Ekle
                            </button>
                        </div>

                        @error('item_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </form>
                </div>

                <!-- Takım Personelleri -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Takım Üyeleri ({{ $personels->count() }})
                        </h3>

                        @if ($personels->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Ad Soyad</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">E-mail</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Telefon</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">İşe Alım Türü</th>
                                            <th class="text-center py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($personels as $tp)
                                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <td class="py-3 px-4">
                                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $tp->personel->full_name }}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                    {{ $tp->personel->email ?? '-' }}
                                                </td>
                                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                    {{ $tp->personel->phone ?? '-' }}
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                                        @if($tp->personel->employment_type === 'full_time')
                                                            bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                                        @elseif($tp->personel->employment_type === 'part_time')
                                                            bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                        @else
                                                            bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
                                                        @endif
                                                    ">
                                                        @switch($tp->personel->employment_type)
                                                            @case('full_time')
                                                                Tam Zamanlı
                                                                @break
                                                            @case('part_time')
                                                                Yarı Zamanlı
                                                                @break
                                                            @default
                                                                Belirsiz
                                                        @endswitch
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <form action="{{ route('team-leader.team-personels.destroy', [$team, $tp]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 font-medium"
                                                            onclick="return confirm('Personeli takımdan çıkarmak istediğinize emin misiniz?')">
                                                            Çıkar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Henüz takımda personel bulunmamaktadır.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="text-center">
                        <p class="text-gray-600 dark:text-gray-400">Bir takıma atanmamışsınız.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('search_input').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('#results > div.user-item').forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(query) ? '' : 'none';
            });
        });
    </script>

</x-app-layout>
