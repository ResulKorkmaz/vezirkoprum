<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-rose-100">
                <div class="p-8 text-gray-900">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            <span class="bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                                Gizlilik Politikası
                            </span>
                        </h1>
                        <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>
                    </div>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Giriş</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Vezirköprü Hemşehrileri platformu olarak, kullanıcılarımızın gizliliğini korumak en önemli önceliklerimizden biridir. 
                            Bu Gizlilik Politikası, kişisel verilerinizin nasıl toplandığını, kullanıldığını, saklandığını ve korunduğunu açıklamaktadır.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Toplanan Bilgiler</h2>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">2.1 Kişisel Bilgiler</h3>
                        <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                            <li>Ad ve soyad</li>
                            <li>E-posta adresi</li>
                            <li>Telefon numarası (isteğe bağlı)</li>
                            <li>Profil fotoğrafı (isteğe bağlı)</li>
                            <li>Meslek bilgisi</li>
                            <li>Şehir ve ilçe bilgisi</li>
                            <li>Biyografi (isteğe bağlı)</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-3">2.2 Teknik Bilgiler</h3>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>IP adresi</li>
                            <li>Tarayıcı bilgileri</li>
                            <li>Cihaz bilgileri</li>
                            <li>Çerezler (cookies)</li>
                            <li>Site kullanım istatistikleri</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Bilgilerin Kullanım Amaçları</h2>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Kullanıcı hesabı oluşturma ve yönetme</li>
                            <li>Hemşehri bağlantıları kurma</li>
                            <li>Mesajlaşma hizmetleri sunma</li>
                            <li>Platform güvenliğini sağlama</li>
                            <li>Hizmet kalitesini artırma</li>
                            <li>Yasal yükümlülükleri yerine getirme</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Bilgi Paylaşımı</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kişisel bilgileriniz, açık rızanız olmadan üçüncü taraflarla paylaşılmaz. 
                            Ancak aşağıdaki durumlarda bilgi paylaşımı yapılabilir:
                        </p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Yasal zorunluluklar</li>
                            <li>Mahkeme kararları</li>
                            <li>Güvenlik tehditleri</li>
                            <li>Platform kurallarının ihlali</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Veri Güvenliği</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Kişisel verilerinizin güvenliği için endüstri standardı güvenlik önlemleri alınmaktadır. 
                            Veriler şifrelenmiş olarak saklanır ve yetkisiz erişimlere karşı korunur.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Çerezler (Cookies)</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Sitemiz, kullanıcı deneyimini iyileştirmek için çerezler kullanmaktadır. 
                            Çerezleri tarayıcı ayarlarınızdan kontrol edebilirsiniz.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Kullanıcı Hakları</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">KVKK kapsamında aşağıdaki haklarınız bulunmaktadır:</p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
                            <li>İşlenen verileriniz hakkında bilgi talep etme</li>
                            <li>Verilerin düzeltilmesini isteme</li>
                            <li>Verilerin silinmesini isteme</li>
                            <li>Veri işlemeye itiraz etme</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">8. İletişim</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Gizlilik politikamız hakkında sorularınız için iletişim formumuz aracılığıyla bizimle iletişime geçebilirsiniz.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Politika Güncellemeleri</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Bu gizlilik politikası gerektiğinde güncellenebilir. 
                            Önemli değişiklikler kullanıcılarımıza bildirilecektir.
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