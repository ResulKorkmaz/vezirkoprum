<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            WhatsApp Grubunu Düzenle: {{ $group->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-rose-100">
                <div class="p-6 text-gray-900">
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.whatsapp.update', $group) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Şehir Seçimi -->
                        <div>
                            <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                                Şehir <span class="text-red-500">*</span>
                            </label>
                            <select name="city" id="city" 
                                    class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors @error('city') border-red-500 @enderror"
                                    required onchange="updateDistricts()">
                                <option value="">Şehir Seçin</option>
                                @foreach(config('turkiye.cities') as $cityName => $districts)
                                    <option value="{{ $cityName }}" {{ old('city', $group->city) == $cityName ? 'selected' : '' }}>
                                        {{ $cityName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- İlçe Seçimi -->
                        <div>
                            <label for="district" class="block text-sm font-semibold text-gray-700 mb-2">
                                İlçe
                            </label>
                            <select name="district" id="district" 
                                    class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors @error('district') border-red-500 @enderror">
                                <option value="">İlçe Seçin (Opsiyonel)</option>
                            </select>
                            @error('district')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grup Adı -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Grup Adı <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $group->name) }}" 
                                   class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors @error('name') border-red-500 @enderror"
                                   placeholder="Örn: Samsun Vezirköprülüler"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Açıklama -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Açıklama
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors @error('description') border-red-500 @enderror"
                                      placeholder="Grup hakkında kısa açıklama...">{{ old('description', $group->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- WhatsApp Davet Linki -->
                        <div>
                            <label for="invite_link" class="block text-sm font-semibold text-gray-700 mb-2">
                                WhatsApp Davet Linki <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="invite_link" id="invite_link" value="{{ old('invite_link', $group->invite_link) }}" 
                                   class="w-full border-rose-200 rounded-lg shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors @error('invite_link') border-red-500 @enderror"
                                   placeholder="https://chat.whatsapp.com/..."
                                   required>
                            <p class="mt-1 text-sm text-gray-500">WhatsApp grubunun davet linkini buraya yapıştırın.</p>
                            @error('invite_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aktif Durumu -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       class="rounded border-rose-200 text-rose-600 shadow-sm focus:ring-rose-500"
                                       {{ old('is_active', $group->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm font-medium text-gray-700">Grup aktif</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Pasif gruplar kullanıcılara gösterilmez.</p>
                        </div>

                        <!-- Butonlar -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.whatsapp.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Geri Dön
                            </a>

                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const cities = @json(config('turkiye.cities'));
        
        function updateDistricts() {
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const selectedCity = citySelect.value;
            
            // İlçe seçimini temizle
            districtSelect.innerHTML = '<option value="">İlçe Seçin (Opsiyonel)</option>';
            
            if (selectedCity && cities[selectedCity]) {
                cities[selectedCity].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    if ('{{ old("district", $group->district) }}' === district) {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            }
        }
        
        // Sayfa yüklendiğinde çalıştır
        document.addEventListener('DOMContentLoaded', updateDistricts);
    </script>
</x-admin-layout> 