<x-admin-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3" style="color: #B76E79;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Spam Kelime Yönetimi
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Otomatik spam tespit sistemi için kelime listesini yönetin
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button onclick="openAddWordModal()" 
                            class="inline-flex items-center px-4 py-2 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                            style="background: linear-gradient(to right, #10b981, #059669);">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Kelime Ekle
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Toplam Kelime</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $words->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            @foreach(['profanity' => 'Küfür', 'scam' => 'Dolandırıcılık', 'commercial' => 'Ticari', 'inappropriate' => 'Uygunsuz'] as $category => $label)
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold"
                                     style="background: {{ $category === 'profanity' ? '#ef4444' : ($category === 'scam' ? '#f59e0b' : ($category === 'commercial' ? '#3b82f6' : '#8b5cf6')) }}">
                                    {{ substr($label, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $label }}</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $categoryStats[$category] ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Words Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Spam Kelimeleri</h3>
                    <div class="flex space-x-2">
                        <select onchange="filterByCategory(this.value)" class="rounded-lg border-gray-300 text-sm">
                            <option value="">Tüm Kategoriler</option>
                            <option value="profanity">Küfür</option>
                            <option value="scam">Dolandırıcılık</option>
                            <option value="commercial">Ticari</option>
                            <option value="inappropriate">Uygunsuz</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelime
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ağırlık
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Oluşturulma
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($words as $word)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $word->word }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $word->category === 'profanity' ? 'bg-red-100 text-red-800' : 
                                           ($word->category === 'scam' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($word->category === 'commercial' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800')) }}">
                                        {{ ucfirst($word->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-900">{{ $word->weight }}/10</div>
                                        <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                            <div class="h-2 rounded-full" 
                                                 style="width: {{ ($word->weight / 10) * 100 }}%; background: linear-gradient(to right, #10b981, #059669);"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $word->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $word->is_active ? 'Aktif' : 'Pasif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $word->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="editWord({{ $word->id }}, '{{ $word->word }}', {{ $word->weight }}, '{{ $word->category }}', {{ $word->is_active ? 'true' : 'false' }})"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button onclick="deleteWord({{ $word->id }}, '{{ $word->word }}')"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Henüz spam kelimesi yok</h3>
                                    <p class="mt-1 text-sm text-gray-500">İlk spam kelimesini ekleyerek başlayın.</p>
                                    <div class="mt-6">
                                        <button onclick="openAddWordModal()" 
                                                class="inline-flex items-center px-4 py-2 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                                                style="background: linear-gradient(to right, #10b981, #059669);">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Kelime Ekle
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($words->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $words->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Word Modal -->
    <div id="addWordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Yeni Spam Kelimesi</h3>
                    <button onclick="closeAddWordModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="addWordForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelime</label>
                        <input type="text" name="word" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Kategori Seçin</option>
                            <option value="profanity">Küfür</option>
                            <option value="scam">Dolandırıcılık</option>
                            <option value="commercial">Ticari</option>
                            <option value="inappropriate">Uygunsuz</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ağırlık (1-10)</label>
                        <input type="number" name="weight" min="1" max="10" value="5" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeAddWordModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            İptal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-white rounded-lg hover:opacity-90 transition-all duration-200"
                                style="background: linear-gradient(to right, #10b981, #059669);">
                            Ekle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Word Modal -->
    <div id="editWordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Kelime Düzenle</h3>
                    <button onclick="closeEditWordModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="editWordForm" class="space-y-4">
                    <input type="hidden" name="id">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelime</label>
                        <input type="text" name="word" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="profanity">Küfür</option>
                            <option value="scam">Dolandırıcılık</option>
                            <option value="commercial">Ticari</option>
                            <option value="inappropriate">Uygunsuz</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ağırlık (1-10)</label>
                        <input type="number" name="weight" min="1" max="10" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="is_active" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeEditWordModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            İptal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Modal functions
    function openAddWordModal() {
        document.getElementById('addWordModal').classList.remove('hidden');
    }

    function closeAddWordModal() {
        document.getElementById('addWordModal').classList.add('hidden');
        document.getElementById('addWordForm').reset();
    }

    function editWord(id, word, weight, category, isActive) {
        const modal = document.getElementById('editWordModal');
        const form = document.getElementById('editWordForm');
        
        form.querySelector('input[name="id"]').value = id;
        form.querySelector('input[name="word"]').value = word;
        form.querySelector('input[name="weight"]').value = weight;
        form.querySelector('select[name="category"]').value = category;
        form.querySelector('input[name="is_active"]').checked = isActive;
        
        modal.classList.remove('hidden');
    }

    function closeEditWordModal() {
        document.getElementById('editWordModal').classList.add('hidden');
    }

    // Add word form submission
    document.getElementById('addWordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("admin.spam.words.add") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeAddWordModal();
                location.reload();
            } else {
                alert('Hata: ' + data.message);
            }
        });
    });

    // Edit word form submission
    document.getElementById('editWordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = formData.get('id');
        const data = Object.fromEntries(formData);
        data.is_active = document.querySelector('input[name="is_active"]').checked;
        
        fetch(`/admin/spam/words/${id}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeEditWordModal();
                location.reload();
            } else {
                alert('Hata: ' + data.message);
            }
        });
    });

    // Delete word
    function deleteWord(id, word) {
        if (confirm(`"${word}" kelimesini silmek istediğinizden emin misiniz?`)) {
            fetch(`/admin/spam/words/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Hata: ' + data.message);
                }
            });
        }
    }

    // Filter by category
    function filterByCategory(category) {
        const url = new URL(window.location);
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }
        window.location = url;
    }
    </script>
</x-admin-layout>