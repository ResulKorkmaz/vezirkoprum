<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-rose-100">
                <div class="p-8 text-gray-900">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            <span class="bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                                KVKK Aydınlatma Metni
                            </span>
                        </h1>
                        <p class="text-gray-600">Kişisel Verilerin Korunması Kanunu Kapsamında Aydınlatma</p>
                        <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>
                    </div>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Veri Sorumlusu</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, 
                            Vezirköprü Hemşehrileri platformu veri sorumlusu sıfatıyla, 
                            kişisel verilerinizin işlenmesine ilişkin olarak sizi bilgilendirmektedir.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">2. İşlenen Kişisel Veriler</h2>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">2.1 Kimlik Verileri</h3>
                        <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                            <li>Ad, soyad</li>
                            <li>E-posta adresi</li>
                            <li>Telefon numarası (isteğe bağlı)</li>
                            <li>Profil fotoğrafı (isteğe bağlı)</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-3">2.2 İletişim Verileri</h3>
                        <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                            <li>Şehir ve ilçe bilgisi</li>
                            <li>Meslek bilgisi</li>
                            <li>Biyografi (isteğe bağlı)</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-3">2.3 Teknik Veriler</h3>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>IP adresi</li>
                            <li>Çerez verileri</li>
                            <li>Tarayıcı bilgileri</li>
                            <li>Cihaz bilgileri</li>
                            <li>Platform kullanım verileri</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Kişisel Verilerin İşlenme Amaçları</h2>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Kullanıcı hesabı oluşturma ve yönetimi</li>
                            <li>Hemşehri bağlantıları kurma hizmeti sunma</li>
                            <li>Mesajlaşma ve iletişim hizmetleri</li>
                            <li>Platform güvenliğini sağlama</li>
                            <li>Hizmet kalitesini geliştirme</li>
                            <li>İstatistiksel analiz yapma</li>
                            <li>Yasal yükümlülükleri yerine getirme</li>
                            <li>Kullanıcı deneyimini iyileştirme</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Kişisel Verilerin İşlenme Hukuki Sebepleri</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kişisel verileriniz KVKK'nın 5. maddesinde belirtilen aşağıdaki hukuki sebeplere dayanılarak işlenmektedir:
                        </p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Açık rızanızın bulunması</li>
                            <li>Sözleşmenin kurulması veya ifasıyla doğrudan doğruya ilgili olması</li>
                            <li>Veri sorumlusunun hukuki yükümlülüğünü yerine getirebilmesi</li>
                            <li>Veri sorumlusunun meşru menfaatleri</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Kişisel Verilerin Aktarılması</h2>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">5.1 Yurt İçi Aktarım</h3>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            Kişisel verileriniz, hizmet sağlayıcılar ve iş ortakları ile sınırlı olarak paylaşılabilir:
                        </p>
                        <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                            <li>Teknik hizmet sağlayıcıları</li>
                            <li>Hosting ve bulut hizmet sağlayıcıları</li>
                            <li>Yasal merciler (yasal zorunluluk halinde)</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mb-3">5.2 Yurt Dışı Aktarım</h3>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Kişisel verileriniz, yeterli koruma seviyesine sahip ülkelere veya 
                            uygun güvenceler sağlanarak aktarılabilir.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Kişisel Verilerin Saklanma Süresi</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Kişisel verileriniz, işleme amacının gerektirdiği süre boyunca ve 
                            yasal saklama yükümlülükleri çerçevesinde saklanmaktadır. 
                            Hesabınızı sildiğinizde, verileriniz güvenli şekilde imha edilir.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">7. KVKK Kapsamındaki Haklarınız</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            KVKK'nın 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:
                        </p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
                            <li>Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme</li>
                            <li>Kişisel verilerinizin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
                            <li>Yurt içinde veya yurt dışında kişisel verilerinizin aktarıldığı üçüncü kişileri bilme</li>
                            <li>Kişisel verilerinizin eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini isteme</li>
                            <li>KVKK'nın 7. maddesinde öngörülen şartlar çerçevesinde kişisel verilerinizin silinmesini veya yok edilmesini isteme</li>
                            <li>Düzeltme, silme ve yok etme işlemlerinin kişisel verilerin aktarıldığı üçüncü kişilere bildirilmesini isteme</li>
                            <li>İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle kişinin kendisi aleyhine bir sonucun ortaya çıkmasına itiraz etme</li>
                            <li>Kişisel verilerinizin kanuna aykırı olarak işlenmesi sebebiyle zarara uğraması hâlinde zararın giderilmesini talep etme</li>
                        </ul>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Haklarınızı Kullanma Yolları</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed">
                            KVKK kapsamındaki haklarınızı kullanmak için:
                        </p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
                            <li>Platform üzerindeki iletişim formu aracılığıyla</li>
                            <li>Kimliğinizi tespit edici belgeler ile birlikte yazılı olarak</li>
                            <li>Güvenli elektronik imza ile</li>
                        </ul>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Başvurularınız en geç 30 gün içinde değerlendirilecek ve sonuçlandırılacaktır.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Çerezler (Cookies)</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Platformumuz, kullanıcı deneyimini iyileştirmek amacıyla çerezler kullanmaktadır. 
                            Çerez kullanımını tarayıcı ayarlarınızdan kontrol edebilirsiniz.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Güvenlik Önlemleri</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Kişisel verilerinizin güvenliği için teknik ve idari güvenlik önlemleri alınmaktadır. 
                            Veriler şifrelenmiş olarak saklanır ve yetkisiz erişimlere karşı korunur.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">11. İletişim Bilgileri</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            KVKK kapsamındaki haklarınızı kullanmak veya sorularınız için 
                            platform üzerindeki iletişim formu aracılığıyla bizimle iletişime geçebilirsiniz.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Aydınlatma Metninin Güncellenmesi</h2>
                        <p class="mb-6 text-gray-700 leading-relaxed">
                            Bu aydınlatma metni gerektiğinde güncellenebilir. 
                            Güncellemeler platform üzerinden duyurulacaktır.
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