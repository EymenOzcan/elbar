<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Yeni Takım Oluştur
            </h2>
            <a href="{{ route('group-leader.teams.index') }}" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                ← Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('group-leader.teams.store') }}" method="POST">
                        @csrf

                        <!-- Takım Adı -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Takım Adı *
                            </label>
                            <input type="text" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('name') border-red-500 @enderror" 
                                id="name" 
                                name="name" 
                                placeholder="Örn: Pazarlama Takımı" 
                                value="{{ old('name') }}" 
                                required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Açıklama -->
                        <div class="mb-6">
                            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Açıklama
                            </label>
                            <textarea 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('description') border-red-500 @enderror" 
                                id="description" 
                                name="description" 
                                rows="4" 
                                placeholder="Takım hakkında bilgi girin...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Takım Lideri -->
                        <div class="mb-6">
                            <label for="leader_id" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Takım Lideri
                            </label>
                            <select 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md @error('leader_id') border-red-500 @enderror" 
                                id="leader_id" 
                                name="leader_id">
                                <option value="">-- Seçiniz --</option>
                                @foreach ($teamLeaders as $leader)
                                    <option value="{{ $leader->id }}" {{ old('leader_id') == $leader->id ? 'selected' : '' }}>
                                        {{ $leader->name }} ({{ $leader->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('leader_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Personel Seçimi -->
                        <div class="mb-6">
                            <label for="search" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                👥 Personel Ara
                            </label>
                            <input 
                                type="text" 
                                id="search_input" 
                                placeholder="Ad veya email ile ara..." 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                            
                            <div id="results" class="border rounded-md dark:bg-gray-900 dark:border-gray-700 max-h-64 overflow-y-auto">
                                @forelse($users as $user)
                                    <div class="flex items-center p-3 border-b dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 user-item" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                        <input type="checkbox" name="personel_ids[]" value="user_{{ $user->id }}" class="mr-3 w-4 h-4" id="user_{{ $user->id }}" {{ in_array('user_' . $user->id, old('personel_ids', [])) ? 'checked' : '' }}>
                                        <label for="user_{{ $user->id }}" class="cursor-pointer flex-1 text-gray-800 dark:text-gray-200">
                                            <div class="font-semibold">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        </label>
                                    </div>
                                @empty
                                    <p class="p-3 text-gray-500 dark:text-gray-400">Kullanıcı bulunmamaktadır.</p>
                                @endforelse
                            </div>
                            @error('personel_ids')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Butonlar -->
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('group-leader.teams.index') }}" 
                                style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                                İptal
                            </a>
                            <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; border: none; cursor: pointer;">
                                Oluştur
                            </button>
                        </div>
                    </form>
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
