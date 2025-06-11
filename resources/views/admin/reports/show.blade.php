<x-admin-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.reports.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Geri Dön
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Bildiri Detayı</h1>
                            <p class="text-gray-600 mt-1">Bildiri #{{ $report->id }} - {{ $report->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="flex items-center space-x-3">
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                'reviewed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'resolved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                'dismissed' => 'bg-gray-100 text-gray-800 border-gray-200'
                            ];
                            $statusLabels = [
                                'pending' => 'Beklemede',
                                'reviewed' => 'İnceleniyor', 
                                'resolved' => 'Çözüldü',
                                'dismissed' => 'Reddedildi'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold border {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                            {{ $statusLabels[$report->status] ?? 'Bilinmeyen' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Reporter Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Bildirimi Yapan
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center space-x-4">
                                <img class="h-12 w-12 rounded-full border-2 border-gray-200 object-cover shadow-sm" 
                                     src="{{ $report->reporter->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                     alt="{{ $report->reporter->name }}">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $report->reporter->name }}</h3>
                                    <p class="text-gray-600">{{ $report->reporter->email }}</p>
                                    @if($report->reporter->city || $report->reporter->district)
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $report->reporter->city }}{{ $report->reporter->district ? ', ' . $report->reporter->district : '' }}
                                        </p>
                                    @endif
                                </div>
                                <a href="{{ route('admin.users.show', $report->reporter) }}" 
                                   class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm"
                                   style="background-color: #a85d68;"
                                   onmouseover="this.style.backgroundColor='#96526b'"
                                   onmouseout="this.style.backgroundColor='#a85d68'">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Profil
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Report Details Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Bildiri Detayları
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Bildiri Sebebi</label>
                                    <p class="mt-1 text-gray-900 font-medium">{{ \App\Models\Report::getReasons()[$report->reason] ?? $report->reason }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">İçerik Türü</label>
                                    <p class="mt-1">
                                        @php
                                            $typeLabels = [
                                                'App\Models\Post' => 'Gönderi',
                                                'App\Models\Comment' => 'Yorum',
                                                'App\Models\Message' => 'Mesaj',
                                                'App\Models\User' => 'Kullanıcı'
                                            ];
                                            $typeColors = [
                                                'App\Models\Post' => 'bg-blue-100 text-blue-800',
                                                'App\Models\Comment' => 'bg-yellow-100 text-yellow-800',
                                                'App\Models\Message' => 'bg-green-100 text-green-800',
                                                'App\Models\User' => 'bg-purple-100 text-purple-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $typeColors[$report->reportable_type] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $typeLabels[$report->reportable_type] ?? 'Bilinmeyen' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            @if($report->description)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Açıklama</label>
                                    <div class="mt-2 p-4 bg-gray-50 rounded-lg border">
                                        <p class="text-gray-900 leading-relaxed">{{ $report->description }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reported Content Card -->
                    @if($report->reportable)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Bildirilen İçerik
                            </h2>
                        </div>
                        <div class="p-6">
                            @if($report->reportable_type === 'App\Models\Post')
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-blue-900">Gönderi</h4>
                                                <p class="text-blue-700 text-sm">{{ $report->reportable->created_at->format('d.m.Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-4 border border-blue-200 mb-4">
                                        <p class="text-gray-900 leading-relaxed">{{ $report->reportable->content }}</p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <img class="h-8 w-8 rounded-full border-2 border-blue-200 object-cover" 
                                                 src="{{ $report->reportable->user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                                 alt="{{ $report->reportable->user->name }}">
                                            <span class="text-blue-800 font-medium">{{ $report->reportable->user->name }}</span>
                                        </div>
                                        <a href="{{ route('admin.users.show', $report->reportable->user) }}" 
                                           class="text-sm font-medium hover:underline"
                                           style="color: #a85d68;"
                                           onmouseover="this.style.color='#96526b'"
                                           onmouseout="this.style.color='#a85d68'">
                                            Profil →
                                        </a>
                                    </div>
                                </div>
                            @elseif($report->reportable_type === 'App\Models\Comment')
                                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 713 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-yellow-900">Yorum</h4>
                                                <p class="text-yellow-700 text-sm">{{ $report->reportable->created_at->format('d.m.Y H:i') }}</p>
                                            </div>
                                        </div>
                                        @if(isset($report->reportable->is_approved))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $report->reportable->is_approved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $report->reportable->is_approved ? 'Onaylı' : 'Moderasyonda' }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-4 border border-yellow-200 mb-4">
                                        <p class="text-gray-900 leading-relaxed mb-3">{{ $report->reportable->content }}</p>
                                        
                                        @if($report->reportable->post)
                                            <div class="flex items-center space-x-2 text-sm text-yellow-700 bg-yellow-100 rounded-lg p-3">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.102m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                </svg>
                                                <span>Bu yorum</span>
                                                <a href="{{ route('posts.index') }}#post-{{ $report->reportable->post->id }}" 
                                                   class="text-yellow-800 hover:text-yellow-900 font-medium hover:underline" target="_blank">
                                                    #{{ $report->reportable->post->id }} numaralı gönderiye
                                                </a>
                                                <span>yapılmış</span>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500 bg-gray-100 rounded-lg p-3">
                                                Bu yorum silinmiş bir gönderiye yapılmış
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <img class="h-8 w-8 rounded-full border-2 border-yellow-200 object-cover" 
                                                 src="{{ $report->reportable->user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                                 alt="{{ $report->reportable->user->name }}">
                                            <span class="text-yellow-800 font-medium">{{ $report->reportable->user->name }}</span>
                                        </div>
                                        <a href="{{ route('admin.users.show', $report->reportable->user) }}" 
                                           class="text-sm font-medium hover:underline"
                                           style="color: #a85d68;"
                                           onmouseover="this.style.color='#96526b'"
                                           onmouseout="this.style.color='#a85d68'">
                                            Profil →
                                        </a>
                                    </div>
                                </div>
                            @elseif($report->reportable_type === 'App\Models\Message')
                                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.83 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-green-900">Mesaj</h4>
                                                <p class="text-green-700 text-sm">{{ $report->reportable->created_at->format('d.m.Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-4 border border-green-200 mb-4">
                                        <p class="text-gray-900 leading-relaxed">{{ $report->reportable->content }}</p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <img class="h-8 w-8 rounded-full border-2 border-green-200 object-cover" 
                                                 src="{{ $report->reportable->sender->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                                 alt="{{ $report->reportable->sender->name }}">
                                            <span class="text-green-800 font-medium">{{ $report->reportable->sender->name }}</span>
                                        </div>
                                        <a href="{{ route('admin.users.show', $report->reportable->sender) }}" 
                                           class="text-sm font-medium hover:underline"
                                           style="color: #a85d68;"
                                           onmouseover="this.style.color='#96526b'"
                                           onmouseout="this.style.color='#a85d68'">
                                            Profil →
                                        </a>
                                    </div>
                                </div>
                            @elseif($report->reportable_type === 'App\Models\User')
                                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-purple-900">Kullanıcı</h4>
                                                <p class="text-purple-700 text-sm">Kayıt: {{ $report->reportable->created_at->format('d.m.Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-6 border border-purple-200">
                                        <div class="flex items-center space-x-4">
                                            <img class="h-16 w-16 rounded-full border-2 border-purple-200 object-cover shadow-sm" 
                                                 src="{{ $report->reportable->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                                 alt="{{ $report->reportable->name }}">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-semibold text-gray-900">{{ $report->reportable->name }}</h3>
                                                <p class="text-gray-600 mb-2">{{ $report->reportable->email }}</p>
                                                @if($report->reportable->city || $report->reportable->district)
                                                    <p class="text-sm text-gray-500">
                                                        {{ $report->reportable->city }}{{ $report->reportable->district ? ', ' . $report->reportable->district : '' }}
                                                    </p>
                                                @endif
                                            </div>
                                            <a href="{{ route('admin.users.show', $report->reportable) }}" 
                                               class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm"
                                               style="background-color: #a85d68;"
                                               onmouseover="this.style.backgroundColor='#96526b'"
                                               onmouseout="this.style.backgroundColor='#a85d68'">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Detaylı Profil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Bildirilen İçerik
                            </h2>
                        </div>
                        <div class="p-12 text-center">
                            <div class="mx-auto h-16 w-16 text-gray-400 mb-4">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">İçerik Bulunamadı</h3>
                            <p class="text-gray-500">Bildirilen içerik silinmiş veya artık mevcut değil.</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Actions Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                İşlemler
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('admin.reports.update-status', $report) }}" class="space-y-6">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Durum Değiştir</label>
                                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                        <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>🕐 Beklemede</option>
                                        <option value="reviewed" {{ $report->status === 'reviewed' ? 'selected' : '' }}>👀 İnceleniyor</option>
                                        <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>✅ Çözüldü</option>
                                        <option value="dismissed" {{ $report->status === 'dismissed' ? 'selected' : '' }}>❌ Reddedildi</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Admin Notları</label>
                                    <textarea name="admin_notes" rows="4" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                              placeholder="Bildiri hakkında notlarınızı yazın...">{{ $report->admin_notes }}</textarea>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                                        style="background: linear-gradient(to right, #a85d68, #b76e79);"
                                        onmouseover="this.style.background='linear-gradient(to right, #96526b, #a85d68)'"
                                        onmouseout="this.style.background='linear-gradient(to right, #a85d68, #b76e79)'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <span>Güncelle</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Content Actions Card -->
                    @if($report->reportable && method_exists($report->reportable, 'update') && isset($report->reportable->is_active))
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                İçerik Yönetimi
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('admin.reports.toggle-content', $report) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                                        style="background: linear-gradient(to right, #a85d68, #b76e79);"
                                        onmouseover="this.style.background='linear-gradient(to right, #96526b, #a85d68)'"
                                        onmouseout="this.style.background='linear-gradient(to right, #a85d68, #b76e79)'">
                                    @if($report->reportable->is_active)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                        </svg>
                                        <span>İçeriği Gizle</span>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>İçeriği Aktif Et</span>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Review History Card -->
                    @if($report->reviewer)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                İnceleme Geçmişi
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <img class="h-10 w-10 rounded-full border-2 border-green-200 object-cover shadow-sm" 
                                     src="{{ $report->reviewer->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                     alt="{{ $report->reviewer->name }}">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $report->reviewer->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $report->reviewed_at?->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($report->admin_notes)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-sm text-green-800 leading-relaxed">{{ $report->admin_notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Danger Zone -->
                    <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-red-200">
                            <h3 class="text-lg font-semibold text-red-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Tehlikeli İşlemler
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" 
                                  onsubmit="return confirm('⚠️ Bu bildiriyi kalıcı olarak silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                                        style="background: linear-gradient(to right, #a85d68, #b76e79);"
                                        onmouseover="this.style.background='linear-gradient(to right, #96526b, #a85d68)'"
                                        onmouseout="this.style.background='linear-gradient(to right, #a85d68, #b76e79)'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Bildiriyi Sil</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 