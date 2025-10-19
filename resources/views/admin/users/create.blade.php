<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Yeni Kullanıcı Ekle') }}
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
            <!-- Bilgi Kartı -->
            <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                <div style="display: flex; align-items: flex-start;">
                    <svg style="width: 20px; height: 20px; color: #3b82f6; margin-right: 12px; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p style="color: #1e40af; font-size: 14px;">
                            Yeni kullanıcı oluşturmak için aşağıdaki formu doldurun. 
                            <span style="color: #dc2626;">*</span> işaretli alanlar zorunludur.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <!-- Kullanıcı Bilgileri Başlık -->
                        <div style="margin-bottom: 24px;">
                            <h3 style="font-size: 18px; font-weight: 600; color: #111827; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb;" class="dark:text-gray-100 dark:border-gray-700">
                                Kullanıcı Bilgileri
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span style="color: #dc2626;">*</span> Ad Soyad
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}" 
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                       required 
                                       placeholder="Örn: Ahmet Yılmaz">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span style="color: #dc2626;">*</span> Email Adresi
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}" 
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                       required 
                                       placeholder="ornek@email.com">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span style="color: #dc2626;">*</span> Şifre
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                       required 
                                       placeholder="En az 8 karakter">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span style="color: #dc2626;">*</span> Şifre Tekrar
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                       required 
                                       placeholder="Şifreyi tekrar girin">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Roller Bölümü -->
                        <div style="margin-top: 32px; padding-top: 24px; border-top: 2px solid #e5e7eb;" class="dark:border-gray-700">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                                <span style="color: #dc2626;">*</span> Kullanıcı Rolleri
                            </label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                @foreach($roles as $role)
                                <div style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 12px; transition: all 0.3s;" 
                                     class="hover:border-indigo-500 dark:border-gray-600 dark:hover:border-indigo-500">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="checkbox" 
                                               name="roles[]" 
                                               value="{{ $role->name }}" 
                                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800 mt-1"
                                               {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                @switch($role->name)
                                                    @case('super-admin')
                                                        Tüm yetkilere sahip
                                                        @break
                                                    @case('admin')
                                                        Yönetici yetkileri
                                                        @break
                                                    @case('editor')
                                                        İçerik düzenleme
                                                        @break
                                                    @case('viewer')
                                                        Sadece görüntüleme
                                                        @break
                                                    @default
                                                        {{ $role->name }}
                                                @endswitch
                                            </p>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                        </div>

                        <!-- Butonlar -->
                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.users.index') }}" 
                               style="padding: 10px 24px; background-color: #f3f4f6; color: #374151; border-radius: 6px; font-weight: 600; text-decoration: none; margin-right: 12px; transition: all 0.3s;"
                               onmouseover="this.style.backgroundColor='#e5e7eb'"
                               onmouseout="this.style.backgroundColor='#f3f4f6'">
                                İptal
                            </a>
                            <button type="submit" 
                                    style="padding: 10px 24px; background-color: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                    onmouseover="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(-1px)'"
                                    onmouseout="this.style.backgroundColor='#3b82f6'; this.style.transform='translateY(0)'">
                                <span style="display: flex; align-items: center;">
                                    <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Kullanıcı Oluştur
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>