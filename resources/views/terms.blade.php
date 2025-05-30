<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-rose-100">
                <div class="p-8 text-gray-900">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            <span class="bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                                Kullanım Şartları
                            </span>
                        </h1>
                        <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>
                    </div>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Genel Hükümler</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Bu kullanım şartları, Vezirköprü Hemşehrileri platformunu kullanan tüm kullanıcılar için geçerlidir. 
                            Platforma kayıt olarak bu şartları kabul etmiş sayılırsınız.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Platform Amacı</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Vezirköprü Hemşehrileri platformu, Vezirköprü'den olan hemşehrilerimizi bir araya getirmek, 
                            iletişim kurmalarını sağlamak ve güçlü bir topluluk oluşturmak amacıyla kurulmuştur.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Kullanıcı Yükümlülükleri</h2>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">3.1 Genel Yükümlülükler</h3>
                        <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                            <li>Doğru ve güncel bilgiler sağlamak</li>
                            <li>Hesap güvenliğini korumak</li>
                            <li>Platform kurallarına uymak</li>
                            <li>Diğer kullanıcılara saygılı davranmak</li>
                            <li>Yasal düzenlemelere uymak</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-3">3.2 Yasak Davranışlar</h3>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Sahte bilgi paylaşmak</li>
                            <li>Spam veya istenmeyen mesajlar göndermek</li>
                            <li>Hakaret, küfür veya ayrımcılık yapmak</li>
                            <li>Telif hakkı ihlali yapmak</li>
                            <li>Zararlı yazılım paylaşmak</li>
                            <li>Ticari amaçlı kullanım (izin alınmadıkça)</li>
                            <li>Başka kullanıcıların hesaplarına yetkisiz erişim</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Hesap Yönetimi</h2>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">4.1 Hesap Oluşturma</h3>
                        <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                            <li>18 yaşından büyük olmalısınız</li>
                            <li>Gerçek kimlik bilgilerinizi kullanmalısınız</li>
                            <li>Sadece bir hesap oluşturabilirsiniz</li>
                            <li>E-posta adresinizi doğrulamalısınız</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-3">4.2 Hesap Güvenliği</h3>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Güçlü şifre kullanın</li>
                            <li>Şifrenizi kimseyle paylaşmayın</li>
                            <li>Şüpheli aktiviteleri bildirin</li>
                            <li>Hesabınızdan çıkış yapmayı unutmayın</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">5. İçerik Politikası</h2>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">5.1 Paylaşılan İçerik</h3>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Platformda paylaştığınız tüm içeriklerden siz sorumlusunuz. İçerikleriniz:
                        </p>
                        <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                            <li>Yasal olmalı</li>
                            <li>Doğru ve yanıltıcı olmamalı</li>
                            <li>Başkalarının haklarını ihlal etmemeli</li>
                            <li>Toplum ahlakına uygun olmalı</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-3">5.2 İçerik Moderasyonu</h3>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Platform yönetimi, kurallara aykırı içerikleri kaldırma, kullanıcı hesaplarını askıya alma 
                            veya kapatma hakkını saklı tutar.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Gizlilik ve Veri Koruma</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Kişisel verilerinizin korunması konusunda detaylı bilgi için 
                            <a href="{{ route('privacy') }}" class="text-rose-600 hover:text-rose-700 font-semibold">Gizlilik Politikamızı</a> 
                            inceleyiniz.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Fikri Mülkiyet</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Platform tasarımı, logosu, yazılımı ve içeriği telif hakkı ile korunmaktadır. 
                            İzinsiz kullanım yasaktır.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Sorumluluk Reddi</h2>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Platform "olduğu gibi" sunulmaktadır</li>
                            <li>Kesintisiz hizmet garantisi verilmez</li>
                            <li>Kullanıcı içeriklerinden sorumluluk alınmaz</li>
                            <li>Üçüncü taraf bağlantılarından sorumluluk alınmaz</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Hesap Sonlandırma</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Aşağıdaki durumlarda hesabınız sonlandırılabilir:
                        </p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Kullanım şartlarının ihlali</li>
                            <li>Yasadışı faaliyetler</li>
                            <li>Diğer kullanıcılara zarar verme</li>
                            <li>Uzun süre pasif kalma</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Değişiklikler</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Bu kullanım şartları gerektiğinde güncellenebilir. 
                            Önemli değişiklikler kullanıcılara bildirilecektir.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Uygulanacak Hukuk</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Bu şartlar Türkiye Cumhuriyeti kanunlarına tabidir. 
                            Uyuşmazlıklar Türkiye mahkemelerinde çözülecektir.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">12. İletişim</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Kullanım şartları hakkında sorularınız için iletişim formumuz aracılığıyla bizimle iletişime geçebilirsiniz.
                        </p>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Ana Sayfaya Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 