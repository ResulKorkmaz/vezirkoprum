<x-admin-layout>
    <div class="py-6 bg-gradient-to-br from-slate-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Modern Header -->
            <div class="mb-8 bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Bildiri Yönetimi</h1>
                        <p class="text-gray-600 mt-1">Kullanıcı bildirilerini inceleyin ve yönetin</p>
                    </div>
                </div>
            </div>

            <!-- Modern Stats Cards -->
            <div class="flex gap-4 mb-8">
                <div class="flex-1 bg-white rounded-2xl shadow-lg border border-gray-200 p-4 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Beklemede</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-2 rounded-full" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);"></div>
                </div>

                <div class="flex-1 bg-white rounded-2xl shadow-lg border border-gray-200 p-4 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Yeni Bildirimler</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['unread'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V8m10 0H7m5 5v3"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-2 rounded-full" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);"></div>
                </div>

                <div class="flex-1 bg-white rounded-2xl shadow-lg border border-gray-200 p-4 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">İnceleniyor</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['reviewed'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-2 rounded-full" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);"></div>
                </div>

                <div class="flex-1 bg-white rounded-2xl shadow-lg border border-gray-200 p-4 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Çözüldü</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['resolved'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-2 rounded-full" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);"></div>
                </div>

                <div class="flex-1 bg-white rounded-2xl shadow-lg border border-gray-200 p-4 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Reddedildi</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['dismissed'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 h-2 rounded-full" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);"></div>
                </div>
            </div>

            <!-- Modern Filters -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Filtreler</h3>
                        <p class="text-sm text-gray-500">Bildiriler arasında arama yapın</p>
                    </div>
                </div>
                
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Durum</label>
                        <select name="status" class="w-full border-2 border-gray-200 rounded-xl shadow-sm focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-colors">
                            <option value="">Tümü</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Beklemede</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>İnceleniyor</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Çözüldü</option>
                            <option value="dismissed" {{ request('status') == 'dismissed' ? 'selected' : '' }}>Reddedildi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">İçerik Türü</label>
                        <select name="type" class="w-full border-2 border-gray-200 rounded-xl shadow-sm focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-colors">
                            <option value="">Tümü</option>
                            <option value="post" {{ request('type') == 'post' ? 'selected' : '' }}>Paylaşım</option>
                            <option value="comment" {{ request('type') == 'comment' ? 'selected' : '' }}>Yorum</option>
                            <option value="message" {{ request('type') == 'message' ? 'selected' : '' }}>Mesaj</option>
                            <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Kullanıcı</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Bildiri Nedeni</label>
                        <select name="reason" class="w-full border-2 border-gray-200 rounded-xl shadow-sm focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-colors">
                            <option value="">Tümü</option>
                            @foreach(\App\Models\Report::getReasons() as $key => $value)
                                <option value="{{ $key }}" {{ request('reason') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white rounded-xl shadow-sm transition-all duration-200 transform hover:scale-105"
                                style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);"
                                onmouseover="this.style.background='linear-gradient(135deg, #96526b 0%, #a85d68 100%)'"
                                onmouseout="this.style.background='linear-gradient(135deg, #a85d68 0%, #b76e79 100%)'">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filtrele
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modern Reports Table -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                @if($reports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>Bildiren</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>İçerik</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <span>Neden</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Durum</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Tarih</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>İşlemler</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reports as $report)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 {{ $report->viewed_at ? 'bg-gray-50' : 'bg-white' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <!-- Okunma durumu göstergesi -->
                                                @if($report->viewed_at)
                                                    <div class="w-3 h-3 rounded-full bg-gray-400 flex-shrink-0" title="Detayına bakıldı: {{ $report->viewed_at->format('d.m.Y H:i') }}"></div>
                                                @else
                                                    <div class="w-3 h-3 rounded-full flex-shrink-0" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);" title="Henüz detayına bakılmadı"></div>
                                                @endif
                                                
                                                <input type="checkbox" name="report_ids[]" value="{{ $report->id }}" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm" style="background: linear-gradient(135deg, #a85d68 0%, #b76e79 100%);">
                                                    {{ strtoupper(substr($report->reporter->name, 0, 1)) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="text-sm font-medium text-gray-900 truncate {{ $report->viewed_at ? 'font-normal' : 'font-bold' }}">{{ $report->reporter->name }}</div>
                                                        @if(!$report->viewed_at)
                                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                                                Yeni
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-sm text-gray-500 truncate">{{ $report->reporter->email }}</div>
                                                    @if($report->reporter->unique_user_id)
                                                        <div class="text-xs text-gray-400">#{{ $report->reporter->unique_user_id }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                @if($report->reportable_type === 'App\Models\Post')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Paylaşım
                                                    </span>
                                                    <div class="mt-1 text-sm text-gray-600">
                                                        {{ Str::limit($report->reportable->content ?? 'İçerik bulunamadı', 50) }}
                                                    </div>
                                                @elseif($report->reportable_type === 'App\Models\Comment')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Yorum
                                                    </span>
                                                    <div class="mt-1 text-sm text-gray-600">
                                                        {{ Str::limit($report->reportable->content ?? 'İçerik bulunamadı', 50) }}
                                                    </div>
                                                @elseif($report->reportable_type === 'App\Models\Message')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Mesaj
                                                    </span>
                                                    <div class="mt-1 text-sm text-gray-600">
                                                        {{ Str::limit($report->reportable->content ?? 'İçerik bulunamadı', 50) }}
                                                    </div>
                                                @elseif($report->reportable_type === 'App\Models\User')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        Kullanıcı
                                                    </span>
                                                    <div class="mt-1 text-sm text-gray-600">
                                                        {{ $report->reportable->name ?? 'Kullanıcı bulunamadı' }}
                                                    </div>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Bilinmeyen
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ \App\Models\Report::getReasons()[$report->reason] ?? $report->reason }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $report->status_color }}-100 text-{{ $report->status_color }}-800">
                                                {{ $report->status_text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $report->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.reports.show', $report) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white rounded-lg transition-all duration-200 hover:scale-105"
                                                   style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);"
                                                   onmouseover="this.style.background='linear-gradient(135deg, #2563eb 0%, #1e40af 100%)'"
                                                   onmouseout="this.style.background='linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)'">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Detay
                                                </a>
                                                
                                                @if($report->reportable && method_exists($report->reportable, 'update') && isset($report->reportable->is_active))
                                                    <form method="POST" action="{{ route('admin.reports.toggle-content', $report) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white rounded-lg transition-all duration-200 hover:scale-105"
                                                                style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"
                                                                onmouseover="this.style.background='linear-gradient(135deg, #e5950a 0%, #c2770b 100%)'"
                                                                onmouseout="this.style.background='linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                                            </svg>
                                                            {{ $report->reportable->is_active ? 'Gizle' : 'Aktif Et' }}
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white rounded-lg transition-all duration-200 hover:scale-105"
                                                            style="background: linear-gradient(135deg, #a85d68 0%, #96526b 100%);"
                                                            onmouseover="this.style.background='linear-gradient(135deg, #96526b 0%, #854956 100%)'"
                                                            onmouseout="this.style.background='linear-gradient(135deg, #a85d68 0%, #96526b 100%)'"
                                                            onclick="return confirm('Bu bildiriyi silmek istediğinizden emin misiniz?')">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Sil
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-700">Seçili bildiriler için:</span>
                                <form method="POST" action="{{ route('admin.reports.bulk-action') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="report_ids" id="bulkReportIds">
                                    <select name="action" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                                        <option value="">İşlem seçin</option>
                                        <option value="resolve">Çözüldü olarak işaretle</option>
                                        <option value="dismiss">Reddet</option>
                                        <option value="delete">Sil</option>
                                    </select>
                                </form>
                            </div>
                            
                            <div class="text-sm text-gray-700">
                                {{ $reports->firstItem() }}-{{ $reports->lastItem() }} / {{ $reports->total() }} bildiri
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white px-6 py-3 border-t border-gray-200">
                        {{ $reports->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Bildiri bulunamadı</h3>
                        <p class="mt-1 text-sm text-gray-500">Henüz hiç bildiri yapılmamış.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="report_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkIds();
        });

        // Update bulk action IDs
        function updateBulkIds() {
            const checkedBoxes = document.querySelectorAll('input[name="report_ids[]"]:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            document.getElementById('bulkReportIds').value = JSON.stringify(ids);
        }

        // Add event listeners to individual checkboxes
        document.querySelectorAll('input[name="report_ids[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkIds);
        });
    </script>
</x-admin-layout> 