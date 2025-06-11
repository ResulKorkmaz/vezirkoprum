<x-admin-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8">Kullanıcı Düzenle: {{ $user->name }}</h1>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ad Soyad -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Ad Soyad *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- E-posta -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-posta *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meslek -->
                        <div>
                            <label for="profession_id" class="block text-sm font-medium text-gray-700 mb-2">Meslek</label>
                            <select name="profession_id" id="profession_id" class="w-full border-gray-300 rounded-md shadow-sm" onchange="toggleRetirementDetailAdmin()">
                                <option value="">Meslek Seçin</option>
                                @foreach($professions as $profession)
                                    <option value="{{ $profession->id }}" {{ old('profession_id', $user->profession_id) == $profession->id ? 'selected' : '' }}>
                                        {{ $profession->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Retirement Detail -->
                        <div id="retirement_detail_div_admin" style="display: {{ old('profession_id', $user->profession_id) == 82 ? 'block' : 'none' }};">
                            <label for="retirement_detail" class="block text-sm font-medium text-gray-700 mb-2">Ne Emeklisi? (Opsiyonel)</label>
                            <input type="text" name="retirement_detail" id="retirement_detail" value="{{ old('retirement_detail', $user->retirement_detail) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Örn: Doktor, Öğretmen, Polis...">
                            <p class="text-sm text-gray-500 mt-1">Emekli olmadan önceki mesleğini yazabilirsiniz.</p>
                        </div>

                        <!-- Doğum Yılı -->
                        <div>
                            <label for="birth_year" class="block text-sm font-medium text-gray-700 mb-2">Doğum Yılı</label>
                            <input type="number" name="birth_year" id="birth_year" value="{{ old('birth_year', $user->birth_year) }}" 
                                   min="1900" max="{{ date('Y') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <!-- Şehir -->
                        <div>
                            <label for="current_city" class="block text-sm font-medium text-gray-700 mb-2">Şehir</label>
                            <select name="current_city" id="current_city" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Şehir Seçin</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ old('current_city', $user->current_city) === $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- İlçe -->
                        <div>
                            <label for="current_district" class="block text-sm font-medium text-gray-700 mb-2">İlçe</label>
                            <input type="text" name="current_district" id="current_district" value="{{ old('current_district', $user->current_district) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <!-- Biyografi -->
                    <div class="mt-6">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Biyografi</label>
                        <textarea name="bio" id="bio" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <!-- Admin Notları -->
                    <div class="mt-6">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notları</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('admin_notes', $user->admin_notes) }}</textarea>
                    </div>

                    <!-- Ayarlar -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="show_phone" value="1" {{ old('show_phone', $user->show_phone) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm text-gray-700">Telefon numarasını göster</span>
                            </label>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm text-gray-700">Admin yetkisi ver</span>
                            </label>
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class="mt-8 flex space-x-4">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg">Kaydet</button>
                        <a href="{{ route('admin.users.show', $user) }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg">İptal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleRetirementDetailAdmin() {
            const retirementDetailDiv = document.getElementById('retirement_detail_div_admin');
            const selectedProfession = document.getElementById('profession_id').value;
            
            if (selectedProfession === '82') { // Emekli profession ID
                retirementDetailDiv.style.display = 'block';
            } else {
                retirementDetailDiv.style.display = 'none';
            }
        }
    </script>
</x-admin-layout> 