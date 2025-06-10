<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl mb-8 border border-rose-100">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    Kullanıcı Yönetimi
                                </span>
                            </h1>
                            <p class="text-gray-600">Tüm kullanıcıları görüntüleyin ve yönetin</p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.users.banned') }}" 
                               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                </svg>
                                Yasaklı Kullanıcılar
                            </a>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Dashboard'a Dön
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl mb-8 border border-rose-100">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Arama -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       placeholder="Ad, e-posta veya ID...">
                            </div>

                            <!-- Durum -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                                <select name="status" id="status" 
                                        class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500">
                                    <option value="">Tüm Durumlar</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Askıda</option>
                                    <option value="admin" {{ request('status') === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <!-- Şehir -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Şehir</label>
                                <select name="city" id="city" 
                                        class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500">
                                    <option value="">Tüm Şehirler</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Butonlar -->
                            <div class="flex items-end space-x-2">
                                <button type="submit" 
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    Filtrele
                                </button>
                                <a href="{{ route('admin.users.index') }}" 
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    Temizle
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users List -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-rose-100">
                <div class="p-6">
                    @if($users->count() > 0)
                        <!-- Toplu İşlemler -->
                        <div class="mb-6 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <button type="button" id="selectAll" class="text-sm text-blue-600 hover:text-blue-800">Tümünü Seç</button>
                                <button type="button" id="deselectAll" class="text-sm text-gray-600 hover:text-gray-800">Seçimi Temizle</button>
                                <span id="selectedCount" class="text-sm text-gray-500">0 kullanıcı seçildi</span>
                            </div>
                            <button type="button" id="bulkDeleteBtn" class="bg-red-600 text-white px-4 py-2 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Seçilenleri Sil
                            </button>
                        </div>

                        <form id="bulkDeleteForm" action="{{ route('admin.users.bulk-delete') }}" method="GET" style="display: none;">
                            <!-- Hidden inputs will be added here by JavaScript -->
                        </form>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="selectAllCheckbox" class="rounded border-gray-300">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kullanıcı</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İletişim</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kayıt</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if(!$user->is_admin)
                                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox rounded border-gray-300">
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                         src="{{ $user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                                         alt="{{ $user->name }}"
                                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjE1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSA4NUMyNSA3MCAzNSA2MCA1MCA2MEM2NSA2MCA3NSA3MCA3NSA4NSIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjMiIGZpbGw9Im5vbmUiLz4KPC9zdmc+'">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                        <div class="text-sm text-gray-500">#{{ $user->unique_user_id }}</div>
                                                        @if($user->is_admin)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                Admin
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->display_phone }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->current_city ?? '-' }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->current_district ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->is_suspended)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $user->suspension_status }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at->format('d.m.Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="text-blue-600 hover:text-blue-900 mr-3">Detay</a>
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3">Düzenle</a>
                                                @if(!$user->is_admin)
                                                    @if($user->is_suspended)
                                                        <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Askıyı Kaldır</button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('admin.users.suspend', $user) }}" 
                                                           class="text-orange-600 hover:text-orange-900 mr-3">Askıya Al</a>
                                                    @endif
                                                    <a href="{{ route('admin.users.delete', $user) }}" 
                                                       class="text-red-600 hover:text-red-900">Sil</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Kullanıcı bulunamadı</h3>
                            <p class="mt-1 text-sm text-gray-500">Arama kriterlerinize uygun kullanıcı bulunmamaktadır.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const selectAllBtn = document.getElementById('selectAll');
            const deselectAllBtn = document.getElementById('deselectAll');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                const count = checkedBoxes.length;
                selectedCountSpan.textContent = count + ' kullanıcı seçildi';
                bulkDeleteBtn.disabled = count === 0;
                
                // Tümünü seç checkbox'ını güncelle
                if (count === 0) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = false;
                } else if (count === userCheckboxes.length) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.indeterminate = true;
                }
            }

            // Checkbox değişikliklerini dinle
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Tümünü seç checkbox
            selectAllCheckbox.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            // Tümünü seç butonu
            selectAllBtn.addEventListener('click', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                updateSelectedCount();
            });

            // Seçimi temizle butonu
            deselectAllBtn.addEventListener('click', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateSelectedCount();
            });

            // Toplu silme butonu
            bulkDeleteBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                if (checkedBoxes.length === 0) return;

                // Form'a seçili kullanıcı ID'lerini ekle
                bulkDeleteForm.innerHTML = '';
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_ids[]';
                    input.value = checkbox.value;
                    bulkDeleteForm.appendChild(input);
                });

                // Form'u gönder
                bulkDeleteForm.submit();
            });

            // İlk yüklemede sayıyı güncelle
            updateSelectedCount();
        });
    </script>
</x-app-layout> 