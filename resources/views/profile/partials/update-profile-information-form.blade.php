<section>
    <header class="mb-4">
        <h2 class="h5 mb-2">
            Profil Bilgileri
        </h2>

        <p class="text-muted">
            Hesap bilgilerinizi, iletişim bilgilerinizi ve yaşadığınız şehir bilgilerinizi güncelleyin.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profil Resmi Bölümü -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="bi bi-camera-fill me-2"></i>Profil Resmi
                </h5>
                
                <div class="row align-items-center">
                    <!-- Mevcut Profil Resmi -->
                    <div class="col-auto">
                        <img class="rounded-circle border shadow-sm" 
                             style="width: 80px; height: 80px; object-fit: cover;"
                             src="{{ $user->getVisibleProfilePhotoUrl($user) }}" 
                             alt="Profil Resmi" 
                             id="profile-preview"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRTVFN0VCIi8+CjxwYXRoIGQ9Ik01MCA0MEMzNy45NSA0MCAyOCAzNS4wNSAyOCAyOUM4IDIzIDEyLjk1IDE4IDI1IDE4SDE4QzMwLjA1IDE4IDM1IDIzIDM1IDI5QzM1IDM1LjA1IDMwLjA1IDQwIDI1IDQwSDUwWk01MCA1MEMzNy45NSA1MCAyOCA1NS4wNSAyOCA2MUM4IDY3IDEyLjk1IDcyIDI1IDcySDE4QzMwLjA1IDcyIDM1IDY3IDM1IDYxQzM1IDU1LjA1IDMwLjA1IDUwIDI1IDUwSDUwWiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'">
                    </div>
                    
                    <!-- Profil Resmi Upload -->
                    <div class="col">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <label for="profile_photo" class="btn btn-outline-primary">
                                <i class="bi bi-camera me-2"></i>Resim Seç
                            </label>
                            <input id="profile_photo" name="profile_photo" type="file" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                            <small class="text-muted">JPG, PNG, GIF (Max: 10MB - otomatik optimize edilir)</small>
                        </div>
                        @error('profile_photo')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Profil Resmi Görünürlük Ayarları -->
                <div class="mt-3">
                    <label for="profile_photo_visibility" class="form-label">Profil Resmi Görünürlüğü</label>
                    <select id="profile_photo_visibility" name="profile_photo_visibility" class="form-select">
                        <option value="members_only" {{ old('profile_photo_visibility', $user->profile_photo_visibility) == 'members_only' ? 'selected' : '' }}>
                            👥 Sadece Üyeler Görebilir
                        </option>
                        <option value="everyone" {{ old('profile_photo_visibility', $user->profile_photo_visibility) == 'everyone' ? 'selected' : '' }}>
                            🌍 Herkes Görebilir
                        </option>
                        <option value="private" {{ old('profile_photo_visibility', $user->profile_photo_visibility) == 'private' ? 'selected' : '' }}>
                            🔒 Sadece Ben Görebilirim
                        </option>
                    </select>
                    @error('profile_photo_visibility')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Ad Soyad -->
        <div>
                <x-input-label for="name" value="Ad Soyad *" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

            <!-- E-posta -->
        <div>
                <x-input-label for="email" value="E-posta *" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                            E-posta adresiniz doğrulanmamış.

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Doğrulama e-postası göndermek için tıklayın.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                                E-posta adresinize yeni bir doğrulama bağlantısı gönderildi.
                        </p>
                    @endif
                </div>
            @endif
        </div>

            <!-- Meslek -->
            <div>
                <x-input-label for="profession_id" value="Meslek" />
                <select id="profession_id" name="profession_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleRetirementDetailProfile()">
                    <option value="">Meslek Seçin</option>
                    @foreach($professions as $profession)
                        <option value="{{ $profession->id }}" {{ old('profession_id', $user->profession_id) == $profession->id ? 'selected' : '' }}>
                            {{ $profession->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('profession_id')" />
            </div>

            <!-- Retirement Detail -->
            <div id="retirement_detail_div_profile" style="display: {{ old('profession_id', $user->profession_id) == 82 ? 'block' : 'none' }};">
                <x-input-label for="retirement_detail" value="Ne Emeklisi? (Opsiyonel)" />
                <x-text-input id="retirement_detail" name="retirement_detail" type="text" class="mt-1 block w-full" :value="old('retirement_detail', $user->retirement_detail)" placeholder="Örn: Doktor, Öğretmen, Polis..." />
                <x-input-error class="mt-2" :messages="$errors->get('retirement_detail')" />
                <small class="text-muted">Emekli olmadan önceki mesleğinizi yazabilirsiniz.</small>
            </div>

            <!-- Doğum Yılı -->
            <div>
                <x-input-label for="birth_year" value="Doğum Tarihi" />
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-calendar-heart"></i>
                    </span>
                    <input id="birth_date" 
                           name="birth_date" 
                           type="date" 
                           class="form-control" 
                           value="{{ old('birth_date', $user->birth_year ? $user->birth_year . '-01-01' : '') }}"
                           min="1900-01-01" 
                           max="{{ date('Y-m-d') }}"
                           onchange="updateBirthYear(this.value)">
                </div>
                <!-- Hidden field to store birth year -->
                <input type="hidden" id="birth_year" name="birth_year" value="{{ old('birth_year', $user->birth_year) }}">
                <x-input-error class="mt-2" :messages="$errors->get('birth_year')" />
                <small class="text-muted">Sadece doğum yılınız kaydedilir ve görüntülenir</small>
            </div>

            <!-- Şehir -->
            <div>
                <x-input-label for="current_city" value="Yaşadığınız Şehir" />
                <select id="current_city" name="current_city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="updateDistrictsProfile()">
                    <option value="">Şehir Seçin</option>
                    @foreach($cities as $cityName => $districts)
                        <option value="{{ $cityName }}" {{ old('current_city', $user->current_city) == $cityName ? 'selected' : '' }}>
                            {{ $cityName }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('current_city')" />
            </div>

            <!-- İlçe -->
            <div>
                <x-input-label for="current_district" value="İlçe" />
                <select id="current_district" name="current_district" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">İlçe Seçin</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('current_district')" />
            </div>

            <!-- Telefon -->
            <div>
                <x-input-label for="phone" value="Telefon Numarası" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="0555 123 45 67" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- Telefon Gösterimi -->
            <div class="flex items-center">
                <input type="hidden" name="show_phone" value="0">
                <input id="show_phone" name="show_phone" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('show_phone', $user->show_phone) ? 'checked' : '' }}>
                <label for="show_phone" class="ml-2 text-sm text-gray-600">
                    📞 Telefon numaramı herkese göster
                </label>
            </div>
        </div>

        <!-- Hakkımda -->
        <div class="mt-6">
            <x-input-label for="bio" value="Hakkımda" />
            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Kendinizi kısaca tanıtın...">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            <p class="mt-1 text-sm text-gray-500">Maksimum 1000 karakter</p>
        </div>

        <div class="flex items-center gap-4 mt-8">
            <x-primary-button class="px-6 py-3">
                💾 Kaydet
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 bg-green-50 px-3 py-2 rounded-md border border-green-200"
                >✅ Profil başarıyla güncellendi!</p>
            @endif
        </div>
    </form>

    <script>
        const citiesProfile = @json($cities);
        
        function updateDistrictsProfile() {
            const citySelect = document.getElementById('current_city');
            const districtSelect = document.getElementById('current_district');
            const selectedCity = citySelect.value;
            
            // İlçe seçimini temizle
            districtSelect.innerHTML = '<option value="">İlçe Seçin</option>';
            
            if (selectedCity && citiesProfile[selectedCity]) {
                citiesProfile[selectedCity].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    if ('{{ old("current_district", $user->current_district) }}' === district) {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            }
        }
        
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function toggleRetirementDetailProfile() {
            const retirementDetailDiv = document.getElementById('retirement_detail_div_profile');
            const selectedProfession = document.getElementById('profession_id').value;
            
            if (selectedProfession === '82') {
                retirementDetailDiv.style.display = 'block';
            } else {
                retirementDetailDiv.style.display = 'none';
            }
        }
        
        // Sayfa yüklendiğinde çalıştır
        document.addEventListener('DOMContentLoaded', function() {
            updateDistrictsProfile();
            toggleRetirementDetailProfile(); // Emekli alanını kontrol et
        });
    </script>
</section>
