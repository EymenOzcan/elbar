<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Yeni Rol Ekle') }}
            </h2>
            <a href="{{ route('admin.roles.index') }}" 
               style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
               onmouseover="this.style.backgroundColor='#4b5563'" 
               onmouseout="this.style.backgroundColor='#6b7280'">
                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bilgi Kartı -->
            <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                <div style="display: flex; align-items: flex-start;">
                    <svg style="width: 20px; height: 20px; color: #3b82f6; margin-right: 12px; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p style="color: #1e40af; font-size: 14px;">
                            Yeni bir rol oluşturun ve bu role atanacak izinleri seçin. Roller, kullanıcıların sistem içinde yapabileceklerini belirler.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf

                        <!-- Rol Adı -->
                        <div style="margin-bottom: 32px;">
                            <label for="name" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;" class="dark:text-gray-300">
                                <span style="color: #ef4444;">*</span> Rol Adı
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   style="width: 100%; max-width: 400px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;"
                                   class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Örn: editor, moderator">
                            @error('name')
                                <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                            <p style="color: #6b7280; font-size: 12px; margin-top: 4px;">Rol adı küçük harflerle ve İngilizce yazılmalıdır.</p>
                        </div>

                        <!-- İzinler Bölümü -->
                        <div>
                            <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid #e5e7eb;" class="dark:text-gray-100 dark:border-gray-700">
                                İzinler
                            </h3>

                            @foreach($permissions as $group => $groupPermissions)
                            <div style="margin-bottom: 24px; padding: 16px; background-color: #f9fafb; border-radius: 8px;" class="dark:bg-gray-700">
                                <h4 style="font-size: 14px; font-weight: 600; text-transform: capitalize; color: #374151; margin-bottom: 12px; display: flex; align-items: center;" class="dark:text-gray-300">
                                    @if($group == 'user')
                                        <svg style="width: 20px; height: 20px; margin-right: 8px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        Kullanıcı Yönetimi
                                    @elseif($group == 'role')
                                        <svg style="width: 20px; height: 20px; margin-right: 8px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Rol Yönetimi
                                    @elseif($group == 'content')
                                        <svg style="width: 20px; height: 20px; margin-right: 8px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        İçerik Yönetimi
                                    @elseif($group == 'settings')
                                        <svg style="width: 20px; height: 20px; margin-right: 8px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Ayarlar
                                    @elseif($group == 'reports')
                                        <svg style="width: 20px; height: 20px; margin-right: 8px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8m5 -6h4"></path>
                                        </svg>
                                        Raporlar
                                    @else
                                        {{ ucfirst($group) }}
                                    @endif
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($groupPermissions as $permission)
                                    <label style="display: flex; align-items: center; padding: 8px; background-color: white; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; transition: all 0.3s;"
                                           onmouseover="this.style.borderColor='#3b82f6'; this.style.backgroundColor='#eff6ff'"
                                           onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='white'"
                                           class="dark:bg-gray-800 dark:border-gray-600">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}"
                                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <span style="margin-left: 8px; font-size: 13px; color: #374151;" class="dark:text-gray-300">
                                            @php
                                                $permissionLabel = str_replace('-', ' ', $permission->name);
                                                $permissionLabel = str_replace(['user ', 'role ', 'content ', 'settings ', 'reports '], '', $permissionLabel);
                                                $permissionLabel = ucfirst($permissionLabel);
                                            @endphp
                                            {{ $permissionLabel }}
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                            <!-- Tümünü Seç/Kaldır Butonları -->
                            <div style="margin-top: 16px; display: flex; gap: 8px;">
                                <button type="button" 
                                        onclick="selectAll()"
                                        style="padding: 8px 16px; background-color: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                        onmouseover="this.style.backgroundColor='#e5e7eb'"
                                        onmouseout="this.style.backgroundColor='#f3f4f6'">
                                    Tümünü Seç
                                </button>
                                <button type="button" 
                                        onclick="deselectAll()"
                                        style="padding: 8px 16px; background-color: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                        onmouseover="this.style.backgroundColor='#e5e7eb'"
                                        onmouseout="this.style.backgroundColor='#f3f4f6'">
                                    Tümünü Kaldır
                                </button>
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.roles.index') }}" 
                               style="padding: 10px 24px; background-color: #f3f4f6; color: #374151; border-radius: 6px; font-weight: 600; text-decoration: none; margin-right: 12px; transition: all 0.3s;"
                               onmouseover="this.style.backgroundColor='#e5e7eb'"
                               onmouseout="this.style.backgroundColor='#f3f4f6'">
                                İptal
                            </a>
                            <button type="submit" 
                                    style="padding: 10px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(102, 126, 234, 0.25);"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 8px rgba(102, 126, 234, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(102, 126, 234, 0.25)'">
                                <span style="display: flex; align-items: center;">
                                    <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Rol Oluştur
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAll() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = true);
        }
        
        function deselectAll() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
        }
    </script>
</x-app-layout>