<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kategori Yönetimi') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" 
               style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
               onmouseover="this.style.backgroundColor='#2563eb'" 
               onmouseout="this.style.backgroundColor='#3b82f6'">
                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Flash Messages -->
            @if (session('success'))
                <div style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Kategoriler Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($categories as $category)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all">
                    <!-- Kategori Başlık -->
                    <div style="background: linear-gradient(135deg, {{ $category->color ?? '#667eea' }} 0%, {{ $category->color ?? '#764ba2' }}dd 100%); padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                @if($category->icon)
                                <div style="width: 40px; height: 40px; background-color: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                    <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @switch($category->icon)
                                            @case('phone')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                @break
                                            @case('server')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                                @break
                                            @case('film')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                                                @break
                                            @case('palette')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                                @break
                                            @case('music')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                @break
                                            @case('cpu')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                                @break
                                            @default
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        @endswitch
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <h3 style="color: white; font-size: 18px; font-weight: 600;">
                                        {{ $category->slug }}
                                    </h3>
                                    @if($category->parent)
                                    <p style="color: rgba(255,255,255,0.8); font-size: 12px;">
                                        Alt kategori: {{ $category->parent->slug }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                @if($category->is_active)
                                    <span style="background-color: rgba(255,255,255,0.2); color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                        Aktif
                                    </span>
                                @endif
                                @if($category->show_in_home)
                                    <span style="background-color: rgba(255,255,255,0.2); color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                        Anasayfa
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <!-- Çeviriler -->
                        <div style="margin-bottom: 16px;">
                            <h5 style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280; margin-bottom: 8px;">
                                Çeviriler
                            </h5>
                            @foreach($languages as $language)
                                @php
                                    $translation = $category->translations->where('language_id', $language->id)->first();
                                @endphp
                                <div style="display: flex; align-items: center; margin-bottom: 4px;">
                                    <span style="font-size: 16px; margin-right: 8px;">{{ $language->flag }}</span>
                                    <span style="font-size: 13px; color: #374151;" class="dark:text-gray-300">
                                        {{ $translation ? $translation->name : '(Çeviri yok)' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- İstatistikler -->
                        <div style="display: flex; gap: 16px; padding: 12px 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;" class="dark:border-gray-700">
                            <div style="text-align: center; flex: 1;">
                                <p style="font-size: 18px; font-weight: 600; color: #3b82f6;">
                                    {{ $category->children()->count() }}
                                </p>
                                <p style="font-size: 11px; color: #6b7280;">Alt Kategori</p>
                            </div>
                            <div style="text-align: center; flex: 1;">
                                <p style="font-size: 18px; font-weight: 600; color: #10b981;">
                                    {{ $category->services()->count() }}
                                </p>
                                <p style="font-size: 11px; color: #6b7280;">Hizmet</p>
                            </div>
                            <div style="text-align: center; flex: 1;">
                                <p style="font-size: 18px; font-weight: 600; color: #f59e0b;">
                                    {{ $category->pages()->count() }}
                                </p>
                                <p style="font-size: 11px; color: #6b7280;">Sayfa</p>
                            </div>
                        </div>
                        
                        <!-- Aksiyonlar -->
                        <div style="display: flex; gap: 8px; margin-top: 16px;">
                            <a href="{{ route('admin.categories.show', $category) }}" 
                               style="flex: 1; text-align: center; padding: 8px; background-color: #f3f4f6; color: #374151; border-radius: 4px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                               onmouseover="this.style.backgroundColor='#e5e7eb'"
                               onmouseout="this.style.backgroundColor='#f3f4f6'">
                                Görüntüle
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               style="flex: 1; text-align: center; padding: 8px; background-color: #3b82f6; color: white; border-radius: 4px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                               onmouseover="this.style.backgroundColor='#2563eb'"
                               onmouseout="this.style.backgroundColor='#3b82f6'">
                                Düzenle
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="flex: 1;" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="width: 100%; padding: 8px; background-color: #ef4444; color: white; border: none; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                        onmouseover="this.style.backgroundColor='#dc2626'"
                                        onmouseout="this.style.backgroundColor='#ef4444'">
                                    Sil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Henüz kategori bulunmamaktadır.</p>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($categories->hasPages())
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
    
    <script>
        function confirmDelete(event) {
            if (!confirm('Bu kategoriyi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</x-app-layout>