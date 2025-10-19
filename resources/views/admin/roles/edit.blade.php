<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rol Düzenle') }}
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
            <!-- Rol Bilgi Kartı -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <h3 style="color: white; font-size: 20px; font-weight: 600; text-transform: capitalize;">
                            {{ $role->name }} Rolü
                        </h3>
                        <p style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-top: 4px;">
                            Bu role sahip {{ $role->users()->count() }} kullanıcı bulunuyor
                        </p>
                    </div>
                    @if($role->name === 'super-admin')
                    <div style="background-color: rgba(255, 255, 255, 0.2); padding: 8px 16px; border-radius: 20px;">
                        <span style="color: white; font-size: 12px; font-weight: 600;">
                            SİSTEM ROLÜ
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        <!-- Rol Adı -->
                        <div style="margin-bottom: 32px;">
                            <label for="name" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;" class="dark:text-gray-300">
                                <span style="color: #ef4444;">*</span> Rol Adı
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $role->name) }}" 
                                   required 
                                   {{ $role->name === 'super-admin' ? 'readonly' : '' }}
                                   style="width: 100%; max-width: 400px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; {{ $role->name === 'super-admin' ? 'background-color: #f3f4f6; cursor: not-allowed;' : '' }}"
                                   class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('name')
                                <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                            @if($role->name === 'super-admin')
                                <p style="color: #f59e0b; font-size: 12px; margin-top: 4px;">
                                    ⚠️ Super Admin rolünün adı değiştirilemez.
                                </p>
                            @endif
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
                                    @else
                                        {{ ucfirst($group) }}
                                    @endif
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($groupPermissions as $permission)
                                    <label style="display: flex; align-items: center; padding: 8px; background-color: {{ in_array($permission->id, $rolePermissions) ? '#dbeafe' : 'white' }}; border: 1px solid {{ in_array($permission->id, $rolePermissions) ? '#3b82f6' : '#e5e7eb' }}; border-radius: 6px; cursor: pointer; transition: all 0.3s;"
                                           onmouseover="this.style.borderColor='#3b82f6'; this.style.backgroundColor='#eff6ff'"
                                           onmouseout="this.style.borderColor='{{ in_array($permission->id, $rolePermissions) ? '#3b82f6' : '#e5e7eb' }}'; this.style.backgroundColor='{{ in_array($permission->id, $rolePermissions) ? '#dbeafe' : 'white' }}'"
                                           class="dark:bg-gray-800 dark:border-gray-600">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}"
                                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                               {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
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
                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <!-- Sol taraf - Silme butonu -->
                            @if($role->name !== 'super-admin')
                            <button type="button" 
                                    onclick="confirmDelete({{ $role->id }})"
                                    style="padding: 10px 20px; background-color: #ef4444; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                    onmouseover="this.style.backgroundColor='#dc2626'"
                                    onmouseout="this.style.backgroundColor='#ef4444'">
                                <span style="display: flex; align-items: center;">
                                    <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Rolü Sil
                                </span>
                            </button>
                            @else
                            <div></div>
                            @endif

                            <!-- Sağ taraf - İptal ve Güncelle butonları -->
                            <div style="display: flex; gap: 12px;">
                                <a href="{{ route('admin.roles.index') }}" 
                                   style="padding: 10px 24px; background-color: #f3f4f6; color: #374151; border-radius: 6px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                                   onmouseover="this.style.backgroundColor='#e5e7eb'"
                                   onmouseout="this.style.backgroundColor='#f3f4f6'">
                                    İptal
                                </a>
                                <button type="submit" 
                                        style="padding: 10px 24px; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.25);"
                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 8px rgba(59, 130, 246, 0.3)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(59, 130, 246, 0.25)'">
                                    <span style="display: flex; align-items: center;">
                                        <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Değişiklikleri Kaydet
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Hidden Delete Form -->
                    @if($role->name !== 'super-admin')
                    <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
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

        function confirmDelete(roleId) {
            if (confirm('Bu rolü silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
                document.getElementById('delete-form-' + roleId).submit();
            }
        }
    </script>
</x-app-layout>