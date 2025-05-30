@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <a href="{{ route('messages.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Mesajlara Dön</a>
    </div>

    <div class="border rounded p-4 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-xl font-semibold mb-2">{{ $message->subject }}</h2>
                <p class="font-semibold">
                    @if($message->sender_id === auth()->id())
                        Gönderilen: {{ $message->receiver->name }}
                    @else
                        Gelen: {{ $message->sender->name }}
                    @endif
                </p>
                <p class="text-sm text-gray-500">{{ $message->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>
        <div class="mt-4 p-4 bg-gray-50 rounded">
            <p class="text-gray-700 whitespace-pre-wrap">{{ $message->content }}</p>
        </div>
    </div>

    @if($message->sender_id !== auth()->id())
        <div class="border rounded p-4">
            <h2 class="text-xl font-bold mb-4">Yanıtla</h2>
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $message->sender_id }}">
                
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Konu</label>
                    <input type="text" 
                           id="subject" 
                           name="subject" 
                           value="Re: {{ $message->subject }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                </div>
                
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Mesaj</label>
                    <textarea name="content" 
                              id="content"
                              rows="4" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                              placeholder="Mesajınızı yazın..."
                              required></textarea>
                </div>
                
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Gönder</button>
            </form>
        </div>
    @endif
</div>
@endsection 