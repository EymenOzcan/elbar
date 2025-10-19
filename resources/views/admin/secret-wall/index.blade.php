<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Sır Duvarı Kayıtları
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Kullanıcı kayıtlarını yönetin ve onaylayın
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.secret-wall.statistics') }}" 
                   style="background-color: #8b5cf6; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center;"
                   onmouseover="this.style.backgroundColor='#7c3aed'"
                   onmouseout="this.style.backgroundColor='#8b5cf6'">
                    📊 İstatistikler
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Başarı Mesajı -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded">
                <div class="flex">
                    <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('warning'))
            <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded">
                <div class="flex">
                    <svg class="h-6 w-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300">{{ session('warning') }}</p>
                </div>
            </div>
            @endif

          
            <!-- İstatistik Kartları - Modern Yan Yana -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Genel İstatistikler
                        </h3>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;">
                        
                        <!-- Toplam Kayıt -->
                        <div style="position: relative; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); transition: all 0.3s;"
                            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(102, 126, 234, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(102, 126, 234, 0.3)';">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p style="font-size: 32px; font-weight: 700; color: white; margin-bottom: 4px;">{{ $stats['total'] }}</p>
                            <p style="font-size: 13px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Toplam Kayıt</p>
                            <p style="font-size: 11px; color: rgba(255, 255, 255, 0.7); margin-top: 8px;">📈 Tüm zamanlar</p>
                        </div>

                        <!-- Onay Bekliyor -->
                        <div style="position: relative; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3); transition: all 0.3s;"
                            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(245, 87, 108, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(245, 87, 108, 0.3)';">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                @if($stats['pending'] > 0)
                                <span style="background: rgba(255, 255, 255, 0.3); color: white; padding: 4px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; animation: pulse 2s infinite;">
                                    URGENT
                                </span>
                                @endif
                            </div>
                            <p style="font-size: 32px; font-weight: 700; color: white; margin-bottom: 4px;">{{ $stats['pending'] }}</p>
                            <p style="font-size: 13px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Onay Bekliyor</p>
                            <p style="font-size: 11px; color: rgba(255, 255, 255, 0.7); margin-top: 8px;">⏰ İşlem gerekli</p>
                        </div>

                        <!-- Onaylı -->
                        <div style="position: relative; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3); transition: all 0.3s;"
                            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(67, 233, 123, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(67, 233, 123, 0.3)';">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p style="font-size: 32px; font-weight: 700; color: white; margin-bottom: 4px;">{{ $stats['approved'] }}</p>
                            <p style="font-size: 13px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Onaylı</p>
                            <p style="font-size: 11px; color: rgba(255, 255, 255, 0.7); margin-top: 8px;">✅ Yayında</p>
                        </div>

                        <!-- Bugün -->
                        <div style="position: relative; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3); transition: all 0.3s;"
                            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(250, 112, 154, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(250, 112, 154, 0.3)';">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p style="font-size: 32px; font-weight: 700; color: white; margin-bottom: 4px;">{{ $stats['today'] }}</p>
                            <p style="font-size: 13px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Bugün</p>
                            <p style="font-size: 11px; color: rgba(255, 255, 255, 0.7); margin-top: 8px;">📅 Son 24 saat</p>
                        </div>

                        <!-- Silinmiş -->
                        <div style="position: relative; background: linear-gradient(135deg, #ff6b6b 0%, #c44569 100%); border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3); transition: all 0.3s;"
                            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(255, 107, 107, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(255, 107, 107, 0.3)';">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </div>
                            </div>
                            <p style="font-size: 32px; font-weight: 700; color: white; margin-bottom: 4px;">{{ $stats['deleted'] }}</p>
                            <p style="font-size: 13px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Silinmiş</p>
                            <p style="font-size: 11px; color: rgba(255, 255, 255, 0.7); margin-top: 8px;">🗑️ Çöp kutusu</p>
                        </div>

                    </div>
                </div>

                <style>
                @keyframes pulse {
                    0%, 100% { opacity: 1; }
                    50% { opacity: 0.5; }
                }
                </style>




            <!-- Filtre ve Arama -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    
                    <!-- Filtreler -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.secret-wall.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            Tümü ({{ $stats['total'] }})
                        </a>
                        <a href="{{ route('admin.secret-wall.index', ['status' => 'pending']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            Onay Bekleyenler ({{ $stats['pending'] }})
                        </a>
                        <a href="{{ route('admin.secret-wall.index', ['status' => 'approved']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'approved' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            Onaylananlar ({{ $stats['approved'] }})
                        </a>
                        <a href="{{ route('admin.secret-wall.index', ['status' => 'deleted']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'deleted' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            🗑️ Çöp Kutusu ({{ $stats['deleted'] }})
                        </a>
                    </div>

                    <!-- Arama -->
                    <form method="GET" action="{{ route('admin.secret-wall.index') }}" class="flex gap-2">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="İsim ara..." 
                               class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                        <button type="submit" 
                                style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; border: none;"
                                onmouseover="this.style.backgroundColor='#2563eb'"
                                onmouseout="this.style.backgroundColor='#3b82f6'">
                            🔍 Ara
                        </button>
                    </form>

                </div>
            </div>

           <!-- Kayıt Listesi -->
                <!-- Kayıt Listesi -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
    @forelse($entries as $entry)
    <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border-2 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1"
         style="width: 200px; {{ $entry->is_active ? 'border-color: #4ade80;' : ($entry->trashed() ? 'border-color: #f87171;' : 'border-color: #fbbf24;') }}">
        
        <!-- Profil Resmi - Sol Üst -->
        <div style="position: absolute; top: 12px; left: 12px; z-index: 10;">
            @if($entry->hasImage())
                <img src="{{ $entry->getImageData() }}" 
                     alt="{{ $entry->isimsoyisim }}" 
                     style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.3);"
                     loading="lazy">
            @else
                <div style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 32px; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.3); background: {{ $entry->getAvatarColor() }};">
                    {{ $entry->getInitials() }}
                </div>
            @endif
        </div>

        <!-- Kum Saati - Sağ Üst -->
        <div style="position: absolute; top: 12px; right: 12px; z-index: 10;">
            <div style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.2); backdrop-filter: blur(10px);
                {{ $entry->is_active ? 'background: rgba(74, 222, 128, 0.9);' : ($entry->trashed() ? 'background: rgba(248, 113, 113, 0.9);' : 'background: rgba(251, 191, 36, 0.9); animation: pulse 2s infinite;') }}">
                <span style="font-size: 20px;">
                    @if($entry->trashed())
                        🗑️
                    @elseif($entry->is_active)
                        ✓
                    @else
                        ⏳
                    @endif
                </span>
            </div>
        </div>

        <!-- Gradient Header -->
        <div style="position: relative; height: 120px; background: {{ $entry->is_active ? 'linear-gradient(135deg, #4ade80 0%, #10b981 100%);' : ($entry->trashed() ? 'linear-gradient(135deg, #f87171 0%, #dc2626 100%);' : 'linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);') }}">
            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.1);"></div>
        </div>

        <!-- Content -->
        <div style="padding: 12px;">
            
            <!-- Name & Info -->
            <div style="text-align: center; margin-bottom: 12px;">
                <h3 style="font-weight: 700; font-size: 14px; color: #111827; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="dark:text-gray-100">
                    {{ $entry->isimsoyisim }}
                </h3>
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 11px; color: #6b7280;">
                    <span style="display: flex; align-items: center;">
                        <svg style="width: 12px; height: 12px; margin-right: 2px;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                        </svg>
                        {{ $entry->getActiveSocialLinksCount() }}
                    </span>
                    @if($entry->hasImage())
                    <span style="display: flex; align-items: center;">
                        <svg style="width: 12px; height: 12px; margin-right: 2px;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $entry->getImageSize() }}KB
                    </span>
                    @endif
                </div>
                <div style="font-size: 10px; color: #9ca3af; margin-top: 4px;">
                    {{ $entry->created_at->diffForHumans(null, true) }}
                </div>
            </div>

            <!-- Social Media Icons -->
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 4px; margin-bottom: 12px;">
                @if($entry->facebook_link)
                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #eff6ff; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" 
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-facebook" style="color: #2563eb; font-size: 11px;"></i>
                    </div>
                @endif
                @if($entry->instagram_link)
                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #fdf2f8; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" 
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-instagram" style="color: #ec4899; font-size: 11px;"></i>
                    </div>
                @endif
                @if($entry->linkedin_link)
                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #eff6ff; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" 
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-linkedin" style="color: #1d4ed8; font-size: 11px;"></i>
                    </div>
                @endif
                @if($entry->tiktok_link)
                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" 
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-tiktok" style="color: #111827; font-size: 11px;"></i>
                    </div>
                @endif
                @if($entry->whatsapp_link)
                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #f0fdf4; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" 
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-whatsapp" style="color: #16a34a; font-size: 11px;"></i>
                    </div>
                @endif
                @if($entry->x_link)
                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" 
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-x-twitter" style="color: #111827; font-size: 11px;"></i>
                    </div>
                @endif
                @if($entry->youtube_link)
                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #fef2f2; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" 
                         onmouseover="this.style.transform='scale(1.1)'" 
                         onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-youtube" style="color: #dc2626; font-size: 11px;"></i>
                    </div>
                @endif
            </div>

            <!-- Divider -->
            <div style="border-top: 1px solid #e5e7eb; margin-bottom: 12px;"></div>

            <!-- Action Buttons - Yan Yana -->
            <div style="display: flex; gap: 6px;">
                <!-- View Button -->
                <a href="{{ route('admin.secret-wall.show', $entry) }}" 
                   style="flex: 1; display: block; text-align: center; border-radius: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: white; text-decoration: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: all 0.3s; cursor: pointer;"
                   onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.4)'"
                   onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                    <span style="display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 12px; height: 12px; margin-right: 3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Detay
                    </span>
                </a>

                @if($entry->trashed())
                    <!-- Restore Button -->
                    <form action="{{ route('admin.secret-wall.restore', $entry->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" 
                                style="width: 100%; border-radius: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: white; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); transition: all 0.3s; cursor: pointer;"
                                onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 4px 12px rgba(67, 233, 123, 0.4)'"
                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                            <span style="display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 12px; height: 12px; margin-right: 3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                </svg>
                                Geri Al
                            </span>
                        </button>
                    </form>
                @elseif(!$entry->is_active)
                    <!-- Approve Button -->
                    <form action="{{ route('admin.secret-wall.approve', $entry) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" 
                                style="width: 100%; border-radius: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: white; border: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); transition: all 0.3s; cursor: pointer;"
                                onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 4px 12px rgba(67, 233, 123, 0.4)'"
                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                            <span style="display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 12px; height: 12px; margin-right: 3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Onayla
                            </span>
                        </button>
                    </form>
                @else
                    <!-- Reject Button -->
                    <form action="{{ route('admin.secret-wall.reject', $entry) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" 
                                style="width: 100%; border-radius: 8px; padding: 6px 0; font-size: 11px; font-weight: 600; color: white; border: none; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); transition: all 0.3s; cursor: pointer;"
                                onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 4px 12px rgba(250, 112, 154, 0.4)'"
                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                            <span style="display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 12px; height: 12px; margin-right: 3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                İptal
                            </span>
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Kayıt Bulunamadı</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            @if(request('search'))
                "{{ request('search') }}" araması için sonuç yok.
            @else
                Henüz kayıt eklenmemiş.
            @endif
        </p>
    </div>
    @endforelse
</div>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
</style>
          

            <!-- Pagination -->
            @if($entries->hasPages())
            <div class="mt-6">
                {{ $entries->links() }}
            </div>
            @endif

        </div>
    </div>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</x-app-layout>