<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }} - Profil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-2xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <!-- Sol Panel - Profil Resmi ve Kişisel Bilgiler -->
                    <div class="bg-gradient-to-b from-indigo-600 to-purple-700 p-8 text-white">
                        <!-- Profil Resmi - Dikdörtgen -->
                        <div class="mb-6">
                            <img class="w-full h-64 object-cover rounded-xl shadow-2xl border-4 border-white/30" 
                                 src="{{ $user->getVisibleProfilePhotoUrl($currentUser) }}" 
                                 alt="{{ $user->name }}" 
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjI1NiIgdmlld0JveD0iMCAwIDIwMCAyNTYiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjU2IiBmaWxsPSIjRTVFN0VCIiByeD0iMTIiLz4KPGNpcmNsZSBjeD0iMTAwIiBjeT0iODAiIHI9IjM1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik00MCAxODBDNDAgMTUwIDcwIDEzMCAxMDAgMTMwQzEzMCAxMzAgMTYwIDE1MCAxNjAgMTgwVjIxMEg0MFYxODBaIiBmaWxsPSIjOUNBM0FGIi8+Cjwvc3ZnPgo='">
                        </div>
                        
                        <!-- Ad Soyad -->
                        <h1 class="text-2xl font-bold mb-2 text-center">{{ $user->name }}</h1>
                        
                        <!-- Meslek -->
                        @if($user->profession)
                            <p class="text-indigo-200 text-center mb-6 text-lg">{{ $user->profession->name }}</p>
                        @endif
                        
                        <div class="space-y-4 border-t border-white/20 pt-6">
                            <!-- E-posta -->
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-indigo-200">E-posta</p>
                                    <p class="text-sm text-white truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <!-- Telefon -->
                            @if($user->show_phone && $user->phone)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-indigo-200">Telefon</p>
                                        <a href="tel:{{ $user->phone }}" class="text-sm text-white hover:text-indigo-200 transition">
                                            {{ $user->display_phone }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Konum -->
                            @if($user->current_city)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-indigo-200">Konum</p>
                                        <p class="text-sm text-white">
                                            {{ $user->current_city }}{{ $user->current_district ? ', ' . $user->current_district : '' }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Doğum Yılı -->
                            @if($user->birth_year)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-indigo-200">Doğum Yılı</p>
                                        <p class="text-sm text-white">{{ $user->birth_year }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Eylem Butonları -->
                        @auth
                            <div class="mt-8 space-y-3">
                                @if($currentUser && $currentUser->id !== $user->id)
                                    <a href="{{ route('messages.create', $user) }}" 
                                       class="w-full flex items-center justify-center px-4 py-3 border-2 border-white text-sm font-medium rounded-xl text-white bg-white/10 hover:bg-white hover:text-indigo-700 transition duration-200 backdrop-blur-sm">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        Mesaj Gönder
                                    </a>
                                @endif
                                @if($currentUser && $currentUser->id === $user->id)
                                    <a href="{{ route('profile.edit') }}" 
                                       class="w-full flex items-center justify-center px-4 py-3 border-2 border-yellow-300 text-sm font-medium rounded-xl text-yellow-300 bg-yellow-300/10 hover:bg-yellow-300 hover:text-indigo-700 transition duration-200 backdrop-blur-sm">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Profili Düzenle
                                    </a>
                                @endif
                            </div>
                        @endauth
                    </div>
                    
                    <!-- Sağ Panel - Hakkımda ve Detaylar -->
                    <div class="md:col-span-2 p-8 bg-gray-50">
                        <!-- Hakkımda Bölümü -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Hakkımda
                            </h2>
                            @if($user->bio)
                                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $user->bio }}</p>
                                </div>
                            @else
                                <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200 text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 italic">Henüz hakkında bilgisi eklenmemiş.</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Detaylı Bilgiler -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Detaylı Bilgiler
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($user->profession)
                                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 hover:shadow-md transition">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">Meslek</p>
                                                <p class="text-base font-semibold text-gray-900">{{ $user->profession->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($user->current_city)
                                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 hover:shadow-md transition">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">Yaşadığı Yer</p>
                                                <p class="text-base font-semibold text-gray-900">
                                                    {{ $user->current_city }}{{ $user->current_district ? ', ' . $user->current_district : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 hover:shadow-md transition">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Kayıt Tarihi</p>
                                            <p class="text-base font-semibold text-gray-900">{{ $user->created_at->format('d.m.Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!$user->show_phone && Auth::check())
                                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 hover:shadow-md transition">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">Telefon</p>
                                                <p class="text-base text-gray-600 italic">Gizli</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 