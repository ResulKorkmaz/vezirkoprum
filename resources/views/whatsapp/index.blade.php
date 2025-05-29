@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">WhatsApp Grupları</h1>
        @can('create', App\Models\WhatsappGroup::class)
            <a href="{{ route('whatsapp_groups.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Yeni Grup Ekle</a>
        @endcan
    </div>

    <div class="space-y-6">
        @foreach($groups->groupBy('city') as $city => $cityGroups)
            <div class="border rounded p-4">
                <h2 class="text-xl font-bold mb-4">{{ $city }}</h2>
                <div class="space-y-4">
                    @foreach($cityGroups as $group)
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-semibold">{{ $group->name }}</h3>
                                <p class="text-sm text-gray-500">Ekleyen: {{ $group->creator->name }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ $group->invite_link }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Gruba Katıl</a>
                                @can('update', $group)
                                    <a href="{{ route('whatsapp_groups.edit', $group->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Düzenle</a>
                                @endcan
                                @can('delete', $group)
                                    <form action="{{ route('whatsapp_groups.destroy', $group->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Bu grubu silmek istediğinizden emin misiniz?')">Sil</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection 