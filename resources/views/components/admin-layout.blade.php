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
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Admin Navigation -->
        <nav class="bg-gray-800 border-b border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-white text-xl font-bold">Admin Panel</h1>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="{{ request()->routeIs('admin.dashboard') ? 'border-indigo-400 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                               class="{{ request()->routeIs('admin.users.*') ? 'border-indigo-400 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Kullanıcılar
                            </a>
                            <a href="{{ route('admin.reports.index') }}" 
                               class="{{ request()->routeIs('admin.reports.*') ? 'border-indigo-400 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} relative inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Bildiriler
                                @php
                                    $pendingCount = \App\Models\Report::where('status', 'pending')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold">
                                        {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('admin.whatsapp.index') }}" 
                               class="{{ request()->routeIs('admin.whatsapp.*') ? 'border-indigo-400 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                WhatsApp Grupları
                            </a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-300 text-sm">{{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                        Çıkış Yap
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html> 