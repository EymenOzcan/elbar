<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kullanıcı Düzenle') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" 
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Form Header with User Info -->
                <div style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); padding: 24px;">
                    <div style="display: flex; align-items: center;">
                        <div style="width: 60px; height: 60px; background-color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                            <span style="color: #3b82f6; font-size: 24px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h3 style="color: white; font-size: 18px; font-weight: 600;">
                                {{ $user->name }} düzenleniyor
                            </h3>
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 14px;">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;" class="dark:text-gray-300">
                                    <span style="color: #ef4444;">*</span> Ad Soyad
                                </label>
                                <div style="position: relative;">
                                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           required 
                                           style="width: 100%; padding: 12px 12px 12px 44px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; transition: all 0.3s;"
                                           onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
                                           class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                @error('name')
                                    <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;" class="dark:text-gray-300">
                                    <span style="color: #ef4444;">*</span> Email Adresi
                                </label>
                                <div style="position: relative;">
                                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           required 
                                           style="width: 100%; padding: 12px 12px 12px 44px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; transition: all 0.3s;"
                                           onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
                                           class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                @error('email')
                                    <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <div style="background-color: #fef3c7; border: 2px solid #fbbf24; border-radius: 8px; padding: 16px; margin-top: 24px;">
                            <div style="display: flex; align-items: center; margin-bottom: 12px;">
                                <svg style="width: 20px; height: 20px; color: #f59e0b; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span style="font-weight: 600; color: #92400e;">Şifre Değiştirme (İsteğe Bağlı)</span>
                            </div>
                            <p style="font-size: 12px; color: #78350f; margin-bottom: 16px;">
                                Şifreyi değiştirmek istemiyorsanız aşağıdaki alanları boş bırakın.
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- New Password -->
                                <div>
                                    <label for="password" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                                        Yeni Şifre
                                    </label>
                                    <div style="position: relative;">
                                        <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input type="password" 
                                               name="password" 
                                               id="password" 
                                               style="width: 100%; padding: 12px 12px 12px 44px; border: 2px solid #fbbf24; border-radius: 8px; font-size: 14px; transition: all 0.3s; background-color: white;"
                                               onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)'"
                                               onblur="this.style.borderColor='#fbbf24'; this.style.boxShadow='none'"
                                               placeholder="Boş bırakılabilir">
                                    </div>
                                    @error('password')
                                        <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm New Password -->
                                <div>
                                    <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                                        Yeni Şifre Tekrar
                                    </label>
                                    <div style="position: relative;">
                                        <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation" 
                                               style="width: 100%; padding: 12px 12px 12px 44px; border: 2px solid #fbbf24; border-radius: 8px; font-size: 14px; transition: all 0.3s; background-color: white;"
                                               onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)'"
                                               onblur="this.style.borderColor='#fbbf24'; this.style.boxShadow='none'"
                                               placeholder="Boş bırakılabilir">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Roles Section -->
                        <div style="border-top: 2px solid #e5e7eb; padding-top: 24px; margin-top: 32px;" class="dark:border-gray-700">
                            <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 16px;" class="dark:text-gray-300">
                                <span style="color: #ef4444;">*</span> Kullanıcı Rolleri
                            </label>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                                @foreach($roles as $role)
                                <label style="display: flex; align-items: center; padding: 16px; background-color: {{ in_array($role->name, $userRoles) ? '#dbeafe' : '#f9fafb' }}; border: 2px solid {{ in_array($role->name, $userRoles) ? '#3b82f6' : '#e5e7eb' }}; border-radius: 8px; cursor: pointer; transition: all 0.3s;"
                                       onmouseover="this.style.borderColor='#3b82f6'"
                                       onmouseout="this.style.borderColor='{{ in_array($role->name, $userRoles) ? '#3b82f6' : '#e5e7eb' }}'">
                                    <input type="checkbox" 
                                           name="roles[]" 
                                           value="{{ $role->name }}" 
                                           {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }}
                                           style="width: 20px; height: 20px; margin-right: 12px; cursor: pointer;">
                                    <div>
                                        <span style="font-weight: 600; color: #111827;">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                        <p style="font-size: 12px; color: #6b7280; margin-top: 2px;">
                                            @if($role->name == 'super-admin')
                                                Tüm yetkilere sahip
                                            @elseif($role->name == 'admin')
                                                Yönetici yetkileri
                                            @elseif($role->name == 'editor')
                                                İçerik düzenleme
                                            @elseif($role->name == 'viewer')
                                                Sadece görüntüleme
                                            @endif
                                        </p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('roles')
                                <p style="color: #ef4444; font-size: 12px; margin-top: 8px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 32px; padding-top: 24px; border-top: 2px solid #e5e7eb;" class="dark:border-gray-700">
                            <!-- Delete Button (Left Side) -->
                            @if($user->id !== auth()->id())
                            <button type="button" 
                                    onclick="confirmDelete({{ $user->id }})"
                                    style="padding: 12px 24px; background-color: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                    onmouseover="this.style.backgroundColor='#dc2626'"
                                    onmouseout="this.style.backgroundColor='#ef4444'">
                                <span style="display: flex; align-items: center;">
                                    <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Kullanıcıyı Sil
                                </span>
                            </button>
                            @else
                            <div></div>
                            @endif

                            <!-- Right Side Buttons -->
                            <div style="display: flex; gap: 12px;">
                                <a href="{{ route('admin.users.index') }}" 
                                   style="padding: 12px 24px; background-color: #f3f4f6; color: #374151; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                                   onmouseover="this.style.backgroundColor='#e5e7eb'"
                                   onmouseout="this.style.backgroundColor='#f3f4f6'">
                                    İptal
                                </a>
                                <button type="submit" 
                                        style="padding: 12px 32px; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.25);"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(59, 130, 246, 0.35)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(59, 130, 246, 0.25)'">
                                    <span style="display: flex; align-items: center;">
                                        <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Değişiklikleri Kaydet
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Hidden Delete Form -->
                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal Script -->
    <script>
        function confirmDelete(userId) {
            if (confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
</x-app-layout>