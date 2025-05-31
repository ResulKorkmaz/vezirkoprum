<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <!-- Ana Footer İçeriği -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Logo ve Açıklama -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-100 rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden mr-3">
                                <img src="{{ asset('images/logo.png') }}" alt="Vezirköprü Logo" class="w-11 h-11 object-contain">
                            </div>
                            <h3 class="text-2xl font-bold text-white">Vezirköprü Hemşehrileri</h3>
                        </div>
                        <p class="text-gray-300 mb-6 max-w-md leading-relaxed">
                            Vezirköprü'den olan hemşehrilerimizi bir araya getiren, güçlü bir topluluk oluşturmayı hedefliyoruz. 
                            Birbirimize destek olarak, hemşehrilik bağlarımızı güçlendiriyoruz.
                        </p>
                        <div class="flex space-x-4">
                            <!-- Sosyal Medya İkonları - Sadece Instagram ve Facebook -->
                            <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-rose-600 rounded-full flex items-center justify-center transition-colors duration-200">
                                <!-- Instagram Icon -->
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-rose-600 rounded-full flex items-center justify-center transition-colors duration-200">
                                <!-- Facebook Icon -->
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Hızlı Linkler -->
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Hızlı Linkler</h4>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('home') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Ana Sayfa
                                </a>
                            </li>
                            @auth
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profilim
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('messages.index') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        Mesajlarım
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('whatsapp.index') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                        </svg>
                                        WhatsApp Grupları
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        Giriş Yap
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        Kayıt Ol
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>

                    <!-- İletişim -->
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">İletişim</h4>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-rose-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-gray-300">Vezirköprü, Samsun</p>
                                    <p class="text-gray-400 text-sm">Türkiye</p>
                                </div>
                            </div>
                            
                            <!-- İletişim Formu Butonu -->
                            <button onclick="openContactModal()" class="w-full bg-rose-600 hover:bg-rose-700 text-white px-4 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                İletişim Formu
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alt Footer -->
            <div class="border-t border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="flex justify-center md:order-2">
                            <div class="text-center">
                                <p class="text-gray-400 text-sm">
                                    © {{ date('Y') }} Vezirköprü Hemşehrileri. Tüm hakları saklıdır.
                                </p>
                                <p class="text-gray-400 text-sm mt-2">
                                    <a href="https://www.resulkorkmaz.com" target="_blank" rel="noopener noreferrer" 
                                       class="text-rose-400 hover:text-rose-300 transition-colors duration-200 font-medium">
                                        RK Dijital Reklam Ajansı
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-center md:mt-0 md:order-1">
                            <div class="flex space-x-6">
                                <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-rose-400 text-sm transition-colors duration-200">
                                    Gizlilik Politikası
                                </a>
                                <a href="{{ route('terms') }}" class="text-gray-400 hover:text-rose-400 text-sm transition-colors duration-200">
                                    Kullanım Şartları
                                </a>
                                <a href="{{ route('kvkk') }}" class="text-gray-400 hover:text-rose-400 text-sm transition-colors duration-200">
                                    KVKK
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- İletişim Modal -->
        <div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 text-rose-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            İletişim Formu
                        </h3>
                        <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Contact Form -->
                    <form id="contactForm" onsubmit="submitContactForm(event)">
                        <div class="space-y-4">
                            <!-- Ad Soyad -->
                            <div>
                                <label for="contact_name" class="block text-sm font-semibold text-gray-700 mb-2">Ad Soyad *</label>
                                <input type="text" id="contact_name" name="name" required 
                                       class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors"
                                       placeholder="Adınız ve soyadınız">
                            </div>

                            <!-- E-posta -->
                            <div>
                                <label for="contact_email" class="block text-sm font-semibold text-gray-700 mb-2">E-posta *</label>
                                <input type="email" id="contact_email" name="email" required 
                                       class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors"
                                       placeholder="ornek@email.com">
                            </div>

                            <!-- Konu -->
                            <div>
                                <label for="contact_subject" class="block text-sm font-semibold text-gray-700 mb-2">Konu *</label>
                                <input type="text" id="contact_subject" name="subject" required 
                                       class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors"
                                       placeholder="Mesajınızın konusu">
                            </div>

                            <!-- Mesaj -->
                            <div>
                                <label for="contact_message" class="block text-sm font-semibold text-gray-700 mb-2">Mesajınız *</label>
                                <textarea id="contact_message" name="message" rows="5" required 
                                          class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors"
                                          placeholder="Mesajınızı buraya yazın..."></textarea>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="flex space-x-3 mt-6">
                            <button type="button" onclick="closeContactModal()" 
                                    class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">
                                İptal
                            </button>
                            <button type="submit" 
                                    class="flex-1 px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Gönder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // İletişim Modal Fonksiyonları
            function openContactModal() {
                document.getElementById('contactModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            
            function closeContactModal() {
                document.getElementById('contactModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
                // Formu temizle
                document.getElementById('contactForm').reset();
            }
            
            // Modal dışına tıklandığında kapat
            document.getElementById('contactModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeContactModal();
                }
            });
            
            // ESC tuşu ile kapat
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeContactModal();
                }
            });
            
            // İletişim formu gönderimi
            async function submitContactForm(event) {
                event.preventDefault();
                
                const form = event.target;
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Buton durumunu değiştir
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Gönderiliyor...
                `;
                
                try {
                    const response = await fetch('{{ route("contact.send") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok) {
                        // Başarılı
                        alert('Mesajınız başarıyla gönderildi! En kısa sürede size dönüş yapacağız.');
                        closeContactModal();
                    } else {
                        // Hata
                        alert('Mesaj gönderilirken bir hata oluştu. Lütfen tekrar deneyin.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                } finally {
                    // Buton durumunu eski haline getir
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            }
        </script>
    </body>
</html>
