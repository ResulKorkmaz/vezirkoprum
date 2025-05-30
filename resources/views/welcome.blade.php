<!DOCTYPE html>
<html lang="tr">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vezirköprüm.com.tr</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="/" class="flex items-center py-4">
                            <span class="font-semibold text-blue-600 text-2xl">Vezirköprüm</span>
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    <a href="/login" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-gray-300 hover:text-gray-900 transition duration-300">Giriş Yap</a>
                    <a href="/register" class="py-2 px-4 font-medium text-white bg-blue-600 rounded hover:bg-blue-500 transition duration-300">Kayıt Ol</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Vezirköprüm Topluluğu</h1>
            <p class="text-xl md:text-2xl mb-8">Vezirköprü'den olan ve farklı şehirlerde yaşayan hemşehrilerimizin buluşma noktası</p>
            <a href="/register" class="bg-white text-blue-600 font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition duration-300 text-lg">
                Hemen Katıl
            </a>
        </div>
    </div>

    <!-- Features -->
    <div class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Neler Yapabilirsiniz?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0H21v-1a6 6 0 00-9-5.197"></path>
                                    </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Hemşehrileri Bul</h3>
                    <p class="text-gray-600">Hangi şehirde yaşadığınızı ve mesleğinizi paylaşarak yakınınızdaki hemşehrilerinizi bulun.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Mesajlaşın</h3>
                    <p class="text-gray-600">Site içi mesajlaşma sistemi ile hemşehrilerinizle güvenli bir şekilde iletişim kurun.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">WhatsApp Grupları</h3>
                    <p class="text-gray-600">Şehir bazlı WhatsApp gruplarına katılarak daha hızlı iletişim kurun.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Topluluk İstatistikleri</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="text-3xl font-bold text-blue-600">{{ \App\Models\User::count() }}</div>
                        <div class="text-gray-600">Kayıtlı Üye</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-green-600">{{ \App\Models\User::whereNotNull('current_city')->distinct('current_city')->count() }}</div>
                        <div class="text-gray-600">Şehir</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-yellow-600">{{ \App\Models\Profession::where('is_active', true)->count() }}</div>
                        <div class="text-gray-600">Meslek</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-purple-600">{{ \App\Models\WhatsappGroup::where('is_active', true)->count() }}</div>
                        <div class="text-gray-600">WhatsApp Grubu</div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>&copy; 2025 Vezirköprüm.com.tr - Tüm hakları saklıdır.</p>
        </div>
    </footer>
    </body>
</html>
