<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <span class="text-2xl font-bold text-blue-600">Vezirköprüm</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-blue-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        Ana Sayfa
                    </a>
                    
                    @auth
                        <a href="{{ route('messages.index') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('messages.*') ? 'border-blue-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Mesajlar
                            @if(auth()->user()->unread_messages_count > 0)
                                <span class="ml-1 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                    {{ auth()->user()->unread_messages_count }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('whatsapp.index') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('whatsapp.*') ? 'border-blue-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            WhatsApp Grupları
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Çıkış Yap') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Giriş Yap
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Kayıt Ol
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                Ana Sayfa
            </a>
            
            @auth
                <a href="{{ route('messages.index') }}" 
                   class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('messages.*') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                    Mesajlar
                </a>
                
                <a href="{{ route('whatsapp.index') }}" 
                   class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('whatsapp.*') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                    WhatsApp Grupları
                </a>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition duration-150 ease-in-out">
                        Profil
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition duration-150 ease-in-out">
                            Çıkış Yap
                        </a>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="space-y-1">
                    <a href="{{ route('login') }}" 
                       class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition duration-150 ease-in-out">
                        Giriş Yap
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition duration-150 ease-in-out">
                        Kayıt Ol
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav> 