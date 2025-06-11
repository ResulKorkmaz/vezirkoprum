<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Bildiri Detayı</h1>
                        <p class="text-gray-600 mt-2">Bildiri #{{ $report->id }} - {{ $report->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.reports.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Geri Dön
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Ana İçerik -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Bildiri Bilgileri -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Bildiri Bilgileri</h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $report->status_color }}-100 text-{{ $report->status_color }}-800">
                                    {{ $report->status_text }}
                                </span>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">İçerik Türü</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    @if($report->reportable_type === 'App\Models\Post')
                                        Paylaşım
                                    @elseif($report->reportable_type === 'App\Models\Message')
                                        Mesaj
                                    @else
                                        Kullanıcı
                                    @endif
                                </span>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bildiri Nedeni</label>
                                <p class="text-gray-900">{{ \App\Models\Report::getReasons()[$report->reason] ?? $report->reason }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bildiri Tarihi</label>
                                <p class="text-gray-900">{{ $report->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>

                        @if($report->description)
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $report->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Bildiren Kullanıcı -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Bildiren Kullanıcı</h2>
                        
                        <div class="flex items-center space-x-4">
                            <img class="h-12 w-12 rounded-full object-cover" 
                                 src="{{ $report->reporter->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                 alt="{{ $report->reporter->name }}">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $report->reporter->name }}</h3>
                                <p class="text-gray-600">{{ $report->reporter->email }}</p>
                                <p class="text-sm text-gray-500">Kayıt: {{ $report->reporter->created_at->format('d.m.Y') }}</p>
                            </div>
                        </div>

                        <div class="mt-4 flex space-x-4">
                            <a href="{{ route('admin.users.show', $report->reporter) }}" 
                               class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Profil Detayı
                            </a>
                        </div>
                    </div>

                    <!-- Bildirilen İçerik -->
                    @if($report->reportable)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Bildirilen İçerik</h2>
                        
                        @if($report->reportable_type === 'App\Models\Post')
                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900">Paylaşım</span>
                                        @if(isset($report->reportable->is_active))
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $report->reportable->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $report->reportable->is_active ? 'Aktif' : 'Gizli' }}
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $report->reportable->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <p class="text-gray-900">{{ $report->reportable->content }}</p>
                                
                                <div class="mt-3 flex items-center space-x-2">
                                    <img class="h-6 w-6 rounded-full object-cover" 
                                         src="{{ $report->reportable->user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                         alt="{{ $report->reportable->user->name }}">
                                    <span class="text-sm text-gray-600">{{ $report->reportable->user->name }}</span>
                                </div>
                            </div>
                        @elseif($report->reportable_type === 'App\Models\Message')
                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-900">Mesaj</span>
                                    <span class="text-sm text-gray-500">{{ $report->reportable->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <p class="text-gray-900">{{ $report->reportable->content }}</p>
                                
                                <div class="mt-3 flex items-center space-x-2">
                                    <img class="h-6 w-6 rounded-full object-cover" 
                                         src="{{ $report->reportable->sender->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                         alt="{{ $report->reportable->sender->name }}">
                                    <span class="text-sm text-gray-600">{{ $report->reportable->sender->name }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-600">Kullanıcı bildirisi</p>
                        @endif
                    </div>
                    @else
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Bildirilen İçerik</h2>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">İçerik Bulunamadı</h3>
                            <p class="mt-1 text-sm text-gray-500">Bildirilen içerik silinmiş veya mevcut değil.</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Yan Panel -->
                <div class="space-y-6">
                    <!-- Durum Değiştir -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">İşlemler</h3>
                        
                        <form method="POST" action="{{ route('admin.reports.update-status', $report) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Beklemede</option>
                                    <option value="reviewed" {{ $report->status === 'reviewed' ? 'selected' : '' }}>İnceleniyor</option>
                                    <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Çözüldü</option>
                                    <option value="dismissed" {{ $report->status === 'dismissed' ? 'selected' : '' }}>Reddedildi</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notları</label>
                                <textarea name="admin_notes" rows="3" 
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                          placeholder="Bildiri hakkında notlar...">{{ $report->admin_notes }}</textarea>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium">
                                Güncelle
                            </button>
                        </form>
                    </div>

                    <!-- İçerik İşlemleri -->
                    @if($report->reportable && method_exists($report->reportable, 'update') && isset($report->reportable->is_active))
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">İçerik İşlemleri</h3>
                        
                        <form method="POST" action="{{ route('admin.reports.toggle-content', $report) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full {{ $report->reportable->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-md font-medium">
                                {{ $report->reportable->is_active ? 'İçeriği Gizle' : 'İçeriği Aktif Et' }}
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- İnceleme Geçmişi -->
                    @if($report->reviewer)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">İnceleme Geçmişi</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <img class="h-8 w-8 rounded-full object-cover" 
                                     src="{{ $report->reviewer->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                     alt="{{ $report->reviewer->name }}">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $report->reviewer->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $report->reviewed_at?->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($report->admin_notes)
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-900">{{ $report->admin_notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Tehlikeli İşlemler -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-400">
                        <h3 class="text-lg font-bold text-red-900 mb-4">Tehlikeli İşlemler</h3>
                        
                        <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" 
                              onsubmit="return confirm('Bu bildiriyi silmek istediğinizden emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium">
                                Bildiriyi Sil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 