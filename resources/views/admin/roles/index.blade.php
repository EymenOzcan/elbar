<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rol Yönetimi') }}
            </h2>
            <a href="{{ route('admin.roles.create') }}" 
               style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s;"
               onmouseover="this.style.backgroundColor='#2563eb'" 
               onmouseout="this.style.backgroundColor='#3b82f6'">
                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Rol Ekle
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Üst Bilgi ve Buton -->
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Rol Listesi</h3>
                <a href="{{ route('admin.roles.create') }}" 
                   style="background-color: #10b981; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 500; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.3s;"
                   onmouseover="this.style.backgroundColor='#059669'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)'" 
                   onmouseout="this.style.backgroundColor='#10b981'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                    <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Yeni Rol Ekle
                </a>
            </div>
            
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

            <!-- Roller Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($roles as $role)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 16px;">
                        <h4 style="color: white; font-size: 18px; font-weight: 600; text-transform: capitalize;">
                            {{ $role->name }}
                        </h4>
                        <p style="color: rgba(255, 255, 255, 0.8); font-size: 12px; margin-top: 4px;">
                            {{ $role->users()->count() }} Kullanıcı
                        </p>
                    </div>
                    
                    <div class="p-4">
                        <!-- İzinler -->
                        <div style="margin-bottom: 16px;">
                            <h5 style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280; margin-bottom: 8px;">
                                İzinler ({{ $role->permissions->count() }})
                            </h5>
                            <div style="display: flex; flex-wrap: wrap; gap: 4px; max-height: 100px; overflow-y: auto;">
                                @forelse($role->permissions->take(5) as $permission)
                                    <span style="background-color: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span style="color: #9ca3af; font-style: italic; font-size: 12px;">İzin atanmamış</span>
                                @endforelse
                                @if($role->permissions->count() > 5)
                                    <span style="color: #6b7280; font-style: italic; font-size: 11px;">
                                        +{{ $role->permissions->count() - 5 }} daha...
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Aksiyonlar -->
                        <div style="display: flex; gap: 8px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                            <a href="{{ route('admin.roles.show', $role) }}" 
                               style="flex: 1; text-align: center; padding: 8px; background-color: #f3f4f6; color: #374151; border-radius: 4px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                               onmouseover="this.style.backgroundColor='#e5e7eb'"
                               onmouseout="this.style.backgroundColor='#f3f4f6'">
                                Görüntüle
                            </a>
                            <a href="{{ route('admin.roles.edit', $role) }}" 
                               style="flex: 1; text-align: center; padding: 8px; background-color: #3b82f6; color: white; border-radius: 4px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                               onmouseover="this.style.backgroundColor='#2563eb'"
                               onmouseout="this.style.backgroundColor='#3b82f6'">
                                Düzenle
                            </a>
                            @if($role->name !== 'super-admin')
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="flex: 1;" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="width: 100%; padding: 8px; background-color: #ef4444; color: white; border: none; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s;"
                                        onmouseover="this.style.backgroundColor='#dc2626'"
                                        onmouseout="this.style.backgroundColor='#ef4444'">
                                    Sil
                                </button>
                            </form>
                            @else
                            <div style="flex: 1; text-align: center; padding: 8px; background-color: #e5e7eb; color: #9ca3af; border-radius: 4px; font-size: 12px;">
                                Silinemez
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Henüz rol bulunmamaktadır.</p>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($roles->hasPages())
            <div class="mt-6">
                {{ $roles->links() }}
            </div>
            @endif
        </div>
    </div>
    
    <!-- Delete Confirmation Script -->
    <script>
        function confirmDelete(event) {
            if (!confirm('Bu rolü silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</x-app-layout>