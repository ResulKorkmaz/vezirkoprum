@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Yeni WhatsApp Grubu Ekle</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('whatsapp_groups.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="city">Şehir</label>
            <input type="text" name="city" id="city" value="{{ old('city') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Grup Adı</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="invite_link">Davet Linki</label>
            <input type="url" name="invite_link" id="invite_link" value="{{ old('invite_link') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Grubu Ekle</button>
    </form>
</div>
@endsection 