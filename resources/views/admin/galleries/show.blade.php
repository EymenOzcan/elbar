<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                    @if($gallery->type === 'photo')
                        📷
                    @else
                        🎥
                    @endif
                    {{ $gallery->translations->first()->title ?? $gallery->slug }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $gallery->mediaFiles->count() }} medya dosyası • 
                    {{ $gallery->type === 'photo' ? 'Fotoğraf Galerisi' : 'Video Galerisi' }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.galleries.edit', $gallery) }}"
                   style="background-color: #f59e0b; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s;"
                   onmouseover="this.style.backgroundColor='#d97706'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)'"
                   onmouseout="this.style.backgroundColor='#f59e0b'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Düzenle
                </a>
                <a href="{{ route('admin.galleries.index') }}"
                   style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s;"
                   onmouseover="this.style.backgroundColor='#4b5563'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)'"
                   onmouseout="this.style.backgroundColor='#6b7280'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fade-in">
                <div class="flex">
                    <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Grid: 3-9 Oran -->
        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- Sol Sidebar - %25 (3/12) -->
            <div class="w-full lg:w-1/4">
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 sticky top-6">
                        <div class="p-6">
                            <!-- Galeri İkonu -->
                            <div class="flex justify-center mb-4">
                                <div style="background: {{ $gallery->type === 'photo' ? 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)' : 'linear-gradient(135deg, #a855f7 0%, #9333ea 100%)' }}; padding: 16px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                    @if($gallery->type === 'photo')
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Durum Badge -->
                            <div class="flex justify-center mb-4">
                                <span style="background: {{ $gallery->is_active ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' }}; color: white; padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; box-shadow: 0 2px 6px rgba(0,0,0,0.2); display: inline-flex; align-items: center;">
                                    @if($gallery->is_active)
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        AKTİF
                                    @else
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        PASİF
                                    @endif
                                </span>
                            </div>

                            <!-- Başlık -->
                            <h3 class="text-center text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $gallery->translations->first()->title ?? $gallery->slug }}
                            </h3>

                            <!-- Açıklama -->
                            @if($gallery->translations->first() && $gallery->translations->first()->description)
                                <p class="text-center text-xs text-gray-600 dark:text-gray-400 mb-4 px-2">
                                    {{ Str::limit($gallery->translations->first()->description, 100) }}
                                </p>
                            @endif

                            <!-- İstatistikler -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 12px; border-radius: 12px; text-align: center;">
                                    <div class="text-2xl font-bold text-white">
                                        {{ $gallery->mediaFiles->count() }}
                                    </div>
                                    <div class="text-xs text-white opacity-90 mt-1">
                                        Medya
                                    </div>
                                </div>
                                <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); padding: 12px; border-radius: 12px; text-align: center;">
                                    <div class="text-2xl font-bold text-white">
                                        {{ $gallery->categories->count() }}
                                    </div>
                                    <div class="text-xs text-white opacity-90 mt-1">
                                        Kategori
                                    </div>
                                </div>
                            </div>

                            <!-- Detaylar -->
                            <div class="space-y-2 border-t border-gray-200 dark:border-gray-700 pt-4 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Slug:</span>
                                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ Str::limit($gallery->slug, 15) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Sıra:</span>
                                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $gallery->sort_order }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Oluşturulma:</span>
                                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $gallery->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>

                            <!-- Kategoriler -->
                            @if($gallery->categories->isNotEmpty())
                                <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Kategoriler</h4>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($gallery->categories as $category)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300">
                                                {{ Str::limit($category->translations->first()->name ?? $category->slug, 12) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Diller -->
                            <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Çeviriler</h4>
                                <div class="space-y-1">
                                    @foreach($gallery->translations as $translation)
                                        <div class="flex items-center text-xs">
                                            <span class="text-xl mr-2">{{ $translation->language->flag }}</span>
                                            <span class="text-gray-600 dark:text-gray-400">{{ $translation->language->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sağ Alan - Medya Yükleme ve Galeri (3/4) -->
                <div class="lg:col-span-9 space-y-6">
                    
                    <!-- Medya Yükleme Bölümü -->
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 10px; border-radius: 12px; margin-right: 12px;">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Medya Yükleme</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $gallery->type === 'photo' ? 'Fotoğrafları sürükleyip bırakın' : 'Video dosyalarını yükleyin' }}
                                    </p>
                                </div>
                            </div>

                          <!-- Dropzone Alanı -->
                            <form action="{{ route('admin.galleries.upload.chunk', $gallery) }}" 
                                class="dropzone border-3 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-12 text-center hover:border-indigo-500 dark:hover:border-indigo-500 transition-all duration-300 cursor-pointer bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800"
                                id="mediaDropzone">
                                @csrf
                            </form>
                            <!-- Upload Progress -->
                            <div id="upload-progress" class="mt-6 hidden">
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-blue-800 dark:text-blue-300">Yükleniyor...</span>
                                        <span id="progress-percentage" class="text-sm font-bold text-blue-600 dark:text-blue-400">0%</span>
                                    </div>
                                    <div class="w-full bg-blue-200 dark:bg-blue-900 rounded-full h-3 overflow-hidden">
                                        <div id="progress-bar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <p id="progress-text" class="text-xs text-blue-600 dark:text-blue-400 mt-2">Hazırlanıyor...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medya Galerisi -->
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 10px; border-radius: 12px; margin-right: 12px;">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Galeri İçeriği</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $gallery->mediaFiles->count() }} dosya
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($gallery->mediaFiles->isEmpty())
                                <div class="text-center py-16">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Henüz medya dosyası yok</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                        Yukarıdaki yükleme alanını kullanarak {{ $gallery->type === 'photo' ? 'fotoğraf' : 'video' }} ekleyin
                                    </p>
                                </div>
                            @else
                                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="media-grid">
                                  @foreach($gallery->mediaFiles as $media)
                                        <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 transition-all shadow-sm hover:shadow-xl">
                                            <!-- Medya Preview -->
                                            <div class="aspect-square bg-gray-200 dark:bg-gray-700 relative">
                                                @if($media->type === 'image')
                                                    <img src="{{ $media->getUrl() }}" 
                                                        alt="{{ $media->file_name }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-800">
                                                        @if($media->thumbnail)
                                                            <img src="{{ $media->getThumbnailUrl() }}" class="w-full h-full object-cover">
                                                        @else
                                                            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                @endif
                                                
                                                <!-- BUTONLAR - RESMİN ORTASINDA -->
                                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; gap: 8px; z-index: 10;">
                                                    <button type="button" onclick="viewMedia('{{ $media->getUrl() }}', '{{ $media->type }}')"
                                                            style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; width: 40px; height: 40px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3);"
                                                            title="Görüntüle">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </button>
                                                    <button type="button" onclick="deleteMedia({{ $media->id }})"
                                                            style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3);"
                                                            title="Sil">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Medya Bilgisi -->
                                            <div class="p-3 bg-white dark:bg-gray-800">
                                                <p class="text-xs font-semibold text-gray-900 dark:text-gray-100 truncate mb-2">
                                                    {{ $media->translations->first()->title ?? $media->file_name }}
                                                </p>
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="text-gray-500 dark:text-gray-400">{{ $media->getFormattedSize() }}</span>
                                                    @if($media->width && $media->height)
                                                        <span class="text-gray-500 dark:text-gray-400">{{ $media->width }}×{{ $media->height }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Media Viewer Modal -->
        <!-- Media Viewer Modal -->
<div id="media-modal" class="hidden fixed inset-0 z-50" style="background-color: rgba(0,0,0,0.95);">
    <!-- Kapat Butonu - SABİT ÜST SAĞDA -->
    <button onclick="closeModal()" 
            style="position: fixed; 
                   top: 30px; 
                   right: 30px; 
                   z-index: 9999; 
                   background: linear-gradient(135deg, #ef4444, #dc2626); 
                   color: white; 
                   width: 56px; 
                   height: 56px; 
                   border-radius: 50%; 
                   border: 3px solid white; 
                   cursor: pointer; 
                   display: flex; 
                   align-items: center; 
                   justify-content: center; 
                   box-shadow: 0 4px 20px rgba(0,0,0,0.5);
                   transition: transform 0.2s;"
            onmouseover="this.style.transform='scale(1.1)'"
            onmouseout="this.style.transform='scale(1)'">
        <svg style="width: 28px; height: 28px; stroke-width: 3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    
    <!-- Modal İçerik -->
    <div onclick="closeModal()" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div id="modal-content" onclick="event.stopPropagation()" style="max-width: 90vw; max-height: 90vh;"></div>
    </div>
</div>

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const galleryId = {{ $gallery->id }};
        const galleryType = '{{ $gallery->type }}';

        Dropzone.autoDiscover = false;

        const myDropzone = new Dropzone("#mediaDropzone", {
            url: "{{ route('admin.galleries.upload.chunk', $gallery) }}",
            paramName: "file",
            maxFilesize: galleryType === 'photo' ? 50 : 10240,
            chunking: true,
            forceChunking: true,
            chunkSize: 2000000,
            parallelChunkUploads: false,
            retryChunks: true,
            retryChunksLimit: 3,
            acceptedFiles: galleryType === 'photo' ? 
                'image/jpeg,image/jpg,image/png,image/gif,image/webp,image/tiff' : 
                'video/mp4,video/webm,video/avi,video/quicktime,video/x-matroska,video/x-msvideo',
            uploadMultiple: false,
            parallelUploads: 1,
            addRemoveLinks: true,
            timeout: 0,
            dictDefaultMessage: `
                <div style="padding: 20px;">
                    <svg style="width: 64px; height: 64px; margin: 0 auto 16px; display: block; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px;">Dosyaları buraya sürükleyin</p>
                    <p style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">veya tıklayarak seçin</p>
                    <p style="font-size: 12px; color: #9ca3af;">
                        ${galleryType === 'photo' 
                            ? 'Fotoğraf: JPG, PNG, GIF, WEBP • Maks: 50MB' 
                            : 'Video: MP4, WEBM, AVI, MOV • Maks: 10GB'}
                    </p>
                </div>
            `,
            dictRemoveFile: "Kaldır",
            dictCancelUpload: "İptal",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            
            init: function() {
                this.on("addedfile", function(file) {
                    document.getElementById('upload-progress').classList.remove('hidden');
                    document.getElementById('progress-text').textContent = 'Yükleniyor: ' + file.name;
                });

                this.on("uploadprogress", function(file, progress) {
                    document.getElementById('progress-bar').style.width = progress + '%';
                    document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append('dzfilename', file.name);
                    formData.append('dztotalfilesize', file.size);
                });

                this.on("success", function(file, response) {
                    console.log('Upload success:', response);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                });

                this.on("error", function(file, error) {
                    alert('Yükleme hatası: ' + (error.message || error));
                    this.removeFile(file);
                });

                this.on("queuecomplete", function() {
                    document.getElementById('progress-text').textContent = 'Tamamlandı!';
                });
            }
        });

        function viewMedia(url, type) {
            const modal = document.getElementById('media-modal');
            const modalContent = document.getElementById('modal-content');
            
            if (type === 'image') {
                modalContent.innerHTML = `<img src="${url}" class="max-w-full max-h-screen rounded-lg shadow-2xl">`;
            } else {
                modalContent.innerHTML = `
                    <video controls class="max-w-full max-h-screen rounded-lg shadow-2xl">
                        <source src="${url}" type="video/mp4">
                        Tarayıcınız video etiketini desteklemiyor.
                    </video>
                `;
            }
            
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('media-modal').classList.add('hidden');
        }

        function deleteMedia(mediaId) {
            if (confirm('⚠️ Bu medya dosyasını silmek istediğinizden emin misiniz?')) {
                fetch(`/admin/galleries/{{ $gallery->id }}/media/${mediaId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Hata: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Bir hata oluştu: ' + error);
                });
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-app-layout>