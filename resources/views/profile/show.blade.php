@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $user->name }}</h1>
    
    <div class="mb-4">
        <p class="text-gray-600">Meslek: {{ $user->profession->name ?? 'Belirtilmemiş' }}</p>
        <p class="text-gray-600">Şehir: {{ $user->current_city ?? 'Belirtilmemiş' }}</p>
        <p class="text-gray-600">İlçe: {{ $user->current_district ?? 'Belirtilmemiş' }}</p>
        @if($user->show_phone)
            <p class="text-gray-600">Telefon: {{ $user->phone }}</p>
        @endif
    </div>

    @if(auth()->id() === $user->id)
        <a href="{{ route('profile.edit', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Profili Düzenle</a>
    @endif
</div>
@endsection 