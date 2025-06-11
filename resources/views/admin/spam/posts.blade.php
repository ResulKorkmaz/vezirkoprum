<x-admin-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Spam Post Yönetimi
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Spam olarak tespit edilen veya şüpheli postları yönetin
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.spam.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                       style="background: linear-gradient(to right, #B76E79, #A85D68);">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                        Geri Dön
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 mb-6">
            <div class="p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                        <select name="status" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>Tümü</option>
                            <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
                            <option value="suspicious" {{ request('status') === 'suspicious' ? 'selected' : '' }}>Şüpheli</option>
                            <option value="quarantined" {{ request('status') === 'quarantined' ? 'selected' : '' }}>Karantina</option>
                            <option value="clean" {{ request('status') === 'clean' ? 'selected' : '' }}>Temiz</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Post içeriğinde ara..." 
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full px-4 py-2 text-white rounded-lg hover:opacity-90 transition-all duration-200"
                                style="background: linear-gradient(to right, #10b981, #059669);">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrele
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Spam Postlar</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $posts->where('is_spam', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Şüpheli</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $posts->where('spam_status', 'suspicious')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Karantina</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $posts->where('spam_status', 'quarantined')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Temiz</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $posts->where('spam_status', 'clean')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 mb-6">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="selectAll" class="text-sm font-medium text-gray-700">Tümünü Seç</label>
                        <span id="selectedCount" class="text-sm text-gray-500">0 seçili</span>
                    </div>
                    <div class="flex space-x-2" id="bulkActions" style="display: none;">
                        <button onclick="bulkAction('approve')" 
                                class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors duration-200">
                            Onayla
                        </button>
                        <button onclick="bulkAction('spam')" 
                                class="px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors duration-200">
                            Spam
                        </button>
                        <button onclick="bulkAction('quarantine')" 
                                class="px-3 py-1 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition-colors duration-200">
                            Karantina
                        </button>
                        <button onclick="bulkAction('delete')" 
                                class="px-3 py-1 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            Sil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Postlar ({{ $posts->total() }})</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kullanıcı
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İçerik
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Spam Skoru
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarih
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($posts as $post)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $post->user->name ?? 'Silinmiş Kullanıcı' }}</div>
                                            <div class="text-sm text-gray-500">{{ $post->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs">
                                        {{ Str::limit($post->content, 100) }}
                                    </div>
                                    @if($post->image)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                Resim
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($post->is_spam)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Spam
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $post->spam_status === 'clean' ? 'bg-green-100 text-green-800' : 
                                               ($post->spam_status === 'suspicious' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($post->spam_status === 'quarantined' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ $post->spam_status === 'clean' ? 'Temiz' : 
                                               ($post->spam_status === 'suspicious' ? 'Şüpheli' : 
                                               ($post->spam_status === 'quarantined' ? 'Karantina' : 'Bekliyor')) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($post->spam_score !== null)
                                        <div class="flex items-center">
                                            <div class="text-sm text-gray-900">{{ $post->spam_score }}/100</div>
                                            <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full {{ $post->spam_score > 70 ? 'bg-red-500' : ($post->spam_score > 40 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                                     style="width: {{ $post->spam_score }}%"></div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $post->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        @if(!$post->is_spam && $post->spam_status !== 'clean')
                                            <button onclick="updatePostStatus({{ $post->id }}, 'approve')"
                                                    class="text-green-600 hover:text-green-900 transition-colors duration-200" 
                                                    title="Onayla">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        @endif
                                        
                                        @if(!$post->is_spam)
                                            <button onclick="updatePostStatus({{ $post->id }}, 'spam')"
                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200" 
                                                    title="Spam olarak işaretle">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                            </button>
                                        @endif
                                        
                                        @if($post->spam_status !== 'quarantined')
                                            <button onclick="updatePostStatus({{ $post->id }}, 'quarantine')"
                                                    class="text-orange-600 hover:text-orange-900 transition-colors duration-200" 
                                                    title="Karantinaya al">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                </svg>
                                            </button>
                                        @endif
                                        
                                        <button onclick="deletePost({{ $post->id }})"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200" 
                                                title="Sil">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Post bulunamadı</h3>
                                    <p class="mt-1 text-sm text-gray-500">Seçilen kriterlere uygun post bulunamadı.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
    // Checkbox handling
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.post-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('post-checkbox')) {
            updateSelectedCount();
        }
    });

    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.post-checkbox:checked');
        const count = checkboxes.length;
        document.getElementById('selectedCount').textContent = count + ' seçili';
        document.getElementById('bulkActions').style.display = count > 0 ? 'flex' : 'none';
    }

    // Individual post actions
    function updatePostStatus(postId, action) {
        const actionMap = {
            'approve': 'approve',
            'spam': 'spam', 
            'quarantine': 'quarantine'
        };

        const endpoint = `/admin/spam/posts/${postId}/${actionMap[action]}`;
        
        fetch(endpoint, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Hata: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu');
        });
    }

    // Delete post function
    function deletePost(postId) {
        if (confirm('Bu postu kalıcı olarak silmek istediğinizden emin misiniz?')) {
            fetch(`/admin/spam/posts/${postId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Hata: ' + (data.message || 'Post silinemedi'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu');
            });
        }
    }

    // Bulk actions
    function bulkAction(action) {
        const checkboxes = document.querySelectorAll('.post-checkbox:checked');
        const postIds = Array.from(checkboxes).map(cb => cb.value);
        
        if (postIds.length === 0) {
            alert('Lütfen en az bir post seçin');
            return;
        }

        const actionText = {
            'approve': 'onaylamak',
            'spam': 'spam olarak işaretlemek',
            'quarantine': 'karantinaya almak',
            'delete': 'silmek'
        };

        if (confirm(`${postIds.length} postu ${actionText[action]} istediğinizden emin misiniz?`)) {
            fetch('/admin/spam/posts/bulk', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: action,
                    post_ids: postIds
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Hata: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu');
            });
        }
    }
    </script>
</x-admin-layout> 