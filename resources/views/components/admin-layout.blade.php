<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [id^="flash-"] {
            animation: slideInRight 0.3s ease-out;
            transition: all 0.3s ease;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Modern Admin Navigation -->
        <nav class="bg-white shadow-lg border-b border-gray-200" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <!-- Modern Logo -->
                        <div class="flex-shrink-0 flex items-center mr-8">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
                                    <p class="text-xs text-gray-500">Vezirköprü Platform</p>
                                </div>
                            </div>
                        </div>

                        <!-- Modern Navigation Links -->
                        <div class="hidden md:flex items-center space-x-2">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 {{ request()->routeIs('admin.dashboard') ? 'text-gray-700' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v4"></path>
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('admin.users.index') }}" 
                               class="{{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 {{ request()->routeIs('admin.users.*') ? 'text-gray-700' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                </svg>
                                Kullanıcılar
                            </a>
                            
                            <a href="{{ route('admin.spam.index') }}" 
                               class="{{ request()->routeIs('admin.spam.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} group relative flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 {{ request()->routeIs('admin.spam.*') ? 'text-gray-700' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Spam Yönetimi
                                @php
                                    $spamCount = \App\Models\Post::where('spam_status', 'suspicious')->orWhere('spam_status', 'quarantined')->count();
                                @endphp
                                @if($spamCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-md animate-pulse">
                                        {{ $spamCount > 9 ? '9+' : $spamCount }}
                                    </span>
                                @endif
                            </a>
                            
                            <a href="{{ route('admin.reports.index') }}" 
                               class="{{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} group relative flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 {{ request()->routeIs('admin.reports.*') ? 'text-gray-700' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Bildiriler
                                @php
                                    $pendingCount = \App\Models\Report::where('status', 'pending')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="absolute -top-1 -right-1 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-md animate-pulse" style="background-color: #a85d68;">
                                        {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                                    </span>
                                @endif
                            </a>
                            
                            <a href="{{ route('admin.whatsapp.index') }}" 
                               class="{{ request()->routeIs('admin.whatsapp.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 {{ request()->routeIs('admin.whatsapp.*') ? 'text-gray-700' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h2m2-4h6a2 2 0 012 2v6a2 2 0 01-2 2h-2l-4 4v-4H9a2 2 0 01-2-2V6a2 2 0 012-2z"></path>
                                </svg>
                                WhatsApp Grupları
                            </a>
                            
                            <a href="{{ route('admin.settings.index') }}" 
                               class="{{ request()->routeIs('admin.settings.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 {{ request()->routeIs('admin.settings.*') ? 'text-gray-700' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Site Ayarları
                            </a>
                        </div>
                    </div>

                    <!-- Modern User Menu -->
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Web sitesine dön butonu -->
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Web Sitesine Dön
                        </a>
                        
                        <div class="flex items-center space-x-3 px-4 py-2 rounded-xl bg-gray-50 border border-gray-200">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-xl shadow-sm transition-all duration-200 transform hover:scale-105"
                                    style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);"
                                    onmouseover="this.style.background='linear-gradient(135deg, #96526b 0%, #a85d68 100%)'"
                                    onmouseout="this.style.background='linear-gradient(135deg, #a85d68 0%, #b76e79 100%)'">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Çıkış Yap
                            </button>
                        </form>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" onclick="toggleMobileMenu()" class="text-gray-600 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-xl transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 py-4">
                    <div class="space-y-2">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           class="{{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                            </svg>
                            Kullanıcılar
                        </a>
                        
                        <a href="{{ route('admin.spam.index') }}" 
                           class="{{ request()->routeIs('admin.spam.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Spam Yönetimi
                            @if($spamCount > 0)
                                <span class="ml-auto bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                                    {{ $spamCount > 9 ? '9+' : $spamCount }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.reports.index') }}" 
                           class="{{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} relative flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Bildiriler
                            @if($pendingCount > 0)
                                <span class="ml-auto text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" style="background-color: #a85d68;">
                                    {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.whatsapp.index') }}" 
                           class="{{ request()->routeIs('admin.whatsapp.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h2m2-4h6a2 2 0 012 2v6a2 2 0 01-2 2h-2l-4 4v-4H9a2 2 0 01-2-2V6a2 2 0 012-2z"></path>
                            </svg>
                            WhatsApp Grupları
                        </a>
                        
                        <a href="{{ route('admin.settings.index') }}" 
                           class="{{ request()->routeIs('admin.settings.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Site Ayarları
                        </a>
                        
                        <!-- Web sitesine dön butonu (mobile) -->
                        <a href="{{ route('home') }}" 
                           class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 border border-gray-300 rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Web Sitesine Dön
                        </a>
                        
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex items-center px-4 py-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-semibold" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                            </div>
                            
                            <form method="POST" action="{{ route('admin.logout') }}" class="px-4">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium text-white rounded-xl shadow-sm transition-all duration-200"
                                        style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Çıkış Yap
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            @if(session('success'))
                <div id="flash-success" class="fixed top-4 right-4 z-50">
                    <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 min-w-80">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                        <button onclick="closeFlashMessage('flash-success')" class="ml-auto text-white hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div id="flash-error" class="fixed top-4 right-4 z-50">
                    <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 min-w-80">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                        <button onclick="closeFlashMessage('flash-error')" class="ml-auto text-white hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div id="flash-warning" class="fixed top-4 right-4 z-50">
                    <div class="bg-yellow-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 min-w-80">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="font-medium">{{ session('warning') }}</span>
                        <button onclick="closeFlashMessage('flash-warning')" class="ml-auto text-white hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <script>
        function closeFlashMessage(id) {
            document.getElementById(id).style.display = 'none';
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('[id^="flash-"]');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.opacity = '0';
                    message.style.transform = 'translateX(100%)';
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html> 