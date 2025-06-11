<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sayfa Başlığı -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                            <svg class="w-8 h-8 text-rose-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Tüm Paylaşımlar
                        </h1>
                        <p class="text-gray-600 mt-2">Hemşehrilerimizin tüm paylaşımlarını görüntüleyin</p>
                    </div>
                    
                    <!-- Ana Sayfaya Dön Butonu -->
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Ana Sayfa
                    </a>
                </div>
                
                <!-- İstatistik -->
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Toplam {{ $posts->total() }} paylaşım
                </div>
            </div>

            @if($posts->count() > 0)
                <!-- Paylaşımlar Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($posts as $post)
                        <div id="post-{{ $post->id }}" class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100 hover:border-rose-200 relative flex flex-col h-full">
                            <!-- Kullanıcı Bilgisi -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover border-2 border-rose-200" 
                                         src="{{ $post->user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                         alt="{{ $post->user->name }}"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjE1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSA4NUMyNSA3MCAzNSA2MCA1MCA2MEM2NSA2MCA3NSA3MCA3NSA4NSIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjMiIGZpbGw9Im5vbmUiLz4KPC9zdmc+'">
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">
                                            {{ $post->user->getDisplayNameWithIdForUser(auth()->user()) }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $post->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- 3 Nokta Menü -->
                                @auth
                                    <div class="relative">
                                        <button onclick="togglePostMenu({{ $post->id }})" class="p-2 rounded-full transition-all duration-200 transform hover:scale-110 hover:shadow-md" style="color: #B76E79; background-color: rgba(183, 110, 121, 0.1);" onmouseover="this.style.backgroundColor='rgba(183, 110, 121, 0.2)'" onmouseout="this.style.backgroundColor='rgba(183, 110, 121, 0.1)'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"></path>
                                            </svg>
                                        </button>
                                        <div id="post-menu-{{ $post->id }}" class="hidden absolute right-0 top-8 bg-white rounded-lg shadow-lg border border-gray-200 py-1 min-w-32 z-10">
                                            @if(auth()->id() === $post->user_id)
                                                <!-- Kendi Postları İçin -->
                                                <button onclick="openEditModal({{ $post->id }})" class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Düzenle
                                                </button>
                                                <button onclick="openDeleteModal({{ $post->id }})" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Sil
                                                </button>
                                            @else
                                                <!-- Başkalarının Postları İçin -->
                                                <button onclick="openReportModal('post', {{ $post->id }})" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    </svg>
                                                    Postu Bildir
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endauth
                            </div>

                            <!-- Paylaşım İçeriği -->
                            <div class="text-gray-700 text-sm leading-relaxed mb-4 flex-1">
                                <p id="post-content-{{ $post->id }}">
                                    {{ Str::limit($post->content, 120) }}
                                </p>
                                @if(strlen($post->content) > 120)
                                    <button onclick="togglePostContent({{ $post->id }}, {{ json_encode($post->content) }})" 
                                            id="post-toggle-{{ $post->id }}"
                                            class="mt-2 text-sm font-semibold transition-colors duration-200 hover:underline" 
                                            style="color: #B76E79;"
                                            onmouseover="this.style.color='#A85D68'" 
                                            onmouseout="this.style.color='#B76E79'">
                                        Devamını Gör
                                    </button>
                                @endif
                            </div>

                                                <!-- Beğeni ve Yorum Butonları -->
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            @auth
                            <!-- Beğeni Butonu -->
                            <button onclick="toggleLike({{ $post->id }})" 
                                    id="like-btn-{{ $post->id }}"
                                    class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-gray-50"
                                    data-liked="{{ $post->isLikedByUser(auth()->id()) ? 'true' : 'false' }}">
                                <svg id="like-icon-{{ $post->id }}" class="w-5 h-5 transition-colors duration-200 {{ $post->isLikedByUser(auth()->id()) ? 'text-red-500 fill-current' : 'text-gray-400' }}" 
                                     fill="{{ $post->isLikedByUser(auth()->id()) ? 'currentColor' : 'none' }}" 
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span id="like-count-{{ $post->id }}" class="text-sm font-medium text-gray-600">
                                    {{ $post->like_count ?: 'Beğen' }}
                                </span>
                            </button>
                            @else
                            <!-- Giriş Yapmamış Kullanıcılar İçin Beğeni -->
                            <div class="flex items-center space-x-2 px-3 py-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600">
                                    {{ $post->like_count ?: '0' }}
                                </span>
                            </div>
                            @endauth
                            
                            <!-- Yorum Butonu - Herkese Açık -->
                            <button onclick="openCommentsModal({{ $post->id }})" 
                                    class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-all duration-200 hover:bg-gray-50">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 713 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                </svg>
                                <span id="comment-count-{{ $post->id }}" class="text-sm font-medium text-gray-600">
                                    {{ $post->comment_count ? $post->comment_count . ' Yorum' : 'Yorumları Gör' }}
                                </span>
                            </button>
                        </div>
                    </div>

                            <!-- Alt Bilgiler -->
                            <div class="flex items-center justify-between pt-4 {{ auth()->check() ? 'border-t border-gray-100' : '' }} mt-auto">
                                <div class="flex items-center space-x-3">
                                    <!-- Tarih -->
                                    <p class="text-xs text-gray-400">
                                        {{ $post->created_at->format('d.m.Y H:i') }}
                                    </p>
                                </div>
                                
                                <!-- Profil Linki -->
                                <a href="{{ route('profile.show', $post->user) }}" 
                                   class="text-xs text-rose-600 hover:text-rose-700 font-medium hover:underline">
                                    Profili Gör
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $posts->links() }}
                </div>
            @else
                <!-- Boş Durum -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Henüz Paylaşım Yok</h3>
                    <p class="text-gray-500 mb-6">İlk paylaşımı yapan siz olun!</p>
                    
                    @auth
                        <button onclick="openPostModal()" 
                                class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Paylaşım Yap
                        </button>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Giriş Yap
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <!-- Report Modal Component -->
    <x-report-modal />
    
    <!-- Comments Modal Component -->
    <x-comments-modal />

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Paylaşımı Düzenle</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="editForm" onsubmit="submitEdit(event)">
                <input type="hidden" id="editPostId" name="postId" value="">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">İçerik</label>
                    <textarea id="editContent" name="content" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-rose-500 resize-none"
                              placeholder="Paylaşımınızı yazın..." maxlength="500" required></textarea>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-gray-500">En az 10, en fazla 500 karakter</span>
                        <span id="editCharCount" class="text-xs text-gray-400">0/500</span>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                        İptal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg font-medium transition-colors">
                        Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Paylaşımı Sil</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h4 class="text-center text-gray-900 font-medium mb-2">Paylaşımı silmek istediğinizden emin misiniz?</h4>
                <p class="text-center text-gray-600 text-sm">Bu işlem geri alınamaz.</p>
            </div>
            
            <form id="deleteForm" onsubmit="submitDelete(event)">
                <input type="hidden" id="deletePostId" name="postId" value="">
                
                <div class="flex space-x-3">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                        İptal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg font-medium transition-colors">
                        Sil
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        
        // Global post ID for reporting
        let reportPostId = null;
        
        // Post menu functions
        function togglePostMenu(postId) {
            // Diğer menüleri kapat
            document.querySelectorAll('[id^="post-menu-"]').forEach(menu => {
                if (menu.id !== `post-menu-${postId}`) {
                    menu.classList.add('hidden');
                }
            });
            
            const menu = document.getElementById(`post-menu-${postId}`);
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        // Dışarı tıklandığında menüleri kapat
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick*="togglePostMenu"]') && !event.target.closest('[id^="post-menu-"]')) {
                document.querySelectorAll('[id^="post-menu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // Report modal functions are now handled by the component

        // Edit modal functions
        function openEditModal(postId) {
            // Post içeriğini getir
            fetch(`/posts/${postId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('editPostId').value = postId;
                        document.getElementById('editContent').value = data.post.content;
                        updateEditCharCount();
                        document.getElementById('editModal').classList.remove('hidden');
                        document.getElementById('editModal').classList.add('flex');
                        document.body.style.overflow = 'hidden';
                        
                        // Menüyü kapat
                        document.querySelectorAll('[id^="post-menu-"]').forEach(menu => {
                            menu.classList.add('hidden');
                        });
                        
                        // Focus textarea
                        document.getElementById('editContent').focus();
                    } else {
                        showModernToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModernToast('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
            document.getElementById('editForm').reset();
        }

        function submitEdit(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const postId = formData.get('postId');
            
            const token = csrfToken;
            fetch(`/posts/${postId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    content: formData.get('content')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    showModernToast(data.message, 'success');
                    // Sayfayı yenile
                    location.reload();
                } else {
                    showModernToast(data.message || 'Bir hata oluştu.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModernToast('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            });
        }

        // Delete modal functions
        function openDeleteModal(postId) {
            document.getElementById('deletePostId').value = postId;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            // Menüyü kapat
            document.querySelectorAll('[id^="post-menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
            document.getElementById('deleteForm').reset();
        }

        function submitDelete(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const postId = formData.get('postId');
            
            const token = csrfToken;
            fetch(`/posts/${postId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteModal();
                    showModernToast(data.message, 'success');
                    // Sayfayı yenile
                    location.reload();
                } else {
                    showModernToast(data.message || 'Bir hata oluştu.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModernToast('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            });
        }

        // Character count for edit modal
        function updateEditCharCount() {
            const textarea = document.getElementById('editContent');
            const charCount = document.getElementById('editCharCount');
            const currentLength = textarea.value.length;
            charCount.textContent = `${currentLength}/500`;
            
            if (currentLength < 10) {
                charCount.className = 'text-xs text-red-400';
            } else if (currentLength > 450) {
                charCount.className = 'text-xs text-yellow-500';
            } else {
                charCount.className = 'text-xs text-gray-400';
            }
        }

        // Add event listener to edit textarea
        document.addEventListener('DOMContentLoaded', function() {
            const editTextarea = document.getElementById('editContent');
            if (editTextarea) {
                editTextarea.addEventListener('input', updateEditCharCount);
            }
        });

        // Post içeriği genişletme/daraltma fonksiyonu
        function togglePostContent(postId, fullContent) {
            const contentElement = document.getElementById(`post-content-${postId}`);
            const toggleButton = document.getElementById(`post-toggle-${postId}`);
            
            if (toggleButton.textContent === 'Devamını Gör') {
                // Tam içeriği göster
                contentElement.innerHTML = fullContent;
                toggleButton.textContent = 'Daha Az Göster';
                toggleButton.onmouseover = function() { this.style.color='#A85D68'; };
                toggleButton.onmouseout = function() { this.style.color='#B76E79'; };
            } else {
                // Kısaltılmış içeriği göster
                const limitedContent = fullContent.length > 120 ? fullContent.substring(0, 120) + '...' : fullContent;
                contentElement.innerHTML = limitedContent;
                toggleButton.textContent = 'Devamını Gör';
                toggleButton.onmouseover = function() { this.style.color='#A85D68'; };
                toggleButton.onmouseout = function() { this.style.color='#B76E79'; };
            }
        }

        // ESC ile modal kapatma
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeEditModal();
                closeDeleteModal();
                closeCommentsModal();
            }
        });
        
        // Modal fonksiyonları (home.blade.php'den kopyalandı)
        function loadModalComments(postId) {
            const commentsList = document.getElementById('modalCommentsList');
            const commentCount = document.getElementById('modalCommentCount');
            
            commentsList.innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-rose-500"></div><p class="mt-2 text-gray-500">Yorumlar yükleniyor...</p></div>';
            
            fetch(`/posts/${postId}/comments`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayModalComments(data.comments);
                    commentCount.textContent = data.comments.length;
                } else {
                    commentsList.innerHTML = '<div class="text-center py-8 text-gray-500">Yorumlar yüklenirken hata oluştu.</div>';
                }
            })
            .catch(error => {
                console.error('Load comments error:', error);
                commentsList.innerHTML = '<div class="text-center py-8 text-gray-500">Yorumlar yüklenirken hata oluştu.</div>';
            });
        }
        
        function displayModalComments(comments) {
            const commentsList = document.getElementById('modalCommentsList');
            
            if (comments.length === 0) {
                commentsList.innerHTML = '<div class="text-center py-8 text-gray-500"><svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path></svg><h4 class="text-lg font-medium text-gray-600 mb-2">Henüz yorum yok</h4><p class="text-gray-500">İlk yorumu siz yapın!</p></div>';
                return;
            }
            
            let html = '';
            comments.forEach(comment => {
                html += createModalCommentHTML(comment);
            });
            
            commentsList.innerHTML = html;
        }
        
        function createModalCommentHTML(comment) {
            return `
                <div class="flex items-start space-x-3" id="modal-comment-${comment.id}">
                    <img class="w-10 h-10 rounded-full border-2 border-gray-200" src="${comment.user_photo}" alt="${comment.user_name}">
                    <div class="flex-1">
                        <div class="bg-gray-50 rounded-xl px-4 py-3">
                            <div class="flex items-center justify-between mb-1">
                                <h6 class="font-semibold text-sm text-gray-900">${comment.user_name}</h6>
                                <span class="text-xs text-gray-500">${comment.created_at}</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">${comment.content}</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-2 text-xs">
                            ${comment.is_owner ? `
                                <button onclick="editModalComment(${comment.id})" class="text-blue-600 hover:text-blue-800 font-medium">Düzenle</button>
                                <button onclick="deleteModalComment(${comment.id})" class="text-red-600 hover:text-red-800 font-medium">Sil</button>
                            ` : `
                                <button onclick="reportComment(${comment.id})" class="text-orange-600 hover:text-orange-800 font-medium">
                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Bildir
                                </button>
                            `}
                        </div>
                    </div>
                </div>
            `;
        }
        
        /**
         * Yorumu bildir
         */
        function reportComment(commentId) {
            @auth
                openReportModal('comment', commentId);
            @else
                if (confirm('Yorum bildirmek için giriş yapmanız gerekiyor. Giriş sayfasına yönlendirilsin mi?')) {
                    window.location.href = '/login';
                }
            @endauth
        }

        function submitModalComment(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const postId = formData.get('post_id');
            const content = formData.get('content').trim();
            
            if (!content || content.length < 2) {
                showToast('❌ Lütfen en az 2 karakter yorum yazın.', 'error');
                return;
            }
            
            const submitBtn = document.getElementById('modalCommentSubmit');
            const submitText = document.getElementById('modalSubmitText');
            const submitLoader = document.getElementById('modalSubmitLoader');
            
            submitBtn.disabled = true;
            submitText.textContent = 'Gönderiliyor...';
            submitLoader.classList.remove('hidden');
            
            const token = csrfToken;
            fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.reset();
                    updateModalCharCount();
                    
                    if (data.status === 'approved') {
                        const commentsList = document.getElementById('modalCommentsList');
                        if (commentsList.innerHTML.includes('Henüz yorum yok')) {
                            commentsList.innerHTML = '';
                        }
                        
                        const newCommentHTML = createModalCommentHTML(data.comment);
                        commentsList.insertAdjacentHTML('afterbegin', newCommentHTML);
                        
                        const modalCount = document.getElementById('modalCommentCount');
                        const pageCount = document.getElementById(`comment-count-${postId}`);
                        modalCount.textContent = data.comment_count;
                        pageCount.textContent = data.comment_count > 0 ? data.comment_count : 'Yorum Yap';
                        
                        showToast('✅ Yorumunuz başarıyla eklendi!', 'success');
                    } else if (data.status === 'suspicious') {
                        showToast('⚠️ Yorumunuz eklendi ancak moderasyon bekliyor.', 'warning');
                    } else {
                        showToast('❌ Yorumunuz spam olarak algılandı.', 'error');
                    }
                } else {
                    showToast('❌ ' + (data.message || 'Bir hata oluştu.'), 'error');
                }
            })
            .catch(error => {
                console.error('Submit comment error:', error);
                showToast('❌ Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitText.textContent = 'Gönder';
                submitLoader.classList.add('hidden');
            });
        }
        
        function updateModalCharCount() {
            const textarea = document.getElementById('modalCommentContent');
            const charCount = document.getElementById('modalCharCount');
            
            if (textarea && charCount) {
                const currentLength = textarea.value.length;
                charCount.textContent = currentLength;
                
                if (currentLength > 450) {
                    charCount.style.color = '#ef4444';
                } else if (currentLength > 400) {
                    charCount.style.color = '#f59e0b';
                } else {
                    charCount.style.color = '#6b7280';
                }
            }
        }
        
        function editModalComment(commentId) {
            const newContent = prompt('Yorumunuzu düzenleyin:');
            if (!newContent || newContent.trim().length < 2) return;
            
            const token = csrfToken;
            fetch(`/comments/${commentId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content: newContent.trim() })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('✅ Yorumunuz güncellendi!', 'success');
                    const postId = document.getElementById('modalPostId').value;
                    loadModalComments(postId);
                } else {
                    showToast('❌ ' + (data.message || 'Bir hata oluştu.'), 'error');
                }
            })
            .catch(error => {
                console.error('Edit comment error:', error);
                showToast('❌ Bir hata oluştu.', 'error');
            });
        }
        
        function deleteModalComment(commentId) {
            if (!confirm('Bu yorumu silmek istediğinizden emin misiniz?')) return;
            
            const token = csrfToken;
            fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('🗑️ Yorumunuz silindi!', 'success');
                    
                    const commentElement = document.getElementById(`modal-comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
                    }
                    
                    const modalCount = document.getElementById('modalCommentCount');
                    const postId = document.getElementById('modalPostId').value;
                    const pageCount = document.getElementById(`comment-count-${postId}`);
                    
                    const newCount = parseInt(modalCount.textContent) - 1;
                    modalCount.textContent = newCount;
                    pageCount.textContent = newCount > 0 ? newCount : 'Yorum Yap';
                    
                    const commentsList = document.getElementById('modalCommentsList');
                    if (commentsList.children.length === 0) {
                        commentsList.innerHTML = '<div class="text-center py-8 text-gray-500"><svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path></svg><h4 class="text-lg font-medium text-gray-600 mb-2">Henüz yorum yok</h4><p class="text-gray-500">İlk yorumu siz yapın!</p></div>';
                    }
                } else {
                    showToast('❌ ' + (data.message || 'Bir hata oluştu.'), 'error');
                }
            })
            .catch(error => {
                console.error('Delete comment error:', error);
                showToast('❌ Bir hata oluştu.', 'error');
            });
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const modalTextarea = document.getElementById('modalCommentContent');
            if (modalTextarea) {
                modalTextarea.addEventListener('input', updateModalCharCount);
                modalTextarea.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' && !event.shiftKey) {
                        event.preventDefault();
                        document.getElementById('modalCommentForm').dispatchEvent(new Event('submit'));
                    }
                });
            }
        });
        
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('commentsModal');
            if (event.target === modal) {
                closeCommentsModal();
            }
        });

        // ===================
        // BEĞENİ FONKSİYONLARI
        // ===================
        
        function toggleLike(postId) {
            const token = csrfToken;
            const likeBtn = document.getElementById(`like-btn-${postId}`);
            const likeIcon = document.getElementById(`like-icon-${postId}`);
            const likeCount = document.getElementById(`like-count-${postId}`);
            
            likeBtn.disabled = true;
            likeBtn.style.opacity = '0.7';
            
            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const isLiked = data.is_liked;
                    likeBtn.setAttribute('data-liked', isLiked ? 'true' : 'false');
                    
                    if (isLiked) {
                        likeIcon.classList.remove('text-gray-400');
                        likeIcon.classList.add('text-red-500', 'fill-current');
                        likeIcon.setAttribute('fill', 'currentColor');
                        likeCount.textContent = data.like_count > 0 ? data.formatted_count : 'Beğenildi';
                    } else {
                        likeIcon.classList.remove('text-red-500', 'fill-current');
                        likeIcon.classList.add('text-gray-400');
                        likeIcon.setAttribute('fill', 'none');
                        likeCount.textContent = data.like_count > 0 ? data.formatted_count : 'Beğen';
                    }
                } else {
                    showModernToast(data.message || 'Bir hata oluştu.', 'error');
                }
            })
            .catch(error => {
                console.error('Like error:', error);
                showModernToast('Bir hata oluştu.', 'error');
            })
            .finally(() => {
                likeBtn.disabled = false;
                likeBtn.style.opacity = '1';
            });
        }

        // ===================
        // YORUM FONKSİYONLARI
        // ===================
        
        function openCommentsModal(postId) {
            const modal = document.getElementById('commentsModal');
            const postIdInput = document.getElementById('modalPostId');
            
            if (!modal) {
                showModernToast('Modal component yüklenmedi. Sayfa yeniden yüklenecek.', 'error');
                location.reload();
                return;
            }
            
            if (postIdInput) {
                postIdInput.value = postId;
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex', 'show');
            document.body.style.overflow = 'hidden';
            
            loadModalComments(postId);
        }
        
        function closeCommentsModal() {
            const modal = document.getElementById('commentsModal');
            const form = document.getElementById('modalCommentForm');
            
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'show');
            document.body.style.overflow = 'auto';
            
            if (form) {
                form.reset();
                updateModalCharCount();
            }
        }
        
        function loadComments(postId) {
            const commentsList = document.getElementById(`comments-list-${postId}`);
            commentsList.innerHTML = '<div class="text-center py-4"><div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-rose-500"></div><span class="ml-2 text-gray-500">Yorumlar yükleniyor...</span></div>';
            
            fetch(`/posts/${postId}/comments`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayComments(postId, data.comments);
                } else {
                    commentsList.innerHTML = '<div class="text-center py-4 text-gray-500">Yorumlar yüklenirken hata oluştu.</div>';
                }
            })
            .catch(error => {
                console.error('Load comments error:', error);
                commentsList.innerHTML = '<div class="text-center py-4 text-gray-500">Yorumlar yüklenirken hata oluştu.</div>';
            });
        }
        
        function displayComments(postId, comments) {
            const commentsList = document.getElementById(`comments-list-${postId}`);
            
            if (comments.length === 0) {
                commentsList.innerHTML = '<div class="text-center py-4 text-gray-500">Henüz yorum yapılmamış. İlk yorumu siz yapın!</div>';
                return;
            }
            
            let html = '';
            comments.forEach(comment => {
                html += createCommentHTML(comment);
            });
            
            commentsList.innerHTML = html;
        }
        
        function createCommentHTML(comment) {
            return `
                <div class="flex items-start space-x-3" id="comment-${comment.id}">
                    <img class="w-8 h-8 rounded-full" src="${comment.user_photo}" alt="${comment.user_name}">
                    <div class="flex-1">
                        <div class="bg-gray-50 rounded-lg px-3 py-2">
                            <div class="flex items-center justify-between mb-1">
                                <h6 class="font-medium text-sm text-gray-900">${comment.user_name}</h6>
                                <span class="text-xs text-gray-500">${comment.created_at}</span>
                            </div>
                            <p class="text-sm text-gray-700">${comment.content}</p>
                        </div>
                        ${comment.is_owner ? `
                        <div class="flex items-center space-x-3 mt-1 text-xs">
                            <button onclick="editComment(${comment.id})" class="text-blue-600 hover:text-blue-800">Düzenle</button>
                            <button onclick="deleteComment(${comment.id})" class="text-red-600 hover:text-red-800">Sil</button>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
        }
        
        function submitComment(event, postId) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const content = formData.get('content').trim();
            
            if (!content || content.length < 2) {
                showModernToast('Lütfen en az 2 karakter yorum yazın.', 'error');
                return;
            }
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Gönderiliyor...';
            
            const token = csrfToken;
            fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.reset();
                    
                    if (data.status === 'approved') {
                        const commentsList = document.getElementById(`comments-list-${postId}`);
                        if (commentsList.innerHTML.includes('Henüz yorum yapılmamış')) {
                            commentsList.innerHTML = '';
                        }
                        const newCommentHTML = createCommentHTML(data.comment);
                        commentsList.insertAdjacentHTML('afterbegin', newCommentHTML);
                        const commentCount = document.getElementById(`comment-count-${postId}`);
                        commentCount.textContent = data.comment_count > 0 ? data.comment_count : 'Yorum Yap';
                        showToast('✅ Yorumunuz eklendi!', 'success');
                    } else if (data.status === 'suspicious') {
                        showToast('⚠️ Yorumunuz moderasyon bekliyor.', 'warning');
                    } else {
                        showToast('❌ Yorumunuz spam olarak algılandı.', 'error');
                    }
                } else {
                    showToast('❌ ' + (data.message || 'Bir hata oluştu.'), 'error');
                }
            })
            .catch(error => {
                console.error('Submit comment error:', error);
                showToast('❌ Bir hata oluştu.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        }
        
        function showToast(message, type = 'info') {
            showModernToast(message, type);
        }

        function editComment(commentId) {
            const newContent = prompt('Yorumunuzu düzenleyin:');
            if (!newContent || newContent.trim().length < 2) return;
            
            const token = csrfToken;
            fetch(`/comments/${commentId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content: newContent.trim() })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('✅ Yorumunuz güncellendi!', 'success');
                    location.reload();
                } else {
                    showToast('❌ ' + (data.message || 'Hata oluştu.'), 'error');
                }
            })
            .catch(error => {
                console.error('Edit comment error:', error);
                showToast('❌ Bir hata oluştu.', 'error');
            });
        }

        function deleteComment(commentId) {
            if (!confirm('Bu yorumu silmek istediğinizden emin misiniz?')) return;
            
            const token = csrfToken;
            fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('🗑️ Yorumunuz silindi!', 'success');
                    const commentElement = document.getElementById(`comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
                    }
                } else {
                    showToast('❌ ' + (data.message || 'Hata oluştu.'), 'error');
                }
            })
            .catch(error => {
                console.error('Delete comment error:', error);
                showToast('❌ Bir hata oluştu.', 'error');
            });
        }
    </script>
</x-app-layout> 