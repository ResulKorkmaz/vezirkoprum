<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bildirim Ayarları') }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Bildirim Türleri</h3>
                        <p class="text-gray-600 text-sm">Hangi durumlarda bildirim almak istediğinizi seçin.</p>
                    </div>

                    <form method="POST" action="{{ route('notifications.update-settings') }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <!-- E-posta Bildirimleri -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">E-posta Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Önemli bildirimler için e-posta gönderilsin</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="email_notifications" 
                                           value="1"
                                           {{ $settings['email_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-rose-600"></div>
                                </label>
                            </div>

                            <!-- Beğeni Bildirimleri -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Beğeni Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Paylaşımlarınız beğenildiğinde bildirim alın</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="like_notifications" 
                                           value="1"
                                           {{ $settings['like_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-rose-600"></div>
                                </label>
                            </div>

                            <!-- Yorum Bildirimleri -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Yorum Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Paylaşımlarınıza yorum yapıldığında bildirim alın</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="comment_notifications" 
                                           value="1"
                                           {{ $settings['comment_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-rose-600"></div>
                                </label>
                            </div>

                            <!-- Mesaj Bildirimleri -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Mesaj Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Yeni mesaj aldığınızda bildirim alın</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="message_notifications" 
                                           value="1"
                                           {{ $settings['message_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-rose-600"></div>
                                </label>
                            </div>

                            <!-- Takip Bildirimleri -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Takip Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Yeni takipçileriniz için bildirim alın</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="follow_notifications" 
                                           value="1"
                                           {{ $settings['follow_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-rose-600"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('notifications.index') }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                ← Geri Dön
                            </a>
                            
                            <button type="submit" 
                                    class="px-6 py-2 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 transition-colors duration-200">
                                Ayarları Kaydet
                            </button>
                        </div>
                    </form>

                    <!-- Bilgi Kutusu -->
                    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Bildirim Ayarları Hakkında</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc space-y-1 ml-5">
                                        <li>Bu ayarlar sadece web sitesi bildirimlerini etkiler.</li>
                                        <li>E-posta bildirimleri sadece önemli durumlarda gönderilir.</li>
                                        <li>İstediğiniz zaman bu ayarları değiştirebilirsiniz.</li>
                                        <li>Sistem bildirimleri her zaman aktiftir ve kapatılamaz.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 