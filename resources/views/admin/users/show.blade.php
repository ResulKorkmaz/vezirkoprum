<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8">Kullanıcı Detayları: {{ $user->name }}</h1>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <p><strong>Kullanıcı ID:</strong> {{ $user->unique_user_id }}</p>
                <p><strong>E-posta:</strong> {{ $user->email }}</p>
                <p><strong>Telefon:</strong> {{ $user->display_phone }}</p>
                <p><strong>Şehir:</strong> {{ $user->current_city ?? '-' }}</p>
                <p><strong>Durum:</strong> {{ $user->suspension_status }}</p>
                <p><strong>Kayıt Tarihi:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
                
                @if($user->profession)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Meslek</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->display_profession }}</dd>
                    </div>
                @endif
                
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Düzenle
                    </a>
                    
                    <a href="{{ route('admin.users.reset-password', $user) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Şifre Sıfırla
                    </a>
                    
                    @if(!$user->is_admin)
                        @if($user->is_suspended)
                            <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                    Askıyı Kaldır
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.users.suspend', $user) }}" 
                               class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                                Askıya Al
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.users.ban', $user) }}" 
                           class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                            Kalıcı Yasakla
                        </a>
                        
                        <a href="{{ route('admin.users.delete', $user) }}" 
                           class="bg-red-800 text-white px-4 py-2 rounded-lg hover:bg-red-900">
                            Kullanıcıyı Sil
                        </a>
                    @endif
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Geri Dön
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 