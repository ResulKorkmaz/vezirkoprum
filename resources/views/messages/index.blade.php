@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Mesajlarım</h1>

    <div class="space-y-4">
        @forelse($messages as $message)
            <div class="border rounded p-4 {{ !$message->is_read && $message->receiver_id === auth()->id() ? 'bg-blue-50' : '' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="font-semibold mb-1">
                            @if($message->sender_id === auth()->id())
                                Gönderilen: {{ $message->receiver->name }}
                            @else
                                Gelen: {{ $message->sender->name }}
                            @endif
                        </p>
                        <p class="text-lg font-medium text-gray-800 mb-2">{{ $message->subject }}</p>
                        <p class="text-gray-600">{{ Str::limit($message->content, 100) }}</p>
                    </div>
                    <div class="text-sm text-gray-500 text-right">
                        {{ $message->created_at->format('d.m.Y H:i') }}
                        @if(!$message->is_read && $message->receiver_id === auth()->id())
                            <span class="ml-2 bg-blue-500 text-white px-2 py-1 rounded-full text-xs">Yeni</span>
                        @endif
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('messages.show', $message->id) }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">Mesajı Görüntüle</a>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500 text-lg">Henüz mesajınız bulunmuyor.</p>
                <p class="text-gray-400 text-sm mt-2">Hemşehrilerinizle iletişime geçmek için ana sayfadan mesaj gönderebilirsiniz.</p>
            </div>
        @endforelse
    </div>

    @if($messages->hasPages())
        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection 