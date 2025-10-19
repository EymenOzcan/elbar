<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Takım Düzenle: {{ $team->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.teams.update', $team) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Takım Adı *</label>
                        <input type="text" name="name" class="w-full px-3 py-2 border rounded-md dark:bg-gray-900" required value="{{ old('name', $team->name) }}">
                        @error('name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Açıklama</label>
                        <textarea name="description" class="w-full px-3 py-2 border rounded-md dark:bg-gray-900" rows="3">{{ old('description', $team->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Grup Lideri</label>
                        <select name="group_leader_id" class="w-full px-3 py-2 border rounded-md dark:bg-gray-800 dark:text-gray-100 text-gray-900 bg-white">
                            <option value="">-- Seçiniz --</option>
                            @forelse($groupLeaders as $leader)
                                <option value="{{ $leader->id }}" @if($team->group_leader_id == $leader->id) selected @endif>{{ $leader->name }}</option>
                            @empty
                                <option disabled>Grup lideri bulunamadı</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Takım Lideri</label>
                        <select name="leader_id" class="w-full px-3 py-2 border rounded-md dark:bg-gray-800 dark:text-gray-100 text-gray-900 bg-white">
                            <option value="">-- Seçiniz --</option>
                            @forelse($teamLeaders as $leader)
                                <option value="{{ $leader->id }}" @if($team->leader_id == $leader->id) selected @endif>{{ $leader->name }}</option>
                            @empty
                                <option disabled>Takım lideri bulunamadı</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ $team->is_active ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm font-bold">Aktif</span>
                        </label>
                    </div>

                    <hr class="my-6">

                    <div class="mb-4">
                        <label for="search" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">👥 Kullanıcı Ara</label>
                        <input 
                            type="text" 
                            id="search_input" 
                            placeholder="Ad veya email ile ara..." 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                    </div>

                    <div id="results" class="border rounded-md dark:bg-gray-900 dark:border-gray-700 max-h-64 overflow-y-auto">
                        @php
                            // Takımdaki personellerin emails'lerini al
                            $selectedPersonelEmails = $team->personels->map(fn($tp) => $tp->personel->email)->toArray();
                        @endphp
                        @forelse($users as $user)
                            @if (!in_array($user->email, $selectedPersonelEmails))
                                <div class="flex items-center p-3 border-b dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 user-item" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                    <input type="checkbox" name="personel_ids[]" value="user_{{ $user->id }}" class="mr-3 w-4 h-4" id="user_{{ $user->id }}">
                                    <label for="user_{{ $user->id }}" class="cursor-pointer flex-1 text-gray-800 dark:text-gray-200">
                                        <div class="font-semibold">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </label>
                                </div>
                            @endif
                        @empty
                            <p class="p-3 text-gray-500 dark:text-gray-400">Kullanıcı bulunmamaktadır.</p>
                        @endforelse
                    </div>

                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('admin.teams.show', $team) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">İptal</a>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Güncelle</button>
                    </div>
                </form>
            </div>

            <!-- Takım Üyeleri -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Takım Üyeleri ({{ $team->personels()->count() }})
                    </h3>

                    @if ($team->personels()->count() > 0)
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
                                    @foreach ($team->personels as $tp)
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
                                                <form action="{{ route('admin.teams.remove-personel', [$team, $tp]) }}" method="POST" style="display: inline;">
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
