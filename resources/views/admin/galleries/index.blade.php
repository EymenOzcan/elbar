<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Galeri Yönetimi
            </h2>
            <a href="{{ route('admin.galleries.create') }}"
               style="background-color: #10b981; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
               onmouseover="this.style.backgroundColor='#059669'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)'"
               onmouseout="this.style.backgroundColor='#10b981'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Yeni Galeri
            </a>
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
                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Filtre Butonları -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.galleries.index', ['type' => 'all']) }}"
                       style="padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; {{ $type === 'all' ? 'background-color: #6366f1; color: white;' : 'background-color: #f3f4f6; color: #374151;' }}"
                       onmouseover="if('{{ $type }}' !== 'all') this.style.backgroundColor='#e5e7eb'"
                       onmouseout="if('{{ $type }}' !== 'all') this.style.backgroundColor='#f3f4f6'">
                        📋 Tümü
                    </a>
                    <a href="{{ route('admin.galleries.index', ['type' => 'photo']) }}"
                       style="padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; {{ $type === 'photo' ? 'background-color: #6366f1; color: white;' : 'background-color: #f3f4f6; color: #374151;' }}"
                       onmouseover="if('{{ $type }}' !== 'photo') this.style.backgroundColor='#e5e7eb'"
                       onmouseout="if('{{ $type }}' !== 'photo') this.style.backgroundColor='#f3f4f6'">
                        📷 Fotoğraf Galerileri
                    </a>
                    <a href="{{ route('admin.galleries.index', ['type' => 'video']) }}"
                       style="padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; {{ $type === 'video' ? 'background-color: #6366f1; color: white;' : 'background-color: #f3f4f6; color: #374151;' }}"
                       onmouseover="if('{{ $type }}' !== 'video') this.style.backgroundColor='#e5e7eb'"
                       onmouseout="if('{{ $type }}' !== 'video') this.style.backgroundColor='#f3f4f6'">
                        🎥 Video Galerileri
                    </a>
                </div>
            </div>

            @if($galleries->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Henüz galeri yok</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">İlk galerinizi oluşturarak başlayın</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.galleries.create') }}"
                               style="background-color: #10b981; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center;"
                               onmouseover="this.style.backgroundColor='#059669'"
                               onmouseout="this.style.backgroundColor='#10b981'">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                İlk Galeriyi Oluştur
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($galleries as $gallery)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <!-- Galeri Kapak Resmi -->
                            
                            <!-- Galeri Kapak Resmi -->
<div class="relative h-48 bg-gray-200 dark:bg-gray-700">
    @php
        $firstMedia = $gallery->mediaFiles->where('is_active', true)->first();
    @endphp
    
    @if($firstMedia)
        @if($gallery->type === 'photo')
            <img src="{{ $firstMedia->getThumbnailUrl() }}" 
                 alt="{{ $gallery->translations->first()->title ?? $gallery->slug }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="relative w-full h-full">
                @if($firstMedia->thumbnail)
                    <img src="{{ $firstMedia->getThumbnailUrl() }}" 
                         alt="{{ $gallery->translations->first()->title ?? $gallery->slug }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
                        <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        @endif
    @else
        <div class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
            @if($gallery->type === 'photo')
                <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            @else
                <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                </svg>
            @endif
        </div>
    @endif

    <!-- Tip Badge (Sol Üst) -->
    <div style="position: absolute; top: 8px; left: 8px;">
        <div style="background: {{ $gallery->type === 'photo' ? 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)' : 'linear-gradient(135deg, #a855f7 0%, #9333ea 100%)' }}; color: white; padding: 3px 8px; border-radius: 5px; font-size: 9px; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.2); display: inline-flex; align-items: center; white-space: nowrap;">
            @if($gallery->type === 'photo')
                <svg style="width: 10px; height: 10px; margin-right: 3px;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                </svg>
                <span>FOTO</span>
            @else
                <svg style="width: 10px; height: 10px; margin-right: 3px;" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                </svg>
                <span>VİDEO</span>
            @endif
        </div>
    </div>

    <!-- Durum Badge (Sağ Üst) -->
    <div style="position: absolute; top: 8px; right: 8px;">
        <div style="background: {{ $gallery->is_active ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' }}; color: white; padding: 3px 8px; border-radius: 5px; font-size: 9px; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.2); display: inline-flex; align-items: center; white-space: nowrap;">
            @if($gallery->is_active)
                <svg style="width: 10px; height: 10px; margin-right: 3px;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>AKTİF</span>
            @else
                <svg style="width: 10px; height: 10px; margin-right: 3px;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>PASİF</span>
            @endif
        </div>
    </div>

    <!-- Medya Sayısı Badge (Sağ Alt) -->
    <div style="position: absolute; top: 8px; left: 70px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 10px; border-radius: 6px; font-size: 13px; font-weight: 800; box-shadow: 0 2px 6px rgba(0,0,0,0.3); display: inline-flex; align-items: center;">
            <svg style="width: 14px; height: 14px; margin-right: 4px;" fill="currentColor" viewBox="0 0 20 20">
                @if($gallery->type === 'photo')
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                @else
                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                @endif
            </svg>
            <span>{{ $gallery->mediaFiles->count() }}</span>
        </div>
    </div>
</div>

                            <!-- Galeri Bilgileri -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $gallery->translations->first()->title ?? $gallery->slug }}
                                </h3>
                                
                                @if($gallery->translations->first() && $gallery->translations->first()->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                        {{ Str::limit($gallery->translations->first()->description, 80) }}
                                    </p>
                                @endif

                                <!-- Kategoriler -->
                                @if($gallery->categories->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @foreach($gallery->categories->take(3) as $category)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                {{ $category->translations->first()->name ?? $category->slug }}
                                            </span>
                                        @endforeach
                                        @if($gallery->categories->count() > 3)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                +{{ $gallery->categories->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Aksiyon Butonları -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.galleries.show', $gallery) }}"
                                           style="background-color: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.2s;"
                                           onmouseover="this.style.backgroundColor='#2563eb'"
                                           onmouseout="this.style.backgroundColor='#3b82f6'">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Görüntüle
                                        </a>
                                        <a href="{{ route('admin.galleries.edit', $gallery) }}"
                                           style="background-color: #f59e0b; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.2s;"
                                           onmouseover="this.style.backgroundColor='#d97706'"
                                           onmouseout="this.style.backgroundColor='#f59e0b'">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Düzenle
                                        </a>
                                    </div>
                                    
                                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" 
                                          onsubmit="return confirm('Bu galeriyi ve içindeki tüm medya dosyalarını silmek istediğinizden emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                style="background-color: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; border: none; cursor: pointer; display: inline-flex; align-items: center; transition: all 0.2s;"
                                                onmouseover="this.style.backgroundColor='#dc2626'"
                                                onmouseout="this.style.backgroundColor='#ef4444'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>