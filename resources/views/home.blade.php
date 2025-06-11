<x-app-layout>
    <!-- Modern Hero Section -->
    <section class="relative bg-gradient-to-br from-[#B76E79]/5 via-white to-[#B76E79]/10 min-h-[600px] flex items-center overflow-hidden">
        <style>
            @media (min-width: 1024px) {
                .hero-flex-container {
                    flex-wrap: nowrap !important;
                }
            }
        </style>
        
        <!-- Modern Hero Boundary Lines -->
        <div class="absolute inset-0">
            <!-- Top accent line -->
            <div class="absolute top-0 left-1/4 right-1/4 h-px bg-gradient-to-r from-transparent via-[#B76E79]/30 to-transparent"></div>
            
            <!-- Bottom accent line -->
            <div class="absolute bottom-0 left-1/3 right-1/3 h-px bg-gradient-to-r from-transparent via-[#B76E79]/40 to-transparent"></div>
            
            <!-- Left side accent -->
            <div class="absolute left-0 top-1/4 bottom-1/4 w-px bg-gradient-to-b from-transparent via-[#B76E79]/25 to-transparent"></div>
            
            <!-- Right side accent -->
            <div class="absolute right-0 top-1/4 bottom-1/4 w-px bg-gradient-to-b from-transparent via-[#B76E79]/25 to-transparent"></div>
            
            <!-- Corner elements -->
            <div class="absolute top-8 left-8 w-8 h-8 border-l-2 border-t-2 border-[#B76E79]/20"></div>
            <div class="absolute top-8 right-8 w-8 h-8 border-r-2 border-t-2 border-[#B76E79]/20"></div>
            <div class="absolute bottom-8 left-8 w-8 h-8 border-l-2 border-b-2 border-[#B76E79]/20"></div>
            <div class="absolute bottom-8 right-8 w-8 h-8 border-r-2 border-b-2 border-[#B76E79]/20"></div>
        </div>
        
        <!-- Subtle center focus -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#B76E79]/5 via-transparent to-[#B76E79]/5"></div>
        
        <!-- Gül Kurusu Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#B76E79]/10 via-transparent to-[#B76E79]/5"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/30 to-transparent"></div>
        
        <!-- Hero Container -->
        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-8 sm:py-16">
            <div class="hero-flex-container" style="display: flex; flex-direction: column; gap: 2rem; align-items: center; justify-content: center; min-height: 480px;">
                
                <!-- Mobile/Tablet: Stack vertically, Desktop: Side by side -->
                <div class="w-full" style="display: flex; flex-direction: column; gap: 2rem; align-items: center;">
                
                <style>
                @media (min-width: 1024px) {
                    .hero-desktop-layout {
                        flex-direction: row !important;
                        justify-content: space-between !important;
                        align-items: flex-start !important;
                        gap: 4rem !important;
                    }
                    .hero-desktop-layout .order-1 {
                        flex: 1;
                        max-width: 600px;
                    }
                    .hero-desktop-layout .order-2 {
                        flex: 0 0 420px;
                        width: 420px;
                    }
                }
                </style>
                
                <div class="w-full hero-desktop-layout" style="display: flex; flex-direction: column; gap: 2rem; align-items: center;">
                    
                    <!-- Sol Taraf - Ana İçerik -->
                    <div class="w-full text-center lg:text-left order-1" style="max-width: 600px;">
                        <!-- Ana Başlık -->
                        <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black text-gray-900 leading-tight mb-6">
                            <span class="block">Vezirköprü</span>
                            <span class="block font-black" style="color: #B76E79;">
                                Hemşehrileri
                            </span>
                            <span class="block text-xl sm:text-2xl lg:text-4xl font-semibold text-gray-500 mt-4">
                                Bir Arada
                            </span>
                        </h1>
                        
                        <!-- Alt Başlık -->
                        <p class="text-base sm:text-lg lg:text-xl text-gray-500 leading-relaxed mb-6 max-w-lg mx-auto lg:mx-0">
                            Vezirköprü'den olan hemşehrilerimizi bulun, iletişim kurun ve güçlü bir topluluk oluşturun. 
                            <span class="font-bold" style="color: #B76E79;">{{ $users->total() }} hemşehrimiz</span> sizi bekliyor!
                        </p>
                        
                        <!-- CTA Buton -->
                        <div class="flex justify-center lg:justify-start mb-8">
                            @auth
                                <a href="{{ route('profile.edit') }}" 
                                   class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 text-white text-base sm:text-lg font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300" 
                                   style="background: linear-gradient(to right, #B76E79, #A85D68);" 
                                   onmouseover="this.style.background='linear-gradient(to right, #A85D68, #9A5460)'" 
                                   onmouseout="this.style.background='linear-gradient(to right, #B76E79, #A85D68)'"
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profilimi Güncelle
                                </a>
                            @else
                                <a href="{{ route('register') }}" 
                                   class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 text-white text-base sm:text-lg font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300" 
                                   style="background: linear-gradient(to right, #B76E79, #A85D68);" 
                                   onmouseover="this.style.background='linear-gradient(to right, #A85D68, #9A5460)'" 
                                   onmouseout="this.style.background='linear-gradient(to right, #B76E79, #A85D68)"
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Hemen Katıl
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Sağ Taraf - Arama Formu -->
                    <div class="w-full order-2" style="max-width: 420px;">
                    <div class="bg-white/90 backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-white/30 hover:shadow-3xl transition-all duration-500 hover:bg-white/95 relative overflow-hidden">
                        <!-- Form içi dekoratif element -->
                        <div class="absolute top-0 right-0 w-20 h-20 rounded-full -translate-y-10 translate-x-10" style="background: linear-gradient(to bottom right, rgba(183, 110, 121, 0.1), rgba(168, 93, 104, 0.1));"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 rounded-full translate-y-8 -translate-x-8" style="background: linear-gradient(to top right, rgba(183, 110, 121, 0.05), rgba(168, 93, 104, 0.05));"></div>
                        <!-- Form Başlığı -->
                        <div class="flex items-center mb-8 relative z-10">
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl lg:rounded-2xl flex items-center justify-center mr-4 shadow-lg" style="background: linear-gradient(to bottom right, #B76E79, #A85D68);">
                                <svg class="w-6 h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">Hemşehri Ara</h3>
                                <p class="text-sm text-gray-500">Filtreleyerek bulun</p>
                            </div>
                        </div>
                        
                        <!-- Arama Formu -->
                        <form method="GET" action="{{ route('home') }}" class="space-y-4 sm:space-y-6" onsubmit="scrollToResults()">
                            <!-- Şehir Seçimi -->
                            <div>
                                <label for="city" class="block text-sm font-bold text-gray-700 mb-2 sm:mb-3">Şehir</label>
                                <select name="city" id="city" 
                                        class="w-full border-2 border-gray-200 rounded-lg sm:rounded-xl shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-2.5 sm:py-3 px-3 sm:px-4 text-gray-900 bg-white hover:border-gray-300 text-sm sm:text-base" 
                                        onchange="updateDistricts()">
                                    <option value="">Tüm Şehirler</option>
                                    @foreach($cities as $cityName => $districts)
                                        <option value="{{ $cityName }}" {{ request('city') == $cityName ? 'selected' : '' }}>
                                            {{ $cityName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- İlçe Seçimi -->
                            <div>
                                <label for="district" class="block text-sm font-bold text-gray-700 mb-2 sm:mb-3">İlçe</label>
                                <select name="district" id="district" 
                                        class="w-full border-2 border-gray-200 rounded-lg sm:rounded-xl shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-2.5 sm:py-3 px-3 sm:px-4 text-gray-900 bg-white hover:border-gray-300 text-sm sm:text-base">
                                    <option value="">Tüm İlçeler</option>
                                </select>
                            </div>

                            <!-- Meslek Seçimi -->
                            <div>
                                <label for="profession_id" class="block text-sm font-bold text-gray-700 mb-2 sm:mb-3">Meslek</label>
                                <select name="profession_id" 
                                        class="w-full border-2 border-gray-200 rounded-lg sm:rounded-xl shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-2.5 sm:py-3 px-3 sm:px-4 text-gray-900 bg-white hover:border-gray-300 text-sm sm:text-base">
                                    <option value="">Tüm Meslekler</option>
                                    @foreach($professions as $profession)
                                        <option value="{{ $profession->id }}" {{ request('profession_id') == $profession->id ? 'selected' : '' }}>
                                            {{ $profession->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ara Butonu -->
                            <button type="submit" 
                                    class="w-full text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-bold text-base sm:text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border-0" 
                                    style="background: linear-gradient(to right, #B76E79, #A85D68);" 
                                    onmouseover="this.style.background='linear-gradient(to right, #A85D68, #9A5460)'" 
                                    onmouseout="this.style.background='linear-gradient(to right, #B76E79, #A85D68)'"
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Hemşehri Ara
                            </button>
                        </form>
                    </div>
                </div>
                
                </div> <!-- Close the hero-desktop-layout div -->
                </div> <!-- Close the flex container div -->
            </div>
        </div>
    </section>

    <!-- Üye Paylaşımları Bölümü -->
    <section class="py-12 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Başlık -->
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Hemşehrilerimizden 
                    <span style="color: #B76E79;">Yorumlar</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Vezirköprü topluluğumuzun bir parçası olan değerli hemşehrilerimizin deneyimleri
                </p>
            </div>

            <!-- Gerçek Üye Paylaşımları - 2 Satır, Her Satırda 3 Post -->
            @if($posts && $posts->count() > 0)
                <!-- İlk Satır - İlk 3 Paylaşım -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach($posts->take(3) as $post)
                        <div id="post-{{ $post->id }}" class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 relative flex flex-col h-full">
                            <!-- Kullanıcı Bilgisi -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <img class="w-12 h-12 rounded-full object-cover border-2 border-rose-200" 
                                         src="{{ $post->user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                         alt="{{ $post->user->name }}"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQ4IiBoZWlnaHQ9IjQ4IiByeD0iMjQiIGZpbGw9IiNCNzZFNzkiLz4KPHN2ZyB4PSIxMiIgeT0iMTAiIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTEyIDEyQzE0LjIwOTEgMTIgMTYgMTAuMjA5MSAxNiA4QzE2IDUuNzkwODYgMTQuMjA5MSA0IDEyIDRDOS43OTA4NiA0IDggNS43OTA4NiA4IDhDOCAxMC4yMDkxIDkuNzkwODYgMTIgMTIgMTJaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTIgMTRDOC4xMzQwMSAxNCA1IDE3LjEzNDAxIDUgMjFIMTlDMTkgMTcuMTM0MDEgMTUuODY2IDE0IDEyIDE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cjwvc3ZnPgo='">
                                    <div class="ml-3">
                                        <h4 class="font-bold text-gray-900">{{ $post->user->getDisplayNameWithIdForUser(auth()->user()) }}</h4>
                                        @if($post->user->profession)
                                            <p class="text-sm text-gray-500">{{ $post->user->display_profession }}</p>
                                        @endif
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
                            <div class="text-gray-600 text-sm leading-relaxed flex-1">
                                <p id="post-content-{{ $post->id }}">
                                    "{{ Str::limit($post->content, 120) }}"
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                        </svg>
                                        <span id="comment-count-{{ $post->id }}" class="text-sm font-medium text-gray-600">
                                            {{ $post->comment_count ? $post->comment_count . ' Yorum' : 'Yorumları Gör' }}
                                        </span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Alt Bilgi -->
                            <div class="mt-auto pt-4 {{ auth()->check() ? 'border-t border-gray-100' : '' }}">
                                @if($post->user->current_city)
                                    <p class="text-xs text-gray-400">
                                        {{ $post->user->current_city }}{{ $post->user->current_district ? ', ' . $post->user->current_district : '' }}
                                    </p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- İkinci Satır - 4., 5., 6. Paylaşım -->
                @if($posts->skip(3)->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        @foreach($posts->skip(3)->take(3) as $post)
                            <div id="post-{{ $post->id }}" class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 relative flex flex-col h-full">
                                <!-- Kullanıcı Bilgisi -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <img class="w-12 h-12 rounded-full object-cover border-2 border-rose-200" 
                                             src="{{ $post->user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                             alt="{{ $post->user->name }}"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQ4IiBoZWlnaHQ9IjQ4IiByeD0iMjQiIGZpbGw9IiNCNzZFNzkiLz4KPHN2ZyB4PSIxMiIgeT0iMTAiIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTEyIDEyQzE0LjIwOTEgMTIgMTYgMTAuMjA5MSAxNiA4QzE2IDUuNzkwODYgMTQuMjA5MSA0IDEyIDRDOS43OTA4NiA0IDggNS43OTA4NiA4IDhDOCAxMC4yMDkxIDkuNzkwODYgMTIgMTIgMTJaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTIgMTRDOC4xMzQwMSAxNCA1IDE3LjEzNDAxIDUgMjFIMTlDMTkgMTcuMTM0MDEgMTUuODY2IDE0IDEyIDE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cjwvc3ZnPgo='">
                                        <div class="ml-3">
                                            <h4 class="font-bold text-gray-900">{{ $post->user->getDisplayNameWithIdForUser(auth()->user()) }}</h4>
                                            @if($post->user->profession)
                                                <p class="text-sm text-gray-500">{{ $post->user->display_profession }}</p>
                                            @endif
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
                                <div class="text-gray-600 text-sm leading-relaxed flex-1">
                                    <p id="post-content-{{ $post->id }}">
                                        "{{ Str::limit($post->content, 120) }}"
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                            </svg>
                                            <span id="comment-count-{{ $post->id }}" class="text-sm font-medium text-gray-600">
                                                {{ $post->comment_count ? $post->comment_count . ' Yorum' : 'Yorumları Gör' }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Alt Bilgi -->
                                <div class="mt-auto pt-4 {{ auth()->check() ? 'border-t border-gray-100' : '' }}">
                                    @if($post->user->current_city)
                                        <p class="text-xs text-gray-400">
                                            {{ $post->user->current_city }}{{ $post->user->current_district ? ', ' . $post->user->current_district : '' }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <!-- Paylaşım yoksa varsayılan içerik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Varsayılan paylaşım 1 -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="flex items-center mb-4">
                            <img class="w-12 h-12 rounded-full object-cover border-2 border-rose-200" 
                                 src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQ4IiBoZWlnaHQ9IjQ4IiByeD0iMjQiIGZpbGw9IiNCNzZFNzkiLz4KPHN2ZyB4PSIxMiIgeT0iMTAiIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTEyIDEyQzE0LjIwOTEgMTIgMTYgMTAuMjA5MSAxNiA4QzE2IDUuNzkwODYgMTQuMjA5MSA0IDEyIDRDOS43OTA4NiA0IDggNS43OTA4NiA4IDhDOCAxMC4yMDkxIDkuNzkwODYgMTIgMTIgMTJaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTIgMTRDOC4xMzQwMSAxNCA1IDE3LjEzNDAxIDUgMjFIMTlDMTkgMTcuMTM0MDEgMTUuODY2IDE0IDEyIDE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cjwvc3ZnPgo=" 
                                 alt="Hemşehri">
                            <div class="ml-3">
                                <h4 class="font-bold text-gray-900">Vezirköprü Hemşehrimiz</h4>
                                <p class="text-sm text-gray-500">Platform Üyesi</p>
                            </div>
                        </div>
                        <div class="flex mb-3">
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            "Bu platform sayesinde yıllardır görmediğim lise arkadaşımla tekrar buluştum. Vezirköprülüler artık bir aile gibiyiz!"
                        </p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400">Vezirköprü Toplulugu</p>
                        </div>
                    </div>

                <!-- Paylaşım 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover border-2 border-rose-200" 
                             src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQ4IiBoZWlnaHQ9IjQ4IiByeD0iMjQiIGZpbGw9IiNCNzZFNzkiLz4KPHN2ZyB4PSIxMiIgeT0iMTAiIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTEyIDEyQzE0LjIwOTEgMTIgMTYgMTAuMjA5MSAxNiA4QzE2IDUuNzkwODYgMTQuMjA5MSA0IDEyIDRDOS43OTA4NiA0IDggNS43OTA4NiA4IDhDOCAxMC4yMDkxIDkuNzkwODYgMTIgMTIgMTJaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTIgMTRDOC4xMzQwMSAxNCA1IDE3LjEzNDAxIDUgMjFIMTlDMTkgMTcuMTM0MDEgMTUuODY2IDE0IDEyIDE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cjwvc3ZnPgo=" 
                             alt="Ayşe Hanım">
                        <div class="ml-3">
                            <h4 class="font-bold text-gray-900">Ayşe Demir</h4>
                            <p class="text-sm text-gray-500">Öğretmen</p>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <div class="flex space-x-1">
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        "Ankara'ya taşındıktan sonra kendimi yalnız hissediyordum. Bu site sayesinde buradaki hemşehrilerimle tanıştım. Harika bir topluluk!"
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400">Ankara, Çankaya</p>
                    </div>
                </div>

                <!-- Paylaşım 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover border-2 border-rose-200" 
                             src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQ4IiBoZWlnaHQ9IjQ4IiByeD0iMjQiIGZpbGw9IiNCNzZFNzkiLz4KPHN2ZyB4PSIxMiIgeT0iMTAiIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTEyIDEyQzE0LjIwOTEgMTIgMTYgMTAuMjA5MSAxNiA4QzE2IDUuNzkwODYgMTQuMjA5MSA0IDEyIDRDOS43OTA4NiA0IDggNS43OTA4NiA4IDhDOCAxMC4yMDkxIDkuNzkwODYgMTIgMTIgMTJaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTIgMTRDOC4xMzQwMSAxNCA1IDE3LjEzNDAxIDUgMjFIMTlDMTkgMTcuMTM0MDEgMTUuODY2IDE0IDEyIDE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cjwvc3ZnPgo=" 
                             alt="Ali Bey">
                        <div class="ml-3">
                            <h4 class="font-bold text-gray-900">Ali Kaya</h4>
                            <p class="text-sm text-gray-500">Doktor</p>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <div class="flex space-x-1">
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        "İzmir'de doktorluk yapıyorum. Bu platform sayesinde buradaki hemşehrilerimle buluştuk. Artık düzenli toplantılar düzenliyoruz!"
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400">İzmir, Konak</p>
                    </div>
                </div>
            </div>


                 
                 <!-- Tüm Paylaşımları Gör Butonu -->
                 @if($posts && $posts->count() > 0)
                     <div class="text-center mt-12">
                         <a href="{{ route('posts.index') }}" 
                            class="inline-flex items-center px-8 py-4 text-white text-lg font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300" 
                            style="background: linear-gradient(to right, #B76E79, #A85D68);" 
                            onmouseover="this.style.background='linear-gradient(to right, #A85D68, #9A5460)'" 
                            onmouseout="this.style.background='linear-gradient(to right, #B76E79, #A85D68)'">
                             <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                             </svg>
                             Tüm Paylaşımları Gör
                         </a>
                         @auth
                             <div class="mt-4">
                                 <a href="{{ route('posts.create') }}" 
                                    class="inline-flex items-center px-6 py-3 text-gray-700 text-base font-semibold rounded-xl border-2 border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50 transition-all duration-300">
                                     <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                     </svg>
                                     Sen de Paylaş
                                 </a>
                             </div>
                         @endauth
                     </div>
                 @endif
             @endif
        </div>
    </section>

    <div class="py-12" id="hemşehriler">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kullanıcı Listesi -->
            <div id="search-results" class="bg-white overflow-hidden shadow-lg sm:rounded-xl border" style="border-color: rgba(183, 110, 121, 0.2);">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            @if(!$hasFilters)
                                Yeni Hemşehrilerimiz
                            @else
                                Hemşehrilerimiz 
                                <span class="ml-2 px-3 py-1 text-sm font-bold rounded-full" style="background-color: rgba(183, 110, 121, 0.1); color: #B76E79;">{{ $users->total() }} kişi</span>
                            @endif
                        </h3>
                        @if(!$hasFilters)
                            <a href="{{ route('home') }}?show_all=1" class="font-semibold text-sm transition-colors duration-200" style="color: #B76E79;" onmouseover="this.style.color='#A85D68'" onmouseout="this.style.color='#B76E79'">
                                Tümünü Gör →
                            </a>
                        @endif
                    </div>
                    
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($users as $index => $user)
                                <div class="border rounded-xl p-6 hover:shadow-xl transition-all duration-300 relative flex flex-col min-h-[400px]" style="border-color: rgba(183, 110, 121, 0.2); background: linear-gradient(to bottom right, white, rgba(183, 110, 121, 0.03));" onmouseover="this.style.borderColor='rgba(183, 110, 121, 0.4)'" onmouseout="this.style.borderColor='rgba(183, 110, 121, 0.2)'">
                                    <!-- Yeni Üye Simgesi (sadece filtresiz ana sayfada ilk 8 üye için) -->
                                    @if(!$hasFilters)
                                        <div class="absolute -top-3 -right-3 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                                            Yeni Üye
                                        </div>
                                    @endif
                                    
                                    <div class="flex flex-col items-center text-center flex-1">
                                        <!-- Profil Resmi -->
                                        <div class="flex-shrink-0 mb-4">
                                            <a href="{{ route('profile.show', $user) }}">
                                                <img class="h-16 w-16 rounded-full object-cover border-3 shadow-md transition-colors" style="border-color: rgba(183, 110, 121, 0.3);" onmouseover="this.style.borderColor='rgba(183, 110, 121, 0.6)'" onmouseout="this.style.borderColor='rgba(183, 110, 121, 0.3)'" 
                                                     src="{{ $user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                                     alt="{{ $user->name }}"
                                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjE1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSA4NUMyNSA3MCAzNSA2MCA1MCA2MEM2NSA2MCA3NSA3MCA3NSA4NSIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjMiIGZpbGw9Im5vbmUiLz4KPC9zdmc+'">
                                            </a>
                                        </div>
                                        
                                        <div class="flex-1 min-w-0 w-full">
                                            <h4 class="font-bold text-lg text-gray-900 mb-2">
                                                <a href="{{ route('profile.show', $user) }}" class="transition-colors" onmouseover="this.style.color='#B76E79'" onmouseout="this.style.color='#111827'">
                                                    {{ $user->getDisplayNameWithIdForUser(auth()->user()) }}
                                                </a>
                                            </h4>
                                            
                                            @if($user->profession)
                                                <p class="text-blue-600 text-sm font-medium">{{ $user->display_profession }}</p>
                                            @endif
                                            
                                            @if($user->current_city)
                                                <p class="text-gray-600 flex items-center justify-center mb-2">
                                                    <svg class="w-4 h-4 mr-1" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 616 0z"></path>
                                                    </svg>
                                                    {{ $user->current_city }}{{ $user->current_district ? ', ' . $user->current_district : '' }}
                                                </p>
                                            @endif
                                            
                                            @if(!$hasFilters)
                                                <p class="text-gray-400 text-sm mb-2">
                                                    {{ $user->created_at->diffForHumans() }} katıldı
                                                </p>
                                            @endif
                                            
                                            @if($user->show_phone && $user->display_phone)
                                                <p class="text-gray-600 flex items-center justify-center mb-2">
                                                    <svg class="w-4 h-4 mr-1" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    {{ $user->display_phone }}
                                                </p>
                                            @endif
                                            
                                            <!-- Bio - Sabit yükseklik -->
                                            <div class="h-12 mb-3">
                                                @if($user->bio)
                                                    <p class="text-gray-500 text-sm line-clamp-2">{{ Str::limit($user->bio, 60) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Butonlar - En altta sabit -->
                                    @auth
                                        @if(auth()->id() !== $user->id)
                                            <div class="mt-auto pt-4 border-t flex space-x-2" style="border-color: rgba(183, 110, 121, 0.2);">
                                                <a href="{{ route('profile.show', $user) }}" 
                                                   class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    Profil
                                                </a>
                                                <a href="{{ route('messages.create', $user) }}" 
                                                   class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-semibold text-white rounded-lg transition-colors" style="background-color: #B76E79;" onmouseover="this.style.backgroundColor='#A85D68'" onmouseout="this.style.backgroundColor='#B76E79'">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                    Mesaj
                                                </a>
                                            </div>
                                        @else
                                            <div class="mt-auto pt-4 border-t" style="border-color: rgba(183, 110, 121, 0.2);">
                                                <a href="{{ route('profile.edit') }}" 
                                                   class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white rounded-lg transition-colors" style="background-color: #B76E79;" onmouseover="this.style.backgroundColor='#A85D68'" onmouseout="this.style.backgroundColor='#B76E79'">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Profili Düzenle
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="mt-auto pt-4 border-t" style="border-color: rgba(183, 110, 121, 0.2);">
                                            <a href="{{ route('profile.show', $user) }}" 
                                               class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors mb-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Profil
                                            </a>
                                            <p class="text-xs text-gray-500 text-center">Mesaj için <a href="{{ route('login') }}" class="font-semibold hover:underline transition-colors" style="color: #B76E79;" onmouseover="this.style.color='#A85D68'" onmouseout="this.style.color='#B76E79'">giriş yapın</a></p>
                                        </div>
                                    @endauth
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination (sadece filtreleme varsa) -->
                        @if($hasFilters)
                            <div class="mt-8">
                                {{ $users->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: rgba(183, 110, 121, 0.1);">
                                <svg class="w-12 h-12" style="color: rgba(183, 110, 121, 0.6);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Hemşehri Bulunamadı</h3>
                            <p class="text-gray-500 mb-6">Bu kriterlere uygun hemşehri bulunmamaktadır. Farklı filtreler deneyebilirsiniz.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-lg transition-colors" style="background-color: #B76E79;" onmouseover="this.style.backgroundColor='#A85D68'" onmouseout="this.style.backgroundColor='#B76E79'">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Filtreleri Temizle
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hakkımızda Bölümü -->
    <div class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    <span style="background: linear-gradient(to right, #B76E79, #A85D68); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        Hakkımızda
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Vezirköprü'den olan hemşehrilerimizi bir araya getiren, güçlü bir topluluk oluşturmayı hedefliyoruz.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Misyonumuz -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border" style="border-color: rgba(183, 110, 121, 0.2);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto" style="background-color: rgba(183, 110, 121, 0.1);">
                        <svg class="w-8 h-8" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Misyonumuz</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Vezirköprü'den olan hemşehrilerimizi dijital ortamda buluşturarak, güçlü bir topluluk ağı oluşturmak ve birbirimize destek olmayı sağlamak.
                    </p>
                </div>

                <!-- Vizyonumuz -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border" style="border-color: rgba(183, 110, 121, 0.2);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto" style="background-color: rgba(183, 110, 121, 0.1);">
                        <svg class="w-8 h-8" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Vizyonumuz</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Türkiye'nin dört bir yanına dağılmış Vezirköprülülerin en büyük dijital buluşma noktası olmak ve hemşehrilik bağlarını güçlendirmek.
                    </p>
                </div>

                <!-- Değerlerimiz -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border md:col-span-2 lg:col-span-1" style="border-color: rgba(183, 110, 121, 0.2);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto" style="background-color: rgba(183, 110, 121, 0.1);">
                        <svg class="w-8 h-8" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Değerlerimiz</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Samimiyet, dayanışma, güven ve hemşehrilik sevgisi. Birbirimize saygı göstererek, yardımlaşma ruhuyla hareket ediyoruz.
                    </p>
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="mt-16 bg-white rounded-2xl p-8 shadow-lg border" style="border-color: rgba(183, 110, 121, 0.2);">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Topluluğumuz Rakamlarla</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-black mb-2" style="color: #B76E79;">{{ $users->total() }}</div>
                        <div class="text-gray-600 font-medium">Kayıtlı Hemşehri</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black mb-2" style="color: #B76E79;">{{ count($cities) }}</div>
                        <div class="text-gray-600 font-medium">Farklı Şehir</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black mb-2" style="color: #B76E79;">{{ count($professions) }}</div>
                        <div class="text-gray-600 font-medium">Farklı Meslek</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black mb-2" style="color: #B76E79;">1</div>
                        <div class="text-gray-600 font-medium">Güçlü Topluluk</div>
                    </div>
                </div>
            </div>

            <!-- CTA Bölümü -->
            <div class="mt-12 text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Sen de Aramıza Katıl!</h3>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                    Vezirköprü'den misin? O zaman doğru yerdesin! Hemen kaydol ve hemşehrilerinle tanış.
                </p>
                @guest
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-8 py-4 text-white text-lg font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200" style="background-color: #B76E79;" onmouseover="this.style.backgroundColor='#A85D68'" onmouseout="this.style.backgroundColor='#B76E79'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Hemen Kaydol
                    </a>
                @else
                    <a href="#hemşehriler" 
                       class="inline-flex items-center px-8 py-4 text-white text-lg font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200" style="background-color: #B76E79;" onmouseover="this.style.backgroundColor='#A85D68'" onmouseout="this.style.backgroundColor='#B76E79'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Hemşehri Bul
                    </a>
                @endguest
            </div>
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
        const cities = @json($cities);
        const csrfToken = '{{ csrf_token() }}';
        
        // Global post ID for reporting
        let reportPostId = null;
        
        function updateDistricts() {
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const selectedCity = citySelect.value;
            
            // İlçe seçimini temizle
            districtSelect.innerHTML = '<option value="">Tüm İlçeler</option>';
            
            if (selectedCity && cities[selectedCity]) {
                cities[selectedCity].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    if ('{{ request("district") }}' === district) {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            }
        }
        
        // Sayfa yüklendiğinde çalıştır
        document.addEventListener('DOMContentLoaded', updateDistricts);

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

        // Arama sonuçlarına scroll fonksiyonu
        function scrollToResults() {
            // Form submit olurken scroll işlemini bir miktar geciktirelim
            setTimeout(function() {
                const resultsElement = document.getElementById('search-results');
                if (resultsElement) {
                    resultsElement.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 100);
        }

        // Sayfa yüklendiğinde filtre varsa otomatik scroll
        document.addEventListener('DOMContentLoaded', function() {
            // URL'de arama parametresi varsa sonuçlara scroll et
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('city') || urlParams.has('district') || urlParams.has('profession_id')) {
                setTimeout(function() {
                    const resultsElement = document.getElementById('search-results');
                    if (resultsElement) {
                        resultsElement.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 300);
            }
        });

        // Post içeriği genişletme/daraltma fonksiyonu
        function togglePostContent(postId, fullContent) {
            const contentElement = document.getElementById(`post-content-${postId}`);
            const toggleButton = document.getElementById(`post-toggle-${postId}`);
            
            if (toggleButton.textContent === 'Devamını Gör') {
                // Tam içeriği göster
                contentElement.innerHTML = `"${fullContent}"`;
                toggleButton.textContent = 'Daha Az Göster';
                toggleButton.onmouseover = function() { this.style.color='#A85D68'; };
                toggleButton.onmouseout = function() { this.style.color='#B76E79'; };
            } else {
                // Kısaltılmış içeriği göster
                const limitedContent = fullContent.length > 120 ? fullContent.substring(0, 120) + '...' : fullContent;
                contentElement.innerHTML = `"${limitedContent}"`;
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

        // Modal textarea için event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const modalTextarea = document.getElementById('modalCommentContent');
            if (modalTextarea) {
                // Karakter sayacı
                modalTextarea.addEventListener('input', updateModalCharCount);
                
                // Enter ile gönder (Shift+Enter ile yeni satır)
                modalTextarea.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' && !event.shiftKey) {
                        event.preventDefault();
                        document.getElementById('modalCommentForm').dispatchEvent(new Event('submit'));
                    }
                });
            }
        });

        // Modal dışına tıklayınca kapatma
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('commentsModal');
            if (event.target === modal) {
                closeCommentsModal();
            }
        });

        // ===================
        // BEĞENİ FONKSİYONLARI
        // ===================
        
        /**
         * Post beğenme/beğeniyi kaldırma
         */
        function toggleLike(postId) {
            const token = csrfToken;
            const likeBtn = document.getElementById(`like-btn-${postId}`);
            const likeIcon = document.getElementById(`like-icon-${postId}`);
            const likeCount = document.getElementById(`like-count-${postId}`);
            
            // Butonu geçici olarak deaktif et
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
                    // Beğeni durumunu güncelle
                    const isLiked = data.is_liked;
                    likeBtn.setAttribute('data-liked', isLiked ? 'true' : 'false');
                    
                    if (isLiked) {
                        // Beğenildi
                        likeIcon.classList.remove('text-gray-400');
                        likeIcon.classList.add('text-red-500', 'fill-current');
                        likeIcon.setAttribute('fill', 'currentColor');
                        likeCount.textContent = data.like_count > 0 ? data.formatted_count : 'Beğenildi';
                    } else {
                        // Beğeni kaldırıldı
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
                showModernToast('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            })
            .finally(() => {
                // Butonu tekrar aktif et
                likeBtn.disabled = false;
                likeBtn.style.opacity = '1';
            });
        }

        // ===================
        // YORUM FONKSİYONLARI
        // ===================
        
        /**
         * Yorum modal'ını aç
         */
        function openCommentsModal(postId) {
            const modal = document.getElementById('commentsModal');
            const postIdInput = document.getElementById('modalPostId');
            
            if (!modal) {
                showModernToast('Modal component yüklenmedi. Sayfa yeniden yüklenecek.', 'error');
                location.reload();
                return;
            }
            
            // Post ID'yi set et
            if (postIdInput) {
                postIdInput.value = postId;
            }
            
            // Modal'ı göster
            modal.classList.remove('hidden');
            modal.classList.add('flex', 'show');
            document.body.style.overflow = 'hidden';
            
            // Yorumları yükle
            loadModalComments(postId);
        }
        
        /**
         * Yorum modal'ını kapat
         */
        function closeCommentsModal() {
            const modal = document.getElementById('commentsModal');
            const form = document.getElementById('modalCommentForm');
            
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'show');
            document.body.style.overflow = 'auto';
            
            // Form'u temizle
            if (form) {
                form.reset();
                updateModalCharCount();
            }
        }
        
        /**
         * Modal için yorumları yükle
         */
        function loadModalComments(postId) {
            const commentsList = document.getElementById('modalCommentsList');
            const commentCount = document.getElementById('modalCommentCount');
            
            // Loading göster
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
        
        /**
         * Modal'da yorumları göster
         */
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
        
        /**
         * Modal yorum HTML'i oluştur
         */
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

        /**
         * Modal'dan yorum gönder
         */
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
            
            // Loading state
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
                        // Yeni yorumu listeye ekle
                        const commentsList = document.getElementById('modalCommentsList');
                        if (commentsList.innerHTML.includes('Henüz yorum yok')) {
                            commentsList.innerHTML = '';
                        }
                        
                        const newCommentHTML = createModalCommentHTML(data.comment);
                        commentsList.insertAdjacentHTML('afterbegin', newCommentHTML);
                        
                        // Sayaçları güncelle
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
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Gönder';
                submitLoader.classList.add('hidden');
            });
        }

        /**
         * Yorum gönder (eski - artık kullanılmıyor)
         */
        function submitComment(event, postId) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const content = formData.get('content').trim();
            
            if (!content) {
                showModernToast('Lütfen bir yorum yazın.', 'error');
                return;
            }
            
            if (content.length < 2) {
                showModernToast('Yorum en az 2 karakter olmalıdır.', 'error');
                return;
            }
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Submit butonunu deaktif et
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
                    // Form'u temizle
                    form.reset();
                    
                    if (data.status === 'approved') {
                        // Onaylanmış yorum - listeye ekle
                        const commentsList = document.getElementById(`comments-list-${postId}`);
                        
                        // "Henüz yorum yok" mesajını kaldır
                        if (commentsList.innerHTML.includes('Henüz yorum yapılmamış')) {
                            commentsList.innerHTML = '';
                        }
                        
                        // Yeni yorumu en üste ekle
                        const newCommentHTML = createCommentHTML(data.comment);
                        commentsList.insertAdjacentHTML('afterbegin', newCommentHTML);
                        
                        // Yorum sayısını güncelle
                        const commentCount = document.getElementById(`comment-count-${postId}`);
                        commentCount.textContent = data.comment_count > 0 ? data.comment_count : 'Yorum Yap';
                        
                        // Success toast göster
                        showToast('✅ Yorumunuz başarıyla eklendi!', 'success');
                    } else if (data.status === 'suspicious') {
                        showToast('⚠️ Yorumunuz eklendi ancak moderasyon bekliyor.', 'warning');
                    } else if (data.status === 'spam') {
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
                // Submit butonunu tekrar aktif et
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        }
        
        /**
         * Toast bildirim göster (Modern sisteme yönlendir)
         */
        function showToast(message, type = 'info') {
            showModernToast(message, type);
        }

        /**
         * Modal için karakter sayacını güncelle
         */
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

        /**
         * Modal yorum düzenle
         */
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
                    // Modal'ı yenile
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

        /**
         * Modal yorum sil
         */
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
                    
                    // Yorumu DOM'dan kaldır
                    const commentElement = document.getElementById(`modal-comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
                    }
                    
                    // Sayaçları güncelle
                    const modalCount = document.getElementById('modalCommentCount');
                    const postId = document.getElementById('modalPostId').value;
                    const pageCount = document.getElementById(`comment-count-${postId}`);
                    
                    const newCount = parseInt(modalCount.textContent) - 1;
                    modalCount.textContent = newCount;
                    pageCount.textContent = newCount > 0 ? newCount : 'Yorum Yap';
                    
                    // Eğer hiç yorum kalmadıysa empty state göster
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

        /**
         * Yorum düzenle (eski - artık kullanılmıyor)
         */
        function editComment(commentId) {
            // Bu fonksiyon daha gelişmiş bir implementasyon gerektirecek
            // Şimdilik basit prompt kullanıyoruz
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
                    // Sayfa yenileme yerine yorumu güncelle
                    location.reload();
                } else {
                    showToast('❌ ' + (data.message || 'Bir hata oluştu.'), 'error');
                }
            })
            .catch(error => {
                console.error('Edit comment error:', error);
                showToast('❌ Bir hata oluştu.', 'error');
            });
        }

        /**
         * Yorum sil
         */
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
                    // Yorumu DOM'dan kaldır
                    const commentElement = document.getElementById(`comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
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
    </script>
</x-app-layout>