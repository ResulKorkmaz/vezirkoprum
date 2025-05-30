<x-app-layout>
    <!-- Modern Hero Section -->
    <div class="relative bg-gradient-to-br from-rose-50 via-white to-pink-50 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>
        
        <!-- Hero Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="text-center">
                <!-- Main Heading -->
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-4 leading-tight">
                    <span class="block">Vezirköprü</span>
                    <span class="block text-rose-700">Hemşehrileri</span>
                    <span class="block text-xl md:text-2xl lg:text-3xl font-semibold text-gray-600 mt-2">Bir Arada</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Vezirköprü'den olan hemşehrilerimizi bulun, iletişim kurun ve güçlü bir topluluk oluşturun. 
                    <span class="text-rose-600 font-semibold">{{ $users->total() }} hemşehrimiz</span> sizi bekliyor!
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-10">
                    @auth
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white text-lg font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profilimi Güncelle
                        </a>
                        <a href="#hemşehriler" 
                           class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-rose-600 text-lg font-semibold rounded-xl border-2 border-rose-200 hover:border-rose-300 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Hemşehri Bul
                        </a>
                    @else
                        <!-- Mobil ve Desktop için farklı butonlar -->
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white text-lg font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span class="block sm:hidden">Hemen Kaydol</span>
                            <span class="hidden sm:block">Hemen Katıl</span>
                        </a>
                        <a href="#hemşehriler" 
                           class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-rose-600 text-lg font-semibold rounded-xl border-2 border-rose-200 hover:border-rose-300 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Hemşehri Bul
                        </a>
                    @endauth
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-rose-100">
                        <div class="text-2xl font-black text-rose-600 mb-1">{{ $users->total() }}</div>
                        <div class="text-gray-600 font-medium text-sm">Kayıtlı Hemşehri</div>
                    </div>
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-rose-100">
                        <div class="text-2xl font-black text-rose-600 mb-1">{{ count($cities) }}</div>
                        <div class="text-gray-600 font-medium text-sm">Farklı Şehir</div>
                    </div>
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-rose-100">
                        <div class="text-2xl font-black text-rose-600 mb-1">{{ count($professions) }}</div>
                        <div class="text-gray-600 font-medium text-sm">Farklı Meslek</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-8 left-8 w-16 h-16 bg-rose-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute top-20 right-12 w-12 h-12 bg-pink-200 rounded-full opacity-20 animate-pulse delay-1000"></div>
        <div class="absolute bottom-16 left-16 w-20 h-20 bg-rose-300 rounded-full opacity-20 animate-pulse delay-2000"></div>
        <div class="absolute bottom-20 right-8 w-10 h-10 bg-pink-300 rounded-full opacity-20 animate-pulse delay-500"></div>
    </div>

    <div class="py-12" id="hemşehriler">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtre Bölümü -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl mb-8 border border-rose-100">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-6">
                        <svg class="w-6 h-6 text-rose-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900">Hemşehri Ara</h3>
                    </div>
                    
                    <form method="GET" action="{{ route('home') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Şehir Seçimi -->
                        <div>
                            <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">Şehir</label>
                            <select name="city" id="city" class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors" onchange="updateDistricts()">
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
                            <label for="district" class="block text-sm font-semibold text-gray-700 mb-2">İlçe</label>
                            <select name="district" id="district" class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors">
                                <option value="">Tüm İlçeler</option>
                            </select>
                        </div>

                        <!-- Meslek Seçimi -->
                        <div>
                            <label for="profession_id" class="block text-sm font-semibold text-gray-700 mb-2">Meslek</label>
                            <select name="profession_id" class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors">
                                <option value="">Tüm Meslekler</option>
                                @foreach($professions as $profession)
                                    <option value="{{ $profession->id }}" {{ request('profession_id') == $profession->id ? 'selected' : '' }}>
                                        {{ $profession->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtrele Butonu -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Ara
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kullanıcı Listesi -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-rose-100">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 text-rose-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Hemşehrilerimiz 
                            <span class="ml-2 px-3 py-1 bg-rose-100 text-rose-700 text-sm font-bold rounded-full">{{ $users->total() }} kişi</span>
                        </h3>
                    </div>
                    
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($users as $user)
                                <div class="border border-rose-100 rounded-xl p-6 hover:shadow-xl hover:border-rose-200 transition-all duration-300 bg-gradient-to-br from-white to-rose-50/30">
                                    <div class="flex items-start space-x-4">
                                        <!-- Profil Resmi -->
                                        <div class="flex-shrink-0">
                                            <a href="{{ route('profile.show', $user) }}">
                                                <img class="h-14 w-14 rounded-xl object-cover border-2 border-rose-200 hover:border-rose-400 transition-colors shadow-md" 
                                                     src="{{ $user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                                     alt="{{ $user->name }}"
                                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxwYXRoIGQ9Ik01MCA0MEMzNy45NSA0MCAyOCAzNS4wNSAyOCAyOUM4IDIzIDEyLjk1IDE4IDI1IDE4SDE4QzMwLjA1IDE4IDM1IDIzIDM1IDI5QzM1IDM1LjA1IDMwLjA1IDQwIDI1IDQwSDUwWk01MCA1MEMzNy45NSA1MCAyOCA1NS4wNSAyOCA2MUM4IDY3IDEyLjk1IDcyIDI1IDcySDE4QzMwLjA1IDcyIDM1IDY3IDM1IDYxQzM1IDU1LjA1IDMwLjA1IDUwIDI1IDUwSDUwWiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'">
                                            </a>
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-lg text-gray-900">
                                                <a href="{{ route('profile.show', $user) }}" class="hover:text-rose-600 transition-colors">
                                                    {{ $user->name }}
                                                </a>
                                            </h4>
                                            
                                            @if($user->profession)
                                                <p class="text-rose-600 font-semibold">{{ $user->profession->name }}</p>
                                            @endif
                                            
                                            @if($user->current_city)
                                                <p class="text-gray-600 flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-1 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    {{ $user->current_city }}{{ $user->current_district ? ', ' . $user->current_district : '' }}
                                                </p>
                                            @endif
                                            
                                            @if($user->show_phone && $user->display_phone)
                                                <p class="text-gray-600 flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-1 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    {{ $user->display_phone }}
                                                </p>
                                            @endif
                                            
                                            @if($user->bio)
                                                <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ Str::limit($user->bio, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @auth
                                        @if(auth()->id() !== $user->id)
                                            <div class="mt-4 pt-4 border-t border-rose-100 flex space-x-2">
                                                <a href="{{ route('profile.show', $user) }}" 
                                                   class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    Profil
                                                </a>
                                                <a href="{{ route('messages.create', $user) }}" 
                                                   class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                    Mesaj
                                                </a>
                                            </div>
                                        @else
                                            <div class="mt-4 pt-4 border-t border-rose-100">
                                                <a href="{{ route('profile.edit') }}" 
                                                   class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Profili Düzenle
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="mt-4 pt-4 border-t border-rose-100">
                                            <a href="{{ route('profile.show', $user) }}" 
                                               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors mr-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Profil
                                            </a>
                                            <span class="text-sm text-gray-500">Mesaj göndermek için <a href="{{ route('login') }}" class="text-rose-600 hover:underline font-semibold">giriş yapın</a></span>
                                        </div>
                                    @endauth
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 mx-auto mb-6 bg-rose-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Hemşehri Bulunamadı</h3>
                            <p class="text-gray-500 mb-6">Bu kriterlere uygun hemşehri bulunmamaktadır. Farklı filtreler deneyebilirsiniz.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors">
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

    <script>
        const cities = @json($cities);
        
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
    </script>
</x-app-layout> 