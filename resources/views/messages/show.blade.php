<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mesaj Detayı
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('messages.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </a>
                <form method="POST" action="{{ route('messages.destroy', $message->id) }}" class="inline" 
                      onsubmit="return confirm('Bu mesajı silmek istediğinizden emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Mesajı Sil
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="border border-gray-200 rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ $message->subject }}</h2>
                                <p class="font-semibold text-gray-700">
                                    @if($message->sender_id === auth()->id())
                                        Gönderilen: 
                                        <a href="{{ route('profile.show', $message->receiver) }}" class="text-rose-600 hover:text-rose-700 hover:underline transition-colors">
                                            {{ $message->receiver->name }}
                                        </a>
                                        @if(auth()->user()->is_admin)
                                            <span class="text-sm text-gray-500">(#{{ $message->receiver->unique_user_id }})</span>
                                        @endif
                                    @else
                                        Gelen: 
                                        <a href="{{ route('profile.show', $message->sender) }}" class="text-rose-600 hover:text-rose-700 hover:underline transition-colors">
                                            {{ $message->sender->name }}
                                        </a>
                                        @if(auth()->user()->is_admin)
                                            <span class="text-sm text-gray-500">(#{{ $message->sender->unique_user_id }})</span>
                                        @endif
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500">{{ $message->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $message->content }}</p>
                        </div>
                    </div>

                    @if($message->sender_id !== auth()->id())
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h2 class="text-xl font-bold mb-4 text-gray-800">Yanıtla</h2>
                            <form action="{{ route('messages.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $message->sender_id }}">
                                
                                <div class="mb-4">
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Konu</label>
                                    <input type="text" 
                                           id="subject" 
                                           name="subject" 
                                           value="Re: {{ $message->subject }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                           required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Mesaj</label>
                                    <textarea name="content" 
                                              id="content"
                                              rows="4" 
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-rose-500 focus:ring-rose-500" 
                                              placeholder="Mesajınızı yazın..."
                                              required></textarea>
                                </div>
                                
                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Gönder
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 