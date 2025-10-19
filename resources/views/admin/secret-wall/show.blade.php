<x-app-layout>
 <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Kod Detayları') }}
        </h2>
         <a href="{{ route('admin.qr-system.index') }}" 
           style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #6366f1; color: white; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;"
           onmouseover="this.style.backgroundColor='#4f46e5'"
           onmouseout="this.style.backgroundColor='#6366f1'">
            <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            QR Listesine Dön
        </a>
    </div>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Başarı/Hata Mesajları -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div style="display: grid; grid-template-columns: 350px 1fr; gap: 24px;">
                
                <!-- Sol Taraf - Profil Kartı -->
                <div>
                    <!-- Profil Kartı -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <!-- Cover Image with Gradient -->
                        <div style="position: relative; height: 180px; background: {{ $entry->is_active ? 'linear-gradient(135deg, #4ade80 0%, #10b981 100%);' : ($entry->trashed() ? 'linear-gradient(135deg, #f87171 0%, #dc2626 100%);' : 'linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);') }}">
                            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.1);"></div>
                            
                            <!-- Status Badge -->
                            <div style="position: absolute; top: 16px; right: 16px;">
                                <span style="display: inline-flex; align-items: center; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; box-shadow: 0 4px 15px rgba(0,0,0,0.2); backdrop-filter: blur(10px);
                                    {{ $entry->is_active ? 'background: rgba(74, 222, 128, 0.95); color: white;' : ($entry->trashed() ? 'background: rgba(248, 113, 113, 0.95); color: white;' : 'background: rgba(251, 191, 36, 0.95); color: white;') }}">
                                    @if($entry->trashed())
                                        🗑️ Silinmiş
                                    @elseif($entry->is_active)
                                        ✓ Onaylı
                                    @else
                                        ⏳ Onay Bekliyor
                                    @endif
                                </span>
                            </div>

                            <!-- Profile Image -->
                            <div style="position: absolute; bottom: -60px; left: 50%; transform: translateX(-50%);">
                                @if($entry->hasImage())
                                    <img src="{{ $entry->getImageData() }}" 
                                         alt="{{ $entry->isimsoyisim }}" 
                                         style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 6px solid white; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                                @else
                                    <div style="width: 120px; height: 120px; border-radius: 50%; background: {{ $entry->getAvatarColor() }}; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 48px; border: 6px solid white; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                                        {{ $entry->getInitials() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div style="padding: 70px 24px 24px;">
                            <div style="text-align: center; margin-bottom: 24px;">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $entry->isimsoyisim }}
                                </h2>
                                <div style="display: flex; align-items: center; justify-content: center; gap: 16px; margin-top: 12px;">
                                    <div style="text-align: center;">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $entry->getActiveSocialLinksCount() }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Sosyal Medya</div>
                                    </div>
                                    @if($entry->hasImage())
                                    <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                                    <div style="text-align: center;">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $entry->getImageSize() }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">KB</div>
                                    </div>
                                    @endif
                                    <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                                    <div style="text-align: center;">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $entry->created_at->diffForHumans(null, true) }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Önce</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarih Bilgileri -->
                            <div style="background: #f9fafb; border-radius: 12px; padding: 16px; margin-bottom: 20px;" class="dark:bg-gray-900/50">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Oluşturulma
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $entry->created_at->format('d.m.Y H:i') }}
                                    </span>
                                </div>
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                        </svg>
                                        Güncellenme
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $entry->updated_at->format('d.m.Y H:i') }}
                                    </span>
                                </div>
                            </div>

                           
                            <!-- Action Buttons -->
                            <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: 24px;">
                                @if(!$entry->trashed())
                                    <!-- Çöpe Taşı (Sol - Kırmızı - Sadece İkon) -->
                                    <form action="{{ route('admin.secret-wall.destroy', $entry) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Bu kaydı çöp kutusuna taşımak istediğinize emin misiniz?')"
                                                title="Çöpe Taşı - Bu kaydı çöp kutusuna taşır"
                                                style="width: 80px; height: 80px; border-radius: 16px; border: none; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;"
                                                onmouseover="this.style.transform='translateY(-5px) scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(239, 68, 68, 0.5)'"
                                                onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3)'">
                                            <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>

                                    @if($entry->is_active)
                                        <!-- Onayı İptal (Sağ - Turuncu - Sadece İkon) -->
                                        <form action="{{ route('admin.secret-wall.reject', $entry) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Onayı iptal etmek istediğinize emin misiniz?')"
                                                    title="Onayı İptal Et - Bu kaydın onayını kaldırır"
                                                    style="width: 80px; height: 80px; border-radius: 16px; border: none; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;"
                                                    onmouseover="this.style.transform='translateY(-5px) scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(245, 158, 11, 0.5)'"
                                                    onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(245, 158, 11, 0.3)'">
                                                <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <!-- Onayla (Sağ - Yeşil - Sadece İkon) -->
                                        <form action="{{ route('admin.secret-wall.approve', $entry) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    title="Onayla - Bu kaydı onaylar ve yayınlar"
                                                    style="width: 80px; height: 80px; border-radius: 16px; border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;"
                                                    onmouseover="this.style.transform='translateY(-5px) scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(16, 185, 129, 0.5)'"
                                                    onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(16, 185, 129, 0.3)'">
                                                <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <!-- Geri Yükle (Tam Genişlik - Yeşil - Sadece İkon) -->
                                    <form action="{{ route('admin.secret-wall.restore', $entry->id) }}" method="POST" style="flex: 1; display: flex; justify-content: center;">
                                        @csrf
                                        <button type="submit" 
                                                title="Geri Yükle - Bu kaydı çöp kutusundan geri yükler"
                                                style="width: 80px; height: 80px; border-radius: 16px; border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;"
                                                onmouseover="this.style.transform='translateY(-5px) scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(16, 185, 129, 0.5)'"
                                                onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(16, 185, 129, 0.3)'">
                                            <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            


                        </div>
                    </div>
                </div>

                <!-- Sağ Taraf - Sosyal Medya Linkleri -->
                <div>
                    <!-- Sosyal Medya Kartı -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            Sosyal Medya Hesapları
                        </h3>

                        <div style="display: grid; gap: 16px;">
                            @php
                                $socialLinks = [
                                    ['name' => 'Facebook', 'icon' => 'fab fa-facebook', 'color' => '#1877F2', 'bg' => '#eff6ff', 'link' => $entry->facebook_link],
                                    ['name' => 'Instagram', 'icon' => 'fab fa-instagram', 'color' => '#E4405F', 'bg' => '#fdf2f8', 'link' => $entry->instagram_link],
                                    ['name' => 'LinkedIn', 'icon' => 'fab fa-linkedin', 'color' => '#0A66C2', 'bg' => '#eff6ff', 'link' => $entry->linkedin_link],
                                    ['name' => 'TikTok', 'icon' => 'fab fa-tiktok', 'color' => '#000000', 'bg' => '#f3f4f6', 'link' => $entry->tiktok_link],
                                    ['name' => 'WhatsApp', 'icon' => 'fab fa-whatsapp', 'color' => '#25D366', 'bg' => '#f0fdf4', 'link' => $entry->whatsapp_link],
                                    ['name' => 'X (Twitter)', 'icon' => 'fab fa-x-twitter', 'color' => '#000000', 'bg' => '#f3f4f6', 'link' => $entry->x_link],
                                    ['name' => 'YouTube', 'icon' => 'fab fa-youtube', 'color' => '#FF0000', 'bg' => '#fef2f2', 'link' => $entry->youtube_link],
                                ];
                            @endphp

                            @foreach($socialLinks as $social)
                                @if($social['link'])
                                <div style="background: {{ $social['bg'] }}; border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: space-between; transition: all 0.3s; border: 2px solid transparent;"
                                     onmouseover="this.style.borderColor='{{ $social['color'] }}'; this.style.transform='translateX(5px)'"
                                     onmouseout="this.style.borderColor='transparent'; this.style.transform='translateX(0)'">
                                    <div style="display: flex; align-items: center; flex: 1; min-width: 0;">
                                        <div style="width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; margin-right: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                            <i class="{{ $social['icon'] }}" style="font-size: 24px; color: {{ $social['color'] }};"></i>
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $social['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $social['link'] }}</div>
                                        </div>
                                    </div>
                                    <a href="{{ $social['link'] }}" 
                                       target="_blank"
                                       style="margin-left: 16px; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; color: white; text-decoration: none; background: {{ $social['color'] }}; transition: all 0.3s; white-space: nowrap;"
                                       onmouseover="this.style.transform='scale(1.05)'"
                                       onmouseout="this.style.transform='scale(1)'">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        Ziyaret Et
                                    </a>
                                </div>
                                @endif
                            @endforeach

                            @if(!$entry->facebook_link && !$entry->instagram_link && !$entry->linkedin_link && !$entry->tiktok_link && !$entry->whatsapp_link && !$entry->x_link && !$entry->youtube_link)
                            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 12px;" class="dark:bg-gray-900/50">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Sosyal medya hesabı eklenmemiş</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</x-app-layout>