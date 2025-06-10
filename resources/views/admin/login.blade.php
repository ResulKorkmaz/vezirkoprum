<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Giriş - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-rose-50 via-white to-pink-50 min-h-screen">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="flex items-center">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-100 rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden mr-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Vezirköprü Logo" class="w-14 h-14 object-contain">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>
                    <p class="text-gray-600">Vezirköprü Hemşehrileri</p>
                </div>
            </a>
        </div>

        <!-- Login Form -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-2xl border border-rose-100">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Admin Girişi</h2>
                <p class="text-gray-600">Yönetici paneline erişmek için giriş yapın</p>
            </div>

            <!-- Session Status -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kullanıcı Adı
                    </label>
                    <input id="username" 
                           type="text" 
                           name="username" 
                           value="{{ old('username') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors @error('username') border-red-300 @enderror"
                           placeholder="Kullanıcı adınızı girin">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Şifre
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors @error('password') border-red-300 @enderror"
                           placeholder="Şifrenizi girin">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <button type="submit" 
                            class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Giriş Yap
                    </button>
                </div>
            </form>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" 
                   class="text-rose-600 hover:text-rose-700 font-semibold text-sm transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Ana Sayfaya Dön
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} Vezirköprü Hemşehrileri. Tüm hakları saklıdır.</p>
        </div>
    </div>
</body>
</html> 