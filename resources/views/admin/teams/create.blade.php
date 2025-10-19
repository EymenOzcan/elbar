<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Yeni Takım Oluştur</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.teams.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Takım Adı *</label>
                        <input type="text" name="name" class="w-full px-3 py-2 border rounded-md dark:bg-gray-900" required value="{{ old('name') }}">
                        @error('name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Açıklama</label>
                        <textarea name="description" class="w-full px-3 py-2 border rounded-md dark:bg-gray-900" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Grup Lideri</label>
                        <select name="group_leader_id" class="w-full px-3 py-2 border rounded-md dark:bg-gray-800 dark:text-gray-100 text-gray-900 bg-white">
                            <option value="">-- Seçiniz --</option>
                            @forelse($groupLeaders as $leader)
                                <option value="{{ $leader->id }}">{{ $leader->name }}</option>
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
                                <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                            @empty
                                <option disabled>Takım lideri bulunamadı</option>
                            @endforelse
                        </select>
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
                        @forelse($users as $user)
                            <div class="flex items-center p-3 border-b dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 user-item" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                <input type="checkbox" name="personel_ids[]" value="user_{{ $user->id }}" class="mr-3 w-4 h-4" id="user_{{ $user->id }}">
                                <label for="user_{{ $user->id }}" class="cursor-pointer flex-1 text-gray-800 dark:text-gray-200">
                                    <div class="font-semibold">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </label>
                            </div>
                        @empty
                            <p class="p-3 text-gray-500 dark:text-gray-400">Kullanıcı bulunmamaktadır.</p>
                        @endforelse
                    </div>

                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('admin.teams.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">İptal</a>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Oluştur</button>
                    </div>
                </form>
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
