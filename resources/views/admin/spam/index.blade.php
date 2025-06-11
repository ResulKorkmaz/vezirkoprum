<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Spam Yönetimi</h2>
                            <p class="text-gray-600 mt-1">Otomatik spam filtreleme sistemi ve yönetim paneli</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.spam.posts') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Tüm Postları Görüntüle
                            </a>
                            <a href="{{ route('admin.spam.words') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Spam Kelimelerini Yönet
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Toplam Spam</p>
                                <p class="text-3xl font-bold text-red-600">{{ $stats['total_spam'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-100">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Karantinada</p>
                                <p class="text-3xl font-bold text-orange-600">{{ $stats['quarantined'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-orange-100">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Şüpheli</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ $stats['suspicious'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Temiz</p>
                                <p class="text-3xl font-bold text-green-600">{{ $stats['clean'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Son Spam Postlar -->
            @if($recentSpamPosts->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Son Spam Postlar</h3>
                    <div class="space-y-4">
                        @foreach($recentSpamPosts as $post)
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">{{ Str::limit($post->content, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                    • Skor: {{ $post->spam_score }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="approvePost({{ $post->id }})" class="text-green-600 hover:text-green-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                <button onclick="quarantinePost({{ $post->id }})" class="text-orange-600 hover:text-orange-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Şüpheli Postlar -->
            @if($suspiciousPosts->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Şüpheli Postlar (İnceleme Bekliyor)</h3>
                    <div class="space-y-4">
                        @foreach($suspiciousPosts as $post)
                        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">{{ Str::limit($post->content, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                    • Skor: {{ $post->spam_score }}
                                </p>
                                @if($post->spam_reasons)
                                    <div class="mt-2">
                                        @foreach($post->spam_reasons as $reason)
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs text-gray-700 mr-2 mb-1">{{ $reason }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="approvePost({{ $post->id }})" class="text-green-600 hover:text-green-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                <button onclick="confirmSpam({{ $post->id }})" class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Karantina Postları -->
            @if($quarantinedPosts->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Karantinada Bekleyen Postlar</h3>
                    <div class="space-y-4">
                        @foreach($quarantinedPosts as $post)
                        <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">{{ Str::limit($post->content, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                    • Skor: {{ $post->spam_score }}
                                </p>
                                @if($post->spam_reasons)
                                    <div class="mt-2">
                                        @foreach($post->spam_reasons as $reason)
                                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs text-gray-700 mr-2 mb-1">{{ $reason }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="approvePost({{ $post->id }})" class="text-green-600 hover:text-green-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                <button onclick="confirmSpam({{ $post->id }})" class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Manuel İçerik Analizi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Manuel İçerik Analizi</h3>
                    <form id="analyzeForm" class="space-y-4">
                        @csrf
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">İçerik</label>
                            <textarea id="content" name="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Analiz edilecek içeriği buraya yazın..."></textarea>
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Analiz Et
                        </button>
                    </form>
                    <div id="analysisResult" class="mt-4 hidden">
                        <!-- Analiz sonucu buraya gelecek -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function approvePost(postId) {
            fetch(`/admin/spam/posts/${postId}/approve`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Hata: ' + (data.message || 'Bir hata oluştu'));
                }
            });
        }

        function confirmSpam(postId) {
            fetch(`/admin/spam/posts/${postId}/spam`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Hata: ' + (data.message || 'Bir hata oluştu'));
                }
            });
        }

        function quarantinePost(postId) {
            fetch(`/admin/spam/posts/${postId}/quarantine`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Hata: ' + (data.message || 'Bir hata oluştu'));
                }
            });
        }

        document.getElementById('analyzeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const content = document.getElementById('content').value;
            if (!content.trim()) {
                alert('Lütfen analiz edilecek içeriği girin.');
                return;
            }

            fetch('/admin/spam/analyze', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ content: content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const analysis = data.analysis;
                    let resultHtml = `
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold mb-2">Analiz Sonucu</h4>
                            <p><strong>Spam Skoru:</strong> ${analysis.score}/100</p>
                            <p><strong>Durum:</strong> <span class="font-semibold ${getStatusColor(analysis.status)}">${getStatusText(analysis.status)}</span></p>
                            ${analysis.reasons.length > 0 ? `
                                <div class="mt-2">
                                    <strong>Nedenler:</strong>
                                    <ul class="list-disc list-inside mt-1">
                                        ${analysis.reasons.map(reason => `<li class="text-sm">${reason}</li>`).join('')}
                                    </ul>
                                </div>
                            ` : ''}
                        </div>
                    `;
                    document.getElementById('analysisResult').innerHTML = resultHtml;
                    document.getElementById('analysisResult').classList.remove('hidden');
                } else {
                    alert('Analiz sırasında hata oluştu.');
                }
            });
        });

        function getStatusColor(status) {
            switch(status) {
                case 'clean': return 'text-green-600';
                case 'suspicious': return 'text-yellow-600';
                case 'spam': return 'text-red-600';
                case 'quarantined': return 'text-orange-600';
                default: return 'text-gray-600';
            }
        }

        function getStatusText(status) {
            switch(status) {
                case 'clean': return 'Temiz';
                case 'suspicious': return 'Şüpheli';
                case 'spam': return 'Spam';
                case 'quarantined': return 'Karantina';
                default: return 'Bilinmiyor';
            }
        }
    </script>
</x-admin-layout> 