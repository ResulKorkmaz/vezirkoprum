<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#B76E79] to-[#A85D68] px-8 py-6">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <h1 class="text-2xl font-bold text-white">Yeni Paylaşım Oluştur</h1>
            </div>
            <p class="text-white/90 mt-2">Düşüncelerinizi, deneyimlerinizi hemşehrilerimizle paylaşın</p>
        </div>

        <!-- Form Content -->
        <div class="p-8">
            <!-- Günlük Limit Bilgisi -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-blue-800 font-medium">
                        Kalan paylaşım hakkınız: <span id="remaining-posts">{{ $remainingPosts }}</span>/3
                    </span>
                </div>
                <p class="text-blue-700 text-sm mt-2">Günde en fazla 3 paylaşım yapabilirsiniz. Her gece 00:00'da sayaç sıfırlanır.</p>
            </div>

            <!-- Paylaşım Formu -->
            <form id="post-form" class="space-y-6">
                @csrf
                
                <!-- İçerik Alanı -->
                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700 mb-3">
                        Paylaşım İçeriği
                    </label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="6" 
                        class="w-full border-2 border-gray-200 rounded-xl shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-all duration-200 py-4 px-4 text-gray-900 bg-white hover:border-gray-300 resize-none" 
                        placeholder="Düşüncelerinizi, deneyimlerinizi veya anılarınızı paylaşın... Örneğin: Vezirköprü'deki güzel anılarımdan bahsetmek istiyorum..."
                        maxlength="500"
                        required
                    ></textarea>
                    
                    <!-- Karakter Sayacı -->
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm text-gray-500">Minimum 10 karakter</span>
                        <span id="char-count" class="text-sm text-gray-500">0/500</span>
                    </div>
                </div>

                <!-- reCAPTCHA v3 (Arka planda çalışır, görünmez) -->
                <div class="flex justify-center">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex items-center text-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">Bu site reCAPTCHA v3 ile korunmaktadır</span>
                        </div>
                    </div>
                </div>

                <!-- Butonlar -->
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 pt-6">
                    <a href="{{ route('posts.index') }}" 
                       class="inline-flex items-center px-6 py-3 text-gray-700 text-base font-semibold rounded-xl border-2 border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Geri Dön
                    </a>
                    
                    <button type="submit" 
                            id="submit-btn"
                            class="inline-flex items-center px-8 py-3 text-white text-base font-bold rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" 
                            style="background: linear-gradient(to right, #B76E79, #A85D68);" 
                            onmouseover="if(!this.disabled) this.style.background='linear-gradient(to right, #A85D68, #9A5460)'" 
                            onmouseout="if(!this.disabled) this.style.background='linear-gradient(to right, #B76E79, #A85D68)'"
                            disabled>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <span id="submit-text">Paylaşımı Yayınla</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Başarılı Paylaşım Mesajı -->
    <div id="success-message" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-8 py-6 rounded-2xl shadow-2xl z-50 border-4 border-green-400">
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">🎉 Başarılı!</h3>
            <p class="text-lg">Paylaşımınız başarıyla gönderildi!</p>
            <p class="text-sm opacity-90 mt-1">Hemşehrilerimiz paylaşımınızı görebilir.</p>
        </div>
    </div>
</div>

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}" async defer></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - Script başlatıldı');
        
        const form = document.getElementById('post-form');
        const contentTextarea = document.getElementById('content');
        const charCount = document.getElementById('char-count');
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const remainingPostsSpan = document.getElementById('remaining-posts');
        const successMessage = document.getElementById('success-message');
        
        console.log('Form elementi:', form);
        console.log('Submit butonu:', submitBtn);
        
        // Karakter sayacı
        contentTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length + '/500';
            console.log('Karakter sayısı:', length);
            
            // Buton durumu
            if (length >= 10 && length <= 500) {
                submitBtn.disabled = false;
                charCount.classList.remove('text-red-500');
                charCount.classList.add('text-gray-500');
                console.log('Buton aktif edildi');
            } else {
                submitBtn.disabled = true;
                if (length > 500) {
                    charCount.classList.remove('text-gray-500');
                    charCount.classList.add('text-red-500');
                }
                console.log('Buton pasif edildi');
            }
        });
        
        // Form gönderimi
        form.addEventListener('submit', async function(e) {
            console.log('Form submit edildi');
            e.preventDefault();
            
            // reCAPTCHA v3 token al
            let recaptchaResponse = '';
            try {
                recaptchaResponse = await grecaptcha.execute('{{ config('recaptcha.site_key') }}', {action: 'post_create'});
                console.log('reCAPTCHA v3 token alındı');
            } catch (error) {
                console.log('reCAPTCHA v3 token alınamadı:', error);
            }
            
            // Buton durumunu değiştir
            submitBtn.disabled = true;
            submitText.textContent = 'Gönderiliyor...';
            console.log('Buton durumu değiştirildi');
            
            try {
                const formData = new FormData();
                formData.append('content', contentTextarea.value);
                formData.append('recaptcha_token', recaptchaResponse);
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                
                console.log('Form data hazırlandı:', contentTextarea.value);
                
                const response = await fetch('{{ route("posts.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                console.log('Response alındı:', response.status);
                
                const data = await response.json();
                console.log('Response data:', data);
                
                if (data.success) {
                    // Büyük başarı mesajı göster
                    alert('🎉 Paylaşımınız başarıyla gönderildi!\n\nHemşehrilerimiz paylaşımınızı görebilir.');
                    
                    // Başarı kutucuğu da göster
                    successMessage.classList.remove('hidden');
                    setTimeout(() => {
                        successMessage.classList.add('hidden');
                    }, 5000);
                    
                    // Formu temizle
                    contentTextarea.value = '';
                    charCount.textContent = '0/500';
                    
                    // reCAPTCHA v3'te reset gerekmiyor (otomatik)
                    
                    // Kalan paylaşım sayısını güncelle
                    remainingPostsSpan.textContent = data.remaining_posts;
                    
                    // Eğer limit dolmuşsa sayfayı yönlendir
                    if (data.remaining_posts <= 0) {
                        alert('Günlük paylaşım limitiniz doldu. Yarın tekrar paylaşım yapabilirsiniz.');
                        setTimeout(() => {
                            window.location.href = '{{ route("posts.index") }}';
                        }, 2000);
                    }
                    
                } else {
                    alert('❌ ' + (data.message || 'Bir hata oluştu. Lütfen tekrar deneyin.'));
                }
                
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Bir hata oluştu. Lütfen internet bağlantınızı kontrol edip tekrar deneyin.');
            } finally {
                submitBtn.disabled = contentTextarea.value.length < 10;
                submitText.textContent = 'Paylaşımı Yayınla';
                console.log('Form işlemi tamamlandı');
            }
        });
        
        // Buton click debug
        submitBtn.addEventListener('click', function() {
            console.log('Submit butonu tıklandı');
        });
    });
    </script>
</x-app-layout> 