<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kullanıcı Detayları') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
                   onmouseover="this.style.backgroundColor='#2563eb'" 
                   onmouseout="this.style.backgroundColor='#3b82f6'">
                    <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Düzenle
                </a>
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
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sol Kolon - Profil Kartı -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Avatar -->
                            <div class="text-center mb-6">
                                <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);">
                                    <span style="color: white; font-size: 48px; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->email }}</p>
                            </div>
                            
                            <!-- Durum -->
                            <div style="border-top: 1px solid #e5e7eb; padding-top: 16px;">
                                <div class="text-center">
                                    @if($user->email_verified_at)
                                        <span style="background-color: #d1fae5; color: #065f46; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center;">
                                            <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Email Doğrulanmış
                                        </span>
                                    @else
                                        <span style="background-color: #fef3c7; color: #92400e; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center;">
                                            <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Email Doğrulanmamış
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Tarihler -->
                            <div style="margin-top: 24px; padding: 16px; background-color: #f9fafb; border-radius: 8px;" class="dark:bg-gray-700">
                                <div style="margin-bottom: 12px;">
                                    <span style="font-size: 12px; color: #6b7280; display: block;">Kayıt Tarihi</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-gray-100">
                                        {{ $user->created_at->format('d F Y, H:i') }}
                                    </span>
                                </div>
                                <div>
                                    <span style="font-size: 12px; color: #6b7280; display: block;">Son Güncelleme</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-gray-100">
                                        {{ $user->updated_at->format('d F Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sağ Kolon - Detaylar -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Roller Kartı -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div style="padding: 20px; border-bottom: 2px solid #e5e7eb;" class="dark:border-gray-700">
                            <h4 style="font-size: 16px; font-weight: 700; color: #111827; display: flex; align-items: center;" class="dark:text-gray-100">
                                <svg style="width: 20px; height: 20px; margin-right: 8px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Atanan Roller
                            </h4>
                        </div>
                        <div class="p-6">
                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                @forelse($user->getRoleNames() as $role)
                                    <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 6px rgba(102, 126, 234, 0.25);">
                                        {{ ucfirst($role) }}
                                    </span>
                                @empty
                                    <span style="color: #6b7280; font-style: italic;">Henüz rol atanmamış</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- İzinler Kartı -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div style="padding: 20px; border-bottom: 2px solid #e5e7eb;" class="dark:border-gray-700">
                            <h4 style="font-size: 16px; font-weight: 700; color: #111827; display: flex; align-items: center;" class="dark:text-gray-100">
                                <svg style="width: 20px; height: 20px; margin-right: 8px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                Sahip Olduğu İzinler
                            </h4>
                        </div>
                        <div class="p-6">
                            @php
                                $permissions = $user->getAllPermissions()->groupBy(function($permission) {
                                    $parts = explode('-', $permission->name);
                                    return $parts[0] ?? 'other';
                                });
                            @endphp
                            
                            @forelse($permissions as $group => $items)
                                <div style="margin-bottom: 20px;">
                                    <h5 style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280; margin-bottom: 10px;">
                                        {{ ucfirst($group) }} İzinleri
                                    </h5>
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        @foreach($items as $permission)
                                            <span style="background-color: #dbeafe; color: #1e40af; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; border: 1px solid #93c5fd;">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <span style="color: #6b7280; font-style: italic;">Henüz izin atanmamış</span>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Hesap Bilgileri Kartı -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div style="padding: 20px; border-bottom: 2px solid #e5e7eb;" class="dark:border-gray-700">
                            <h4 style="font-size: 16px; font-weight: 700; color: #111827; display: flex; align-items: center;" class="dark:text-gray-100">
                                <svg style="width: 20px; height: 20px; margin-right: 8px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Hesap Detayları
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <span style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Kullanıcı ID</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-gray-100">#{{ $user->id }}</span>
                                </div>
                                <div>
                                    <span style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Email Adresi</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-gray-100">{{ $user->email }}</span>
                                </div>
                                <div>
                                    <span style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Email Doğrulama Tarihi</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-gray-100">
                                        {{ $user->email_verified_at ? $user->email_verified_at->format('d.m.Y H:i') : 'Doğrulanmamış' }}
                                    </span>
                                </div>
                                <div>
                                    <span style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Hesap Durumu</span>
                                    <span style="background-color: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                        Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>