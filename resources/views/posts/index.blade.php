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
                        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100 hover:border-rose-200">
                            <!-- Kullanıcı Bilgisi -->
                            <div class="flex items-center mb-4">
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

                            <!-- Paylaşım İçeriği -->
                            <div class="text-gray-700 text-sm leading-relaxed mb-4 min-h-[60px]">
                                {{ $post->short_content }}
                            </div>

                            <!-- Alt Bilgiler -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <!-- Tarih -->
                                    <p class="text-xs text-gray-400">
                                        {{ $post->created_at->format('d.m.Y H:i') }}
                                    </p>
                                    
                                    <!-- Report Button -->
                                    @if(auth()->check() && auth()->id() !== $post->user_id)
                                        <x-report-button type="post" :id="$post->id" />
                                    @endif
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
</x-app-layout> 