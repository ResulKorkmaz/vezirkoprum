<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email or Phone -->
        <div>
            <x-input-label for="login" value="E-posta veya Telefon" />
            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="ornek@email.com veya 0555 123 45 67" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Şifre" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-rose-600 shadow-sm focus:ring-rose-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Beni hatırla</span>
            </label>
        </div>

        <!-- reCAPTCHA -->
        <div class="mt-4">
            <x-recaptcha action="login" />
            <x-input-error :messages="$errors->get('recaptcha_token')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center space-x-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500" href="{{ route('password.request') }}">
                        Şifrenizi unuttunuz mu?
                    </a>
                @endif
                
                @if (Route::has('register'))
                    <span class="text-gray-400">|</span>
                    <a class="underline text-sm text-rose-600 hover:text-rose-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 font-medium" href="{{ route('register') }}">
                        Hesap Oluştur
                    </a>
                @endif
            </div>

            <x-primary-button class="ms-3" id="loginSubmitBtn">
                Giriş Yap
            </x-primary-button>
        </div>
    </form>

    <!-- Register Call to Action -->
    <div class="mt-6 text-center">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Henüz hesabınız yok mu?</span>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-rose-600 hover:to-pink-600 focus:from-rose-600 focus:to-pink-600 active:from-rose-700 active:to-pink-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Hemen Kaydol
            </a>
        </div>
    </div>

    <script>
        // Form submit'te reCAPTCHA token ekle
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('loginSubmitBtn');
            const originalText = submitBtn.innerHTML;
            
            // Buton durumunu değiştir
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Giriş Yapılıyor...';
            
            try {
                // reCAPTCHA token ekle
                await addRecaptchaToForm(this, 'login');
                
                // Formu gönder
                this.submit();
            } catch (error) {
                console.error('reCAPTCHA error:', error);
                showModernToast('🔒 Güvenlik doğrulaması başarısız. Lütfen tekrar deneyin.', 'error');
                
                // Buton durumunu eski haline getir
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    </script>
</x-guest-layout>
