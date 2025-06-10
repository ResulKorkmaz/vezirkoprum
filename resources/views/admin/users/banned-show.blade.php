<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-red-600">Yasaklı Kullanıcı Detayları</h1>
            
            <div class="bg-red-50 border border-red-200 p-6 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-red-700">E-posta</label>
                        <p class="mt-1 text-sm text-red-900">{{ $bannedUser->email ?? 'E-posta yok' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-red-700">Yasaklama Tarihi</label>
                        <p class="mt-1 text-sm text-red-900">{{ $bannedUser->banned_at->format('d.m.Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-red-700">Yasaklayan Admin</label>
                        <p class="mt-1 text-sm text-red-900">{{ $bannedUser->bannedBy->name ?? 'Bilinmiyor' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-red-700">Yasak Türü</label>
                        <p class="mt-1 text-sm text-red-900">{{ $bannedUser->ban_type === 'permanent' ? 'Kalıcı' : 'Geçici' }}</p>
                    </div>
                    
                    @if($bannedUser->ban_expires_at)
                        <div>
                            <label class="block text-sm font-medium text-red-700">Yasak Bitiş Tarihi</label>
                            <p class="mt-1 text-sm text-red-900">{{ $bannedUser->ban_expires_at->format('d.m.Y H:i') }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-red-700">Durum</label>
                        <p class="mt-1 text-sm text-red-900">{{ $bannedUser->getRemainingTime() }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-red-700">Yasaklama Sebebi</label>
                    <p class="mt-1 text-sm text-red-900">{{ $bannedUser->ban_reason }}</p>
                </div>
                
                @if($bannedUser->original_user_data)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-red-700">Orijinal Kullanıcı Bilgileri</label>
                        <div class="mt-2 bg-red-100 p-4 rounded">
                            <p><strong>Ad:</strong> {{ $bannedUser->original_user_data['name'] ?? 'Bilinmiyor' }}</p>
                            <p><strong>Kullanıcı ID:</strong> {{ $bannedUser->original_user_data['unique_user_id'] ?? 'Bilinmiyor' }}</p>
                            <p><strong>Şehir:</strong> {{ $bannedUser->original_user_data['current_city'] ?? 'Bilinmiyor' }}</p>
                            <p><strong>Kayıt Tarihi:</strong> {{ isset($bannedUser->original_user_data['created_at']) ? \Carbon\Carbon::parse($bannedUser->original_user_data['created_at'])->format('d.m.Y H:i') : 'Bilinmiyor' }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="mt-8 flex space-x-4">
                    <form action="{{ route('admin.users.banned.unban', $bannedUser) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded"
                                onclick="return confirm('Bu yasağı kaldırmak istediğinizden emin misiniz?')">
                            Yasağı Kaldır
                        </button>
                    </form>
                    <a href="{{ route('admin.users.banned') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Geri Dön</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 