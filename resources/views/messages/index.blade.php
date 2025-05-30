<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mesajlarım
            </h2>
            <div class="flex items-center space-x-4">
                <button id="select-all-btn" class="hidden px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                    Tümünü Seç
                </button>
                <button id="delete-selected-btn" class="hidden px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Seçilenleri Sil
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="bulk-delete-form" method="POST" action="{{ route('messages.bulk-delete') }}">
                        @csrf
                        @method('DELETE')
                        
                        <div class="space-y-4">
                            @forelse($messages as $message)
                                <div class="border border-gray-200 rounded-lg p-6 {{ !$message->is_read && $message->receiver_id === auth()->id() ? 'bg-rose-50 border-rose-200' : '' }}">
                                    <div class="flex items-start space-x-4">
                                        <!-- Checkbox for bulk selection -->
                                        <div class="flex items-center pt-1">
                                            <input type="checkbox" name="message_ids[]" value="{{ $message->id }}" 
                                                   class="message-checkbox rounded border-gray-300 text-rose-600 shadow-sm focus:ring-rose-500"
                                                   onchange="toggleBulkActions()">
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <p class="font-semibold mb-1 text-gray-700">
                                                        @if($message->sender_id === auth()->id())
                                                            Gönderilen: {{ $message->receiver->name }}
                                                        @else
                                                            Gelen: {{ $message->sender->name }}
                                                        @endif
                                                    </p>
                                                    <p class="text-lg font-medium text-gray-800 mb-2">{{ $message->subject }}</p>
                                                    <p class="text-gray-600">{{ Str::limit($message->content, 100) }}</p>
                                                </div>
                                                <div class="text-sm text-gray-500 text-right ml-4">
                                                    {{ $message->created_at->format('d.m.Y H:i') }}
                                                    @if(!$message->is_read && $message->receiver_id === auth()->id())
                                                        <span class="ml-2 bg-rose-500 text-white px-2 py-1 rounded-full text-xs">Yeni</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-3 flex items-center justify-between">
                                                <a href="{{ route('messages.show', $message->id) }}" class="text-rose-600 hover:text-rose-700 text-sm font-medium inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Mesajı Görüntüle
                                                </a>
                                                
                                                <!-- Individual delete button -->
                                                <form method="POST" action="{{ route('messages.destroy', $message->id) }}" class="inline" 
                                                      onsubmit="return confirm('Bu mesajı silmek istediğinizden emin misiniz?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium inline-flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Sil
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-xl mb-2">Henüz mesajınız bulunmuyor.</p>
                                    <p class="text-gray-400 text-sm mb-6">Hemşehrilerinizle iletişime geçmek için ana sayfadan mesaj gönderebilirsiniz.</p>
                                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Hemşehri Bul
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </form>

                    @if($messages->hasPages())
                        <div class="mt-6">
                            {{ $messages->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBulkActions() {
            const checkboxes = document.querySelectorAll('.message-checkbox');
            const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
            const selectAllBtn = document.getElementById('select-all-btn');
            const deleteSelectedBtn = document.getElementById('delete-selected-btn');
            
            if (checkboxes.length > 0) {
                selectAllBtn.classList.remove('hidden');
            }
            
            if (checkedBoxes.length > 0) {
                deleteSelectedBtn.classList.remove('hidden');
                deleteSelectedBtn.textContent = `Seçilenleri Sil (${checkedBoxes.length})`;
            } else {
                deleteSelectedBtn.classList.add('hidden');
            }
            
            // Update select all button text
            if (checkedBoxes.length === checkboxes.length) {
                selectAllBtn.textContent = 'Seçimi Temizle';
            } else {
                selectAllBtn.textContent = 'Tümünü Seç';
            }
        }
        
        document.getElementById('select-all-btn').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.message-checkbox');
            const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
            const selectAll = checkedBoxes.length !== checkboxes.length;
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll;
            });
            
            toggleBulkActions();
        });
        
        document.getElementById('delete-selected-btn').addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Lütfen silmek istediğiniz mesajları seçin.');
                return;
            }
            
            if (confirm(`Seçilen ${checkedBoxes.length} mesajı silmek istediğinizden emin misiniz?`)) {
                document.getElementById('bulk-delete-form').submit();
            }
        });
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleBulkActions();
        });
    </script>
</x-app-layout> 