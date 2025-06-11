<!-- Modern Tailwind Navigation -->
<nav class="bg-white shadow-lg border-b border-gray-100 sticky top-0 z-50 transition-all duration-300" id="navbar" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
        <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-4 group">
                    <div class="w-14 h-14 border rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105 overflow-hidden" style="background: linear-gradient(to bottom right, rgba(183, 110, 121, 0.1), rgba(183, 110, 121, 0.05)); border-color: rgba(183, 110, 121, 0.2);">
                        <img src="{{ asset('images/logo.png') }}" alt="Vezirköprüm Logo" class="w-11 h-11 object-contain">
                    </div>
                    <span class="text-2xl font-black tracking-tight transition-colors duration-200" style="color: #B76E79;" onmouseover="this.style.color='#A85D68'" onmouseout="this.style.color='#B76E79'">
                        Vezirköprüm
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <!-- Ana Sayfa -->
                <a href="{{ route('home') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}"
                   style="{{ request()->routeIs('home') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                   onmouseover="if (!this.classList.contains('shadow-sm')) { this.style.color='#B76E79'; }"
                   onmouseout="if (!this.classList.contains('shadow-sm')) { this.style.color='#374151'; }">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ana Sayfa
                </a>

                @auth
                    <!-- Bildirimler (Dropdown) -->
                    <div class="relative" x-data="{ notificationsOpen: false }">
                        <button @mouseenter="notificationsOpen = true" @mouseleave="notificationsOpen = false"
                                class="relative px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('notifications.*') || request()->routeIs('messages.*') ? 'shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}"
                                style="{{ request()->routeIs('notifications.*') || request()->routeIs('messages.*') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                                onmouseover="if (!this.classList.contains('shadow-sm')) { this.style.color='#B76E79'; }"
                                onmouseout="if (!this.classList.contains('shadow-sm')) { this.style.color='#374151'; }">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2c3.31 0 6 2.69 6 6v3l2 3H4l2-3V8c0-3.31 2.69-6 6-6z"></path>
                            </svg>
                            Bildirimler
                            @php
                                $totalNotifications = auth()->user()->unread_notifications_count + auth()->user()->unread_messages_count;
                            @endphp
                            @if($totalNotifications > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 rounded-full shadow-lg" style="background: linear-gradient(to right, #dc2626, #b91c1c); min-width: 20px; height: 20px;">
                                    {{ $totalNotifications > 99 ? '99+' : $totalNotifications }}
                                </span>
                            @endif
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="notificationsOpen" 
                             @mouseenter="notificationsOpen = true" @mouseleave="notificationsOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-1 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-1 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            
                            <!-- Tüm Bildirimler -->
                            <a href="{{ route('notifications.index') }}" 
                               class="flex items-center justify-between px-4 py-3 text-sm transition-colors duration-200 {{ request()->routeIs('notifications.*') ? 'bg-rose-50 text-rose-600' : 'text-gray-700 hover:bg-gray-50' }}"
                               onmouseover="if (!'{{ request()->routeIs('notifications.*') }}') { this.style.backgroundColor='rgba(183, 110, 121, 0.1)'; this.style.color='#B76E79'; }"
                               onmouseout="if (!'{{ request()->routeIs('notifications.*') }}') { this.style.backgroundColor='transparent'; this.style.color='#374151'; }">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2c3.31 0 6 2.69 6 6v3l2 3H4l2-3V8c0-3.31 2.69-6 6-6z"></path>
                                    </svg>
                                    Tüm Bildirimler
                                </div>
                                @if(auth()->user()->unread_notifications_count > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                                        {{ auth()->user()->unread_notifications_count > 99 ? '99+' : auth()->user()->unread_notifications_count }}
                                    </span>
                                @endif
                            </a>

                            <!-- Mesajlar -->
                            <a href="{{ route('messages.index') }}" 
                               class="flex items-center justify-between px-4 py-3 text-sm transition-colors duration-200 {{ request()->routeIs('messages.*') ? 'bg-rose-50 text-rose-600' : 'text-gray-700 hover:bg-gray-50' }}"
                               onmouseover="if (!'{{ request()->routeIs('messages.*') }}') { this.style.backgroundColor='rgba(183, 110, 121, 0.1)'; this.style.color='#B76E79'; }"
                               onmouseout="if (!'{{ request()->routeIs('messages.*') }}') { this.style.backgroundColor='transparent'; this.style.color='#374151'; }">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    Mesajlar
                                </div>
                                @if(auth()->user()->unread_messages_count > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                                        {{ auth()->user()->unread_messages_count > 99 ? '99+' : auth()->user()->unread_messages_count }}
                                    </span>
                                @endif
                            </a>

                            <!-- Ayırıcı -->
                            <hr class="my-2 border-gray-100">
                            
                            <!-- Ayarlar -->
                            <a href="{{ route('notifications.settings') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors duration-200"
                               onmouseover="this.style.backgroundColor='rgba(183, 110, 121, 0.1)'; this.style.color='#B76E79';"
                               onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6B7280';">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Bildirim Ayarları
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp Grupları -->
                    <a href="{{ route('whatsapp.index') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('whatsapp.*') ? 'shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}"
                       style="{{ request()->routeIs('whatsapp.*') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                       onmouseover="if (!this.classList.contains('shadow-sm')) { this.style.color='#B76E79'; }"
                       onmouseout="if (!this.classList.contains('shadow-sm')) { this.style.color='#374151'; }">
                        <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        WhatsApp Grupları
                    </a>

                    <!-- Hemşehriler -->
                    @auth
                        <a href="{{ route('hemsehriler.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('hemsehriler.*') ? 'shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}"
                           style="{{ request()->routeIs('hemsehriler.*') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                           onmouseover="if (!this.classList.contains('shadow-sm')) { this.style.color='#B76E79'; }"
                           onmouseout="if (!this.classList.contains('shadow-sm')) { this.style.color='#374151'; }">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Hemşehriler
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-gray-700 hover:bg-gray-50 relative"
                           onmouseover="this.style.color='#B76E79';"
                           onmouseout="this.style.color='#374151';"
                           title="Hemşehrileri görmek için giriş yapın">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Hemşehriler
                            <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </a>
                    @endauth

                    <!-- Paylaşım Yap -->
                    <a href="{{ route('posts.create') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('posts.create') ? 'shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}"
                       style="{{ request()->routeIs('posts.create') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                       onmouseover="if (!this.classList.contains('shadow-sm')) { this.style.color='#B76E79'; }"
                       onmouseout="if (!this.classList.contains('shadow-sm')) { this.style.color='#374151'; }">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Paylaşım Yap
                    </a>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-gray-300 mx-4"></div>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                                style="focus:ring-color: #B76E79;"
                                onmouseover="this.style.backgroundColor='rgba(183, 110, 121, 0.05)'"
                                onmouseout="this.style.backgroundColor='rgba(249, 250, 251, 1)'"
                                <!-- User Avatar -->
                            <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-md" style="background: linear-gradient(to bottom right, #B76E79, #A85D68);">
                                    @if(auth()->user()->profile_photo)
                                        <img src="{{ auth()->user()->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                             alt="{{ auth()->user()->name }}" 
                                         class="w-8 h-8 rounded-full object-cover">
                                    @else
                                    <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    @endif
                                </div>
                            <div class="hidden lg:block text-left">
                                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-1 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-1 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200"
                                   onmouseover="this.style.backgroundColor='rgba(183, 110, 121, 0.1)'; this.style.color='#B76E79';"
                                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profilim
                                </a>
                                
                                <a href="{{ route('profile.show', auth()->user()) }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors duration-200"
                                   onmouseover="this.style.backgroundColor='rgba(183, 110, 121, 0.1)'; this.style.color='#B76E79';"
                                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#374151';">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Profilimi Görüntüle
                                </a>

                            @if(auth()->user()->is_admin)
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="flex items-center px-4 py-2 text-sm text-amber-700 hover:bg-amber-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Admin Panel
                                    </a>
                            @endif

                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Çıkış Yap
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200"
                       onmouseover="this.style.color='#B76E79';"
                       onmouseout="this.style.color='#374151';">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Giriş Yap
                    </a>
                    <a href="{{ route('register') }}" 
                       class="ml-3 px-6 py-2 text-white text-sm font-medium rounded-lg transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl"
                       style="background: linear-gradient(to right, #B76E79, #A85D68);"
                       onmouseover="this.style.background='linear-gradient(to right, #A85D68, #9A5460)'"
                       onmouseout="this.style.background='linear-gradient(to right, #B76E79, #A85D68)'"
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Kayıt Ol
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2"
                        style="focus:ring-color: #B76E79;"
                        onmouseover="this.style.color='#B76E79';"
                        onmouseout="this.style.color='#6B7280';">
                    <svg class="w-6 h-6" :class="{ 'hidden': mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6" :class="{ 'hidden': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" 
             @click.away="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-1 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-1 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-gray-100 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Ana Sayfa -->
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('home') ? '' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200"
                   style="{{ request()->routeIs('home') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                   onmouseover="if (!'{{ request()->routeIs('home') }}') { this.style.color='#B76E79'; }"
                   onmouseout="if (!'{{ request()->routeIs('home') }}') { this.style.color='#374151'; }">
                    <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ana Sayfa
                </a>

                @auth
                    <!-- Bildirimler (Dropdown) -->
                    <div x-data="{ mobileNotificationsOpen: false }">
                        <button @click="mobileNotificationsOpen = !mobileNotificationsOpen"
                                class="flex items-center justify-between w-full px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('notifications.*') || request()->routeIs('messages.*') ? '' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200"
                                style="{{ request()->routeIs('notifications.*') || request()->routeIs('messages.*') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                                onmouseover="if (!'{{ request()->routeIs('notifications.*') || request()->routeIs('messages.*') }}') { this.style.color='#B76E79'; }"
                                onmouseout="if (!'{{ request()->routeIs('notifications.*') || request()->routeIs('messages.*') }}') { this.style.color='#374151'; }">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2c3.31 0 6 2.69 6 6v3l2 3H4l2-3V8c0-3.31 2.69-6 6-6z"></path>
                                </svg>
                                <span>Bildirimler</span>
                                @php
                                    $mobileTotalNotifications = auth()->user()->unread_notifications_count + auth()->user()->unread_messages_count;
                                @endphp
                                @if($mobileTotalNotifications > 0)
                                    <span class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                                        {{ $mobileTotalNotifications > 99 ? '99+' : $mobileTotalNotifications }}
                                    </span>
                                @endif
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': mobileNotificationsOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Mobile Dropdown Content -->
                        <div x-show="mobileNotificationsOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-1 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-1 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="ml-6 mt-2 space-y-1">
                            
                            <!-- Tüm Bildirimler -->
                            <a href="{{ route('notifications.index') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('notifications.*') ? 'bg-rose-50 text-rose-600' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200"
                               onmouseover="if (!'{{ request()->routeIs('notifications.*') }}') { this.style.color='#B76E79'; }"
                               onmouseout="if (!'{{ request()->routeIs('notifications.*') }}') { this.style.color='#6B7280'; }">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2c3.31 0 6 2.69 6 6v3l2 3H4l2-3V8c0-3.31 2.69-6 6-6z"></path>
                                    </svg>
                                    Tüm Bildirimler
                                </div>
                                @if(auth()->user()->unread_notifications_count > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[18px] text-center">
                                        {{ auth()->user()->unread_notifications_count > 99 ? '99+' : auth()->user()->unread_notifications_count }}
                                    </span>
                                @endif
                            </a>

                            <!-- Mesajlar -->
                            <a href="{{ route('messages.index') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('messages.*') ? 'bg-rose-50 text-rose-600' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200"
                               onmouseover="if (!'{{ request()->routeIs('messages.*') }}') { this.style.color='#B76E79'; }"
                               onmouseout="if (!'{{ request()->routeIs('messages.*') }}') { this.style.color='#6B7280'; }">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    Mesajlar
                                </div>
                                @if(auth()->user()->unread_messages_count > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[18px] text-center">
                                        {{ auth()->user()->unread_messages_count > 99 ? '99+' : auth()->user()->unread_messages_count }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp Grupları -->
                    <a href="{{ route('whatsapp.index') }}" 
                       class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('whatsapp.*') ? '' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200"
                       style="{{ request()->routeIs('whatsapp.*') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                       onmouseover="if (!'{{ request()->routeIs('whatsapp.*') }}') { this.style.color='#B76E79'; }"
                       onmouseout="if (!'{{ request()->routeIs('whatsapp.*') }}') { this.style.color='#374151'; }">
                        <svg class="w-5 h-5 inline-block mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        WhatsApp Grupları
                    </a>

                    <!-- Hemşehriler -->
                    @auth
                        <a href="{{ route('hemsehriler.index') }}" 
                           class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('hemsehriler.*') ? '' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200"
                           style="{{ request()->routeIs('hemsehriler.*') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                           onmouseover="if (!'{{ request()->routeIs('hemsehriler.*') }}') { this.style.color='#B76E79'; }"
                           onmouseout="if (!'{{ request()->routeIs('hemsehriler.*') }}') { this.style.color='#374151'; }">
                            <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Hemşehriler
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block px-3 py-2 rounded-lg text-base font-medium transition-all duration-200 text-gray-700 hover:bg-gray-50 relative"
                           onmouseover="this.style.color='#B76E79';"
                           onmouseout="this.style.color='#374151';"
                           title="Hemşehrileri görmek için giriş yapın">
                            <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Hemşehriler
                            <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </a>
                    @endauth

                    <!-- Paylaşım Yap -->
                    <a href="{{ route('posts.create') }}" 
                       class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('posts.create') ? '' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200"
                       style="{{ request()->routeIs('posts.create') ? 'background-color: rgba(183, 110, 121, 0.1); color: #B76E79;' : '' }}"
                       onmouseover="if (!'{{ request()->routeIs('posts.create') }}') { this.style.color='#B76E79'; }"
                       onmouseout="if (!'{{ request()->routeIs('posts.create') }}') { this.style.color='#374151'; }">
                        <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Paylaşım Yap
                    </a>

                    <!-- User Section -->
                    <div class="border-t border-gray-100 mt-4 pt-4">
                        <div class="flex items-center px-3 py-2 mb-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-md mr-3" style="background: linear-gradient(to bottom right, #B76E79, #A85D68);">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ auth()->user()->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                         alt="{{ auth()->user()->name }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" 
                           class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                           onmouseover="this.style.color='#B76E79';"
                           onmouseout="this.style.color='#374151';">
                            <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profilim
                        </a>

                        <a href="{{ route('profile.show', auth()->user()) }}" 
                           class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                           onmouseover="this.style.color='#B76E79';"
                           onmouseout="this.style.color='#374151';">
                            <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Profilimi Görüntüle
                        </a>

                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" 
                               class="block px-3 py-2 rounded-lg text-base font-medium text-amber-700 hover:bg-amber-50 transition-colors duration-200">
                                <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Admin Panel
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-3 py-2 rounded-lg text-base font-medium text-red-700 hover:bg-red-50 transition-colors duration-200">
                                <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Çıkış Yap
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest Links -->
                    <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
                        <a href="{{ route('login') }}" 
                           class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                           onmouseover="this.style.color='#B76E79';"
                           onmouseout="this.style.color='#374151';">
                            <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Giriş Yap
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block px-3 py-2 text-white text-base font-medium rounded-lg text-center transition-all duration-200"
                           style="background: linear-gradient(to right, #B76E79, #A85D68);"
                           onmouseover="this.style.background='linear-gradient(to right, #A85D68, #9A5460)'"
                           onmouseout="this.style.background='linear-gradient(to right, #B76E79, #A85D68)'"
                            <svg class="w-5 h-5 inline-block mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Kayıt Ol
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Scroll effect script -->
<script>
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 10) {
            navbar.classList.add('shadow-xl', 'bg-white/95', 'backdrop-blur-sm');
            navbar.classList.remove('shadow-lg');
        } else {
            navbar.classList.add('shadow-lg');
            navbar.classList.remove('shadow-xl', 'bg-white/95', 'backdrop-blur-sm');
        }
    });
</script>
 