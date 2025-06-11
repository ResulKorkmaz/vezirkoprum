<x-app-layout>
    <x-slot:header>
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bildirimler') }}
            </h2>
            <div class="flex space-x-2">
                @if($stats['unread'] > 0)
                    <button onclick="markAllAsRead()" 
                            class="px-4 py-2 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 transition-colors duration-200">
                        Tümünü Okundu İşaretle
                    </button>
                @endif
                <a href="{{ route('notifications.settings') }}" 
                   class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    Ayarlar
                </a>
            </div>
        </div>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2c3.31 0 6 2.69 6 6v3l2 3H4l2-3V8c0-3.31 2.69-6 6-6z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Toplam</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Okunmamış</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['unread'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Okunmuş</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['read'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bildirimler -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="border rounded-lg p-4 {{ !$notification->is_read ? 'bg-blue-50 border-blue-200' : 'border-gray-200' }}">
                                    <div class="flex items-start space-x-4">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0">
                                            @if($notification->fromUser)
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center">
                                                    @if($notification->fromUser->profile_photo_path)
                                                        <img src="{{ $notification->fromUser->profile_photo_url }}" 
                                                             alt="{{ $notification->fromUser->name }}" 
                                                             class="w-10 h-10 rounded-full object-cover">
                                                    @else
                                                        <span class="text-white text-sm font-semibold">{{ substr($notification->fromUser->name, 0, 1) }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2c3.31 0 6 2.69 6 6v3l2 3H4l2-3V8c0-3.31 2.69-6 6-6z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-semibold {{ !$notification->is_read ? 'font-bold' : '' }}">
                                                    {{ $notification->title }}
                                                    @if(!$notification->is_read)
                                                        <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Yeni</span>
                                                    @endif
                                                </h4>
                                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                            
                                            <div class="flex items-center space-x-2 mt-3">
                                                @if($notification->action_url)
                                                    <a href="{{ route('notifications.redirect', $notification) }}" 
                                                       class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                                        Görüntüle
                                                    </a>
                                                @endif
                                                
                                                @if(!$notification->is_read)
                                                    <button onclick="markAsRead({{ $notification->id }})" 
                                                            class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">
                                                        Okundu
                                                    </button>
                                                @endif
                                                
                                                <button onclick="deleteNotification({{ $notification->id }})" 
                                                        class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                                    Sil
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $notifications->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2c3.31 0 6 2.69 6 6v3l2 3H4l2-3V8c0-3.31 2.69-6 6-6z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Bildirim yok</h3>
                            <p class="mt-1 text-sm text-gray-500">Henüz hiç bildiriminiz bulunmuyor.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Bir hata oluştu');
                }
            });
        }
        
        function markAllAsRead() {
            if (!confirm('Tüm bildiriler okundu olarak işaretlenecek. Emin misiniz?')) {
                return;
            }
            
            fetch('/notifications/mark-all-read', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Bir hata oluştu');
                }
            });
        }
        
        function deleteNotification(notificationId) {
            if (!confirm('Bu bildirim silinecek. Emin misiniz?')) {
                return;
            }
            
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Bir hata oluştu');
                }
            });
        }
    </script>
</x-app-layout> 