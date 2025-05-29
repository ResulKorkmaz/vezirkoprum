@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Mesajlarım</h1>

    <div class="space-y-4">
        @forelse($messages as $message)
            <div class="border rounded p-4 {{ !$message->is_read && $message->receiver_id === auth()->id() ? 'bg-blue-50' : '' }}">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold">
                            @if($message->sender_id === auth()->id())
                                Gönderilen: {{ $message->receiver->name }}
                            @else
                                Gelen: {{ $message->sender->name }}
                            @endif
                        </p>
                        <p class="text-gray-600">{{ Str::limit($message->body, 100) }}</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $message->created_at->format('d.m.Y H:i') }}
                        @if(!$message->is_read && $message->receiver_id === auth()->id())
                            <span class="ml-2 bg-blue-500 text-white px-2 py-1 rounded-full text-xs">Yeni</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('messages.show', $message->id) }}" class="text-blue-500 hover:text-blue-700 text-sm">Mesajı Görüntüle</a>
            </div>
        @empty
            <p class="text-gray-500">Henüz mesajınız bulunmuyor.</p>
        @endforelse
    </div>
</div>
@endsection 