@props(['action' => 'submit', 'callback' => null])

@php
    $recaptchaService = app(\App\Services\RecaptchaService::class);
    $siteKey = $recaptchaService->getSiteKey();
    $enabled = $recaptchaService->isEnabled();
@endphp

@if($enabled)
    <!-- reCAPTCHA v3 Script -->
    @once
        <script src="https://www.google.com/recaptcha/api.js?render={{ $siteKey }}"></script>
        <script>
            window.recaptchaReady = false;
            
            // reCAPTCHA yüklendiğinde
            grecaptcha.ready(function() {
                window.recaptchaReady = true;
                console.log('reCAPTCHA v3 loaded successfully');
            });

            // reCAPTCHA token al
            async function getRecaptchaToken(action = 'submit') {
                console.log('getRecaptchaToken called with action:', action);
                console.log('window.recaptchaReady:', window.recaptchaReady);
                console.log('typeof grecaptcha:', typeof grecaptcha);
                
                if (!window.recaptchaReady) {
                    console.warn('reCAPTCHA not ready yet');
                    return null;
                }

                try {
                    console.log('Executing grecaptcha with siteKey:', '{{ $siteKey }}');
                    const token = await grecaptcha.execute('{{ $siteKey }}', { action: action });
                    console.log('Token received:', token ? token.substring(0, 50) + '...' : 'null');
                    
                    // Test keys için özel handling
                    if (!token && '{{ $siteKey }}' === '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI') {
                        console.log('Using test token for development');
                        return '03AGdBq25SIVyGtsVmcSpeGcf5-wrsCgGWmJGusG9IuI9k5FI2fqFuBCNg';
                    }
                    
                    return token;
                } catch (error) {
                    console.error('grecaptcha.execute error:', error);
                    
                    // Test keys için fallback
                    if ('{{ $siteKey }}' === '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI') {
                        console.log('Using fallback test token');
                        return '03AGdBq25SIVyGtsVmcSpeGcf5-wrsCgGWmJGusG9IuI9k5FI2fqFuBCNg';
                    }
                    
                    return null;
                }
            }

            // Form submit'te reCAPTCHA token ekle
            function addRecaptchaToForm(form, action = 'submit') {
                return new Promise(async (resolve, reject) => {
                    try {
                        const token = await getRecaptchaToken(action);
                        
                        if (!token) {
                            reject('reCAPTCHA token alınamadı');
                            return;
                        }

                        // Mevcut token input'unu kaldır
                        const existingInput = form.querySelector('input[name="recaptcha_token"]');
                        if (existingInput) {
                            existingInput.remove();
                        }

                        // Yeni token input'u ekle
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'recaptcha_token';
                        input.value = token;
                        form.appendChild(input);

                        resolve(token);
                    } catch (error) {
                        reject(error);
                    }
                });
            }
        </script>
    @endonce

    <!-- reCAPTCHA Hidden Input -->
    <input type="hidden" name="recaptcha_token" id="recaptcha_token_{{ $action }}" value="">

    <!-- reCAPTCHA Badge Styling -->
    @once
        <style>
            .grecaptcha-badge {
                visibility: hidden;
            }
        </style>
    @endonce

    <!-- reCAPTCHA Privacy Notice -->
    <div class="text-xs text-gray-500 mt-2">
        Bu site Google reCAPTCHA ile korunmaktadır. Google'ın 
        <a href="https://policies.google.com/privacy" target="_blank" class="text-blue-600 hover:underline">Gizlilik Politikası</a> 
        ve 
        <a href="https://policies.google.com/terms" target="_blank" class="text-blue-600 hover:underline">Hizmet Şartları</a> 
        geçerlidir.
    </div>

    @if($callback)
        <script>
            // Özel callback fonksiyonu
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof {{ $callback }} === 'function') {
                    grecaptcha.ready(function() {
                        {{ $callback }}();
                    });
                }
            });
        </script>
    @endif
@else
    <!-- reCAPTCHA devre dışı -->
    <input type="hidden" name="recaptcha_token" value="disabled">
@endif 