@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Profili Düzenle</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Ad Soyad</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="profession_id">Meslek</label>
            <select name="profession_id" id="profession_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Seçiniz</option>
                @foreach(\App\Models\Profession::all() as $profession)
                    <option value="{{ $profession->id }}" {{ old('profession_id', $user->profession_id) == $profession->id ? 'selected' : '' }}>
                        {{ $profession->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="current_city">Şehir</label>
            <input type="text" name="current_city" id="current_city" value="{{ old('current_city', $user->current_city) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="current_district">İlçe</label>
            <input type="text" name="current_district" id="current_district" value="{{ old('current_district', $user->current_district) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Telefon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="show_phone" value="1" {{ old('show_phone', $user->show_phone) ? 'checked' : '' }} class="form-checkbox">
                <span class="ml-2">Telefon numaramı herkese göster</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kaydet</button>
    </form>
</div>
@endsection 