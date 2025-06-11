<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sayfa Başlığı -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                            <svg class="w-8 h-8 mr-3" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Tüm Hemşehrilerimiz
                        </h1>
                        <p class="text-gray-600 mt-2">Vezirköprü'den olan tüm hemşehrilerimizi görüntüleyin</p>
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
                    <svg class="w-4 h-4 mr-1" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Toplam {{ $users->total() }} hemşehrimiz
                </div>
            </div>

            <!-- Filtre Formu -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <form method="GET" action="{{ route('hemsehriler.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Arama -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="İsim, şehir veya ilçe ara..."
                               class="w-full border-2 border-gray-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-2.5 px-3 text-gray-900 bg-white hover:border-gray-300">
                    </div>

                    <!-- Şehir Seçimi -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Şehir</label>
                        <select name="city" id="city" 
                                class="w-full border-2 border-gray-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-2.5 px-3 text-gray-900 bg-white hover:border-gray-300" 
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
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">İlçe</label>
                        <select name="district" id="district" 
                                class="w-full border-2 border-gray-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-2.5 px-3 text-gray-900 bg-white hover:border-gray-300">
                            <option value="">Tüm İlçeler</option>
                        </select>
                    </div>

                    <!-- Meslek Seçimi -->
                    <div>
                        <label for="profession_id" class="block text-sm font-medium text-gray-700 mb-2">Meslek</label>
                        <select name="profession_id" 
                                class="w-full border-2 border-gray-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-2.5 px-3 text-gray-900 bg-white hover:border-gray-300">
                            <option value="">Tüm Meslekler</option>
                            @foreach($professions as $profession)
                                <option value="{{ $profession->id }}" {{ request('profession_id') == $profession->id ? 'selected' : '' }}>
                                    {{ $profession->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtre Butonları -->
                    <div class="md:col-span-2 lg:col-span-4 flex gap-3 pt-4">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                                style="background: linear-gradient(to right, #B76E79, #A85D68);"
                                onmouseover="this.style.background='linear-gradient(to right, #A85D68, #9A5460)'"
                                onmouseout="this.style.background='linear-gradient(to right, #B76E79, #A85D68)'">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrele
                        </button>
                        
                        @if(request()->hasAny(['search', 'city', 'district', 'profession_id']))
                            <a href="{{ route('hemsehriler.index') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Filtreleri Temizle
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if($users->count() > 0)
                <!-- Hemşehriler Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($users as $user)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100 hover:border-rose-200 relative flex flex-col h-full">
                            <!-- Profil Resmi -->
                            <div class="flex-shrink-0 mb-4 text-center">
                                <a href="{{ route('profile.show', $user) }}">
                                    <img class="h-20 w-20 rounded-full object-cover border-3 shadow-md transition-colors mx-auto" 
                                         style="border-color: rgba(183, 110, 121, 0.3);" 
                                         onmouseover="this.style.borderColor='rgba(183, 110, 121, 0.6)'" 
                                         onmouseout="this.style.borderColor='rgba(183, 110, 121, 0.3)'" 
                                         src="{{ $user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                         alt="{{ $user->name }}"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzUiIHI9IjE1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSA4NUMyNSA3MCAzNSA2MCA1MCA2MEM2NSA2MCA3NSA3MCA3NSA4NSIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjMiIGZpbGw9Im5vbmUiLz4KPC9zdmc+'">
                                </a>
                            </div>
                            
                            <!-- Kullanıcı Bilgileri -->
                            <div class="flex-1 text-center">
                                <h4 class="font-bold text-lg text-gray-900 mb-2">
                                    <a href="{{ route('profile.show', $user) }}" class="transition-colors hover:text-rose-600">
                                        {{ $user->getDisplayNameWithIdForUser(auth()->user()) }}
                                    </a>
                                </h4>
                                
                                @if($user->profession)
                                    <p class="text-blue-600 text-sm font-medium mb-2">{{ $user->display_profession }}</p>
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
                                
                                <p class="text-gray-400 text-sm mb-3">
                                    {{ $user->created_at->diffForHumans() }} katıldı
                                </p>
                                
                                @if($user->show_phone && $user->display_phone)
                                    <p class="text-gray-600 flex items-center justify-center mb-3">
                                        <svg class="w-4 h-4 mr-1" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $user->display_phone }}
                                    </p>
                                @endif
                                
                                <!-- Bio -->
                                @if($user->bio)
                                    <div class="mb-4">
                                        <p class="text-gray-500 text-sm line-clamp-3">{{ Str::limit($user->bio, 80) }}</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Butonlar -->
                            @auth
                                @if(auth()->id() !== $user->id)
                                    <div class="mt-auto pt-4 border-t border-gray-100 flex space-x-2">
                                        <a href="{{ route('profile.show', $user) }}" 
                                           class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Profil
                                        </a>
                                        <a href="{{ route('messages.create', $user) }}" 
                                           class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-semibold text-white rounded-lg transition-colors" 
                                           style="background-color: #B76E79;" 
                                           onmouseover="this.style.backgroundColor='#A85D68'" 
                                           onmouseout="this.style.backgroundColor='#B76E79'">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            Mesaj
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-auto pt-4 border-t border-gray-100">
                                        <a href="{{ route('profile.edit') }}" 
                                           class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white rounded-lg transition-colors" 
                                           style="background-color: #B76E79;" 
                                           onmouseover="this.style.backgroundColor='#A85D68'" 
                                           onmouseout="this.style.backgroundColor='#B76E79'">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Profili Düzenle
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="mt-auto pt-4 border-t border-gray-100">
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

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Boş Durum -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: rgba(183, 110, 121, 0.1);">
                        <svg class="w-12 h-12" style="color: rgba(183, 110, 121, 0.6);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Hemşehri Bulunamadı</h3>
                    <p class="text-gray-500 mb-6">Bu kriterlere uygun hemşehri bulunmamaktadır. Farklı filtreler deneyebilirsiniz.</p>
                    
                    @if(request()->hasAny(['search', 'city', 'district', 'profession_id']))
                        <a href="{{ route('hemsehriler.index') }}" 
                           class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-lg transition-colors" 
                           style="background-color: #B76E79;" 
                           onmouseover="this.style.backgroundColor='#A85D68'" 
                           onmouseout="this.style.backgroundColor='#B76E79'">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Filtreleri Temizle
                        </a>
                    @else
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-lg transition-colors" 
                           style="background-color: #B76E79;" 
                           onmouseover="this.style.backgroundColor='#A85D68'" 
                           onmouseout="this.style.backgroundColor='#B76E79'">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Ana Sayfaya Dön
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        // Şehir seçildiğinde ilçeleri güncelle
        function updateDistricts() {
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const selectedCity = citySelect.value;
            
            // İlçe seçeneklerini temizle
            districtSelect.innerHTML = '<option value="">Tüm İlçeler</option>';
            
            if (selectedCity) {
                const cities = @json($cities);
                const districts = cities[selectedCity] || [];
                
                districts.forEach(district => {
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
        
        // Sayfa yüklendiğinde ilçeleri güncelle
        document.addEventListener('DOMContentLoaded', function() {
            updateDistricts();
        });
    </script>
</x-app-layout> 