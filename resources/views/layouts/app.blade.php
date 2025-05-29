<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vezirköprüm.com.tr</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="/" class="flex items-center py-4">
                            <span class="font-semibold text-gray-500 text-lg">Vezirköprüm</span>
                        </a>
                    </div>
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('profile.show', auth()->id()) }}" class="py-4 px-2 text-gray-500 hover:text-gray-900">Profil</a>
                        <a href="{{ route('messages.index') }}" class="py-4 px-2 text-gray-500 hover:text-gray-900">Mesajlar</a>
                        <a href="{{ route('whatsapp_groups.index') }}" class="py-4 px-2 text-gray-500 hover:text-gray-900">WhatsApp Grupları</a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-gray-300 hover:text-gray-900 transition duration-300">Çıkış Yap</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-gray-300 hover:text-gray-900 transition duration-300">Giriş Yap</a>
                        <a href="{{ route('register') }}" class="py-2 px-2 font-medium text-white bg-gray-500 rounded hover:bg-gray-400 transition duration-300">Kayıt Ol</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-6 px-4">
        @yield('content')
    </main>
</body>
</html> 