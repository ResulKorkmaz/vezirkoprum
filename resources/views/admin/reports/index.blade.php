<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Bildiri Yönetimi</h1>
                <p class="text-gray-600 mt-2">Kullanıcı bildirilerini inceleyin ve yönetin</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-yellow-800">Beklemede</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-800">İnceleniyor</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $stats['reviewed'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-800">Çözüldü</p>
                            <p class="text-2xl font-bold text-green-900">{{ $stats['resolved'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-800">Reddedildi</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['dismissed'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow mb-6 p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Tümü</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Beklemede</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>İnceleniyor</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Çözüldü</option>
                            <option value="dismissed" {{ request('status') == 'dismissed' ? 'selected' : '' }}>Reddedildi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">İçerik Türü</label>
                        <select name="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Tümü</option>
                            <option value="post" {{ request('type') == 'post' ? 'selected' : '' }}>Paylaşım</option>
                            <option value="message" {{ request('type') == 'message' ? 'selected' : '' }}>Mesaj</option>
                            <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Kullanıcı</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bildiri Nedeni</label>
                        <select name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Tümü</option>
                            @foreach(\App\Models\Report::getReasons() as $key => $value)
                                <option value="{{ $key }}" {{ request('reason') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium">
                            Filtrele
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reports Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($reports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bildiren</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İçerik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Neden</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reports as $report)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="report_ids[]" value="{{ $report->id }}" class="rounded border-gray-300">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">{{ $report->reporter->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $report->reporter->email }}</div>
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
                                                @elseif($report->reportable_type === 'App\Models\Message')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Mesaj
                                                    </span>
                                                    <div class="mt-1 text-sm text-gray-600">
                                                        {{ Str::limit($report->reportable->content ?? 'İçerik bulunamadı', 50) }}
                                                    </div>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        Kullanıcı
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
                                                   class="text-indigo-600 hover:text-indigo-900">Detay</a>
                                                
                                                @if($report->reportable && method_exists($report->reportable, 'update') && isset($report->reportable->is_active))
                                                    <form method="POST" action="{{ route('admin.reports.toggle-content', $report) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-orange-600 hover:text-orange-900">
                                                            {{ $report->reportable->is_active ? 'Gizle' : 'Aktif Et' }}
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                                            onclick="return confirm('Bu bildiriyi silmek istediğinizden emin misiniz?')">
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