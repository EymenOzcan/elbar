<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rol Detayları') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.roles.edit', $role) }}" 
                   style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
                   onmouseover="this.style.backgroundColor='#2563eb'" 
                   onmouseout="this.style.backgroundColor='#3b82f6'">
                    <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Düzenle
                </a>
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
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sol Kolon - Rol Kartı -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 24px; text-align: center;">
                            <div style="width: 100px; height: 100px; background-color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                                <svg style="width: 50px; height: 50px; color: #667eea;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 style="color: white; font-size: 24px; font-weight: bold; text-transform: capitalize;">
                                {{ $role->name }}
                            </h3>
                            @if($role->name === 'super-admin')
                            <div style="margin-top: 12px;">
                                <span style="background-color: rgba(255, 255, 255, 0.2); color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    SİSTEM ROLÜ
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <!-- İstatistikler -->
                            <div style="text-align: center; padding-bottom: 20px; border-bottom: 1px solid #e5e7eb;" class="dark:border-gray-700">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                    <div>
                                        <p style="font-size: 24px; font-weight: bold; color: #3b82f6;">
                                            {{ $role->users()->count() }}
                                        </p>
                                        <p style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                                            Kullanıcı
                                        </p>
                                    </div>
                                    <div>
                                        <p style="font-size: 24px; font-weight: bold; color: #10b981;">
                                            {{ $role->permissions->count() }}
                                        </p>
                                        <p style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                                            İzin
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tarihler -->
                            <div style="margin-top: 20px;">
                                <div style="margin-bottom: 12px;">
                                    <span style="font-size: 12px; color: #6b7280; display: block;">Oluşturulma Tarihi</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-gray-100">
                                        {{ $role->created_at->format('d F Y, H:i') }}
                                    </span>
                                </div>
                                <div>
                                    <span style="font-size: 12px; color: #6b7280; display: block;">Son Güncelleme</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-gray-100">
                                        {{ $role->updated_at->format('d F Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Aksiyon Butonları -->
                            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #e5e7eb;" class="dark:border-gray-700">
                                <a href="{{ route('admin.roles.edit', $role) }}" 
                                   style="display: block; width: 100%; padding: 12px; background-color: #3b82f6; color: white; text-align: center; border-radius: 6px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                                   onmouseover="this.style.backgroundColor='#2563eb'"
                                   onmouseout="this.style.backgroundColor='#3b82f6'">
                                    Rolü Düzenle
                                </a>
                                @if($role->name !== 'super-admin' && $role->users()->count() === 0)
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="margin-top: 8px;" onsubmit="return confirm('Bu rolü silmek istediğinizden emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="display: block; width: 100%; padding: 12px; background-color: #ef4444; color: white; text-align: center; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s;"
                                            onmouseover="this.style.backgroundColor='#dc2626'"
                                            onmouseout="this.style.backgroundColor='#ef4444'">
                                        Rolü Sil
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sağ Kolon - Detaylar -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- İzinler Kartı -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div style="padding: 20px; border-bottom: 2px solid #e5e7eb;" class="dark:border-gray-700">
                            <h4 style="font-size: 16px; font-weight: 700; color: #111827; display: flex; align-items: center;" class="dark:text-gray-100">
                                <svg style="width: 20px; height: 20px; margin-right: 8px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                Rol İzinleri ({{ $role->permissions->count() }} İzin)
                            </h4>
                        </div>
                        <div class="p-6">
                            @php
                                $groupedPermissions = $role->permissions->groupBy(function($permission) {
                                    $parts = explode('-', $permission->name);
                                    return $parts[0] ?? 'other';
                                });
                            @endphp
                            
                            @forelse($groupedPermissions as $group => $permissions)
                                <div style="margin-bottom: 24px;">
                                    <h5 style="font-size: 14px; font-weight: 600; text-transform: capitalize; color: #374151; margin-bottom: 12px; display: flex; align-items: center;" class="dark:text-gray-300">
                                        @if($group == 'user')
                                            <svg style="width: 18px; height: 18px; margin-right: 6px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            Kullanıcı Yönetimi
                                        @elseif($group == 'role')
                                            <svg style="width: 18px; height: 18px; margin-right: 6px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            Rol Yönetimi
                                        @elseif($group == 'content')
                                            <svg style="width: 18px; height: 18px; margin-right: 6px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            İçerik Yönetimi
                                        @elseif($group == 'settings')
                                            <svg style="width: 18px; height: 18px; margin-right: 6px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Ayarlar
                                        @elseif($group == 'reports')
                                            <svg style="width: 18px; height: 18px; margin-right: 6px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8m5-6h4"></path>
                                            </svg>
                                            Raporlar
                                        @else
                                            {{ ucfirst($group) }}
                                        @endif
                                    </h5>
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        @foreach($permissions as $permission)
                                            <span style="background-color: #dbeafe; color: #1e40af; padding: 8px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; border: 1px solid #93c5fd;">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <p style="color: #6b7280; font-style: italic; text-align: center; padding: 24px;">
                                    Bu role henüz hiçbir izin atanmamış.
                                </p>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Bu Role Sahip Kullanıcılar -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div style="padding: 20px; border-bottom: 2px solid #e5e7eb;" class="dark:border-gray-700">
                            <h4 style="font-size: 16px; font-weight: 700; color: #111827; display: flex; align-items: center;" class="dark:text-gray-100">
                                <svg style="width: 20px; height: 20px; margin-right: 8px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Bu Role Sahip Kullanıcılar ({{ $role->users()->count() }})
                            </h4>
                        </div>
                        <div class="p-6">
                            @if($role->users()->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <th style="text-align: left; padding: 8px; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">İsim</th>
                                                <th style="text-align: left; padding: 8px; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Email</th>
                                                <th style="text-align: left; padding: 8px; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Kayıt Tarihi</th>
                                                <th style="text-align: center; padding: 8px; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">İşlem</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($role->users()->latest()->take(10)->get() as $user)
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 12px 8px;">
                                                    <span style="font-weight: 600; color: #111827;" class="dark:text-gray-100">{{ $user->name }}</span>
                                                </td>
                                                <td style="padding: 12px 8px;">
                                                    <span style="color: #6b7280;">{{ $user->email }}</span>
                                                </td>
                                                <td style="padding: 12px 8px;">
                                                    <span style="color: #6b7280; font-size: 13px;">{{ $user->created_at->format('d.m.Y') }}</span>
                                                </td>
                                                <td style="padding: 12px 8px; text-align: center;">
                                                    <a href="{{ route('admin.users.show', $user) }}" 
                                                       style="color: #3b82f6; font-size: 13px; font-weight: 600; text-decoration: none;"
                                                       onmouseover="this.style.textDecoration='underline'"
                                                       onmouseout="this.style.textDecoration='none'">
                                                        Görüntüle
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($role->users()->count() > 10)
                                    <p style="text-align: center; color: #6b7280; font-size: 12px; margin-top: 12px; font-style: italic;">
                                        ve {{ $role->users()->count() - 10 }} kullanıcı daha...
                                    </p>
                                    @endif
                                </div>
                            @else
                                <p style="color: #6b7280; font-style: italic; text-align: center; padding: 24px;">
                                    Bu role sahip henüz hiçbir kullanıcı bulunmuyor.
                                </p>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>