@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <a href="{{ route('messages.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Mesajlara Dön</a>
    </div>

    <div class="border rounded p-4 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
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
        <p class="text-gray-700">{{ $message->body }}</p>
    </div>

    @if($message->sender_id !== auth()->id())
        <div class="border rounded p-4">
            <h2 class="text-xl font-bold mb-4">Yanıtla</h2>
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $message->sender_id }}">
                <div class="mb-4">
                    <textarea name="body" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Mesajınızı yazın..."></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Gönder</button>
            </form>
        </div>
    @endif
</div>
@endsection 