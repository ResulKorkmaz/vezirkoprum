<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-red-600">Yasaklı Kullanıcılar</h1>
            
            <div class="bg-white p-6 rounded-lg shadow">
                @if($bannedUsers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">E-posta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Yasaklama Tarihi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sebep</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Yasaklayan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durum</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($bannedUsers as $banned)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $banned->email ?? 'E-posta yok' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $banned->banned_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ Str::limit($banned->ban_reason, 50) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $banned->bannedBy->name ?? 'Bilinmiyor' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ $banned->getRemainingTime() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.users.banned.show', $banned) }}" class="text-blue-600 hover:text-blue-900 mr-3">Detay</a>
                                            <form action="{{ route('admin.users.banned.unban', $banned) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-green-600 hover:text-green-900"
                                                        onclick="return confirm('Bu yasağı kaldırmak istediğinizden emin misiniz?')">
                                                    Yasağı Kaldır
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $bannedUsers->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Yasaklı kullanıcı bulunmamaktadır.</p>
                    </div>
                @endif
            </div>
            
            <div class="mt-6">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Kullanıcı Listesine Dön</a>
            </div>
        </div>
    </div>
</x-app-layout> 