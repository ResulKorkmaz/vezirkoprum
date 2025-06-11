<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profil Bilgileri') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Hesap profil bilgilerinizi ve e-posta adresinizi güncelleyin.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profil Fotoğrafı -->
        <div>
            <x-input-label for="profile_photo" :value="__('Profil Fotoğrafı')" />
            
            <!-- Mevcut profil fotoğrafı -->
            @if(auth()->user()->profile_photo_path)
                <div class="mt-2 mb-4">
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                         alt="Profil Fotoğrafı" 
                         class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                    </div>
            @endif
            
            <input type="file" 
                   id="profile_photo" 
                   name="profile_photo" 
                   accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            
            <!-- Önizleme -->
            <div id="preview-container" class="mt-4 hidden">
                <img id="preview-image" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300" alt="Önizleme">
                        </div>
            
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
            <p class="mt-1 text-sm text-gray-500">JPG, PNG veya GIF formatında, maksimum 10MB</p>
                </div>
                
        <!-- Profil Fotoğrafı Görünürlük -->
        <div>
            <x-input-label for="profile_photo_visibility" :value="__('Profil Fotoğrafı Görünürlüğü')" />
            <select id="profile_photo_visibility" name="profile_photo_visibility" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo_visibility')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Ad Soyad -->
        <div>
                <x-input-label for="name" :value="__('Ad Soyad *')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

            <!-- E-posta -->
        <div>
                <x-input-label for="email" :value="__('E-posta *')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                            {{ __('E-posta adresiniz doğrulanmamış.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Doğrulama e-postasını tekrar gönder.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('E-posta adresinize yeni bir doğrulama bağlantısı gönderildi.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

            <!-- Meslek -->
            <div>
                <x-input-label for="profession_id" :value="__('Meslek')" />
                <select id="profession_id" name="profession_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleRetirementDetail()">
                    <option value="">Meslek Seçin</option>
                    @foreach($professions as $profession)
                        <option value="{{ $profession->id }}" {{ old('profession_id', $user->profession_id) == $profession->id ? 'selected' : '' }}>
                            {{ $profession->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('profession_id')" />
            </div>

            <!-- Emekli Detayı -->
            <div id="retirement_detail_div" style="display: {{ old('profession_id', $user->profession_id) == 82 ? 'block' : 'none' }};">
                <x-input-label for="retirement_detail" :value="__('Ne Emeklisi? (Opsiyonel)')" />
                <x-text-input id="retirement_detail" name="retirement_detail" type="text" class="mt-1 block w-full" :value="old('retirement_detail', $user->retirement_detail)" placeholder="Örn: Doktor, Öğretmen, Polis..." />
                <x-input-error class="mt-2" :messages="$errors->get('retirement_detail')" />
                <p class="mt-1 text-sm text-gray-500">Emekli olmadan önceki mesleğinizi yazabilirsiniz.</p>
            </div>

            <!-- Doğum Yılı -->
            <div>
                <x-input-label for="birth_year" :value="__('Doğum Yılı')" />
                <select id="birth_year" name="birth_year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Doğum Yılı Seçin</option>
                    @for($year = date('Y'); $year >= 1940; $year--)
                        <option value="{{ $year }}" {{ old('birth_year', $user->birth_year) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('birth_year')" />
            </div>

            <!-- Şehir -->
            <div>
                <x-input-label for="current_city" :value="__('Yaşadığınız Şehir')" />
                <select id="current_city" name="current_city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="updateDistricts()">
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
                <x-input-label for="current_district" :value="__('İlçe')" />
                <select id="current_district" name="current_district" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">İlçe Seçin</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('current_district')" />
            </div>

            <!-- Telefon -->
            <div>
                <x-input-label for="phone" :value="__('Telefon Numarası')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="0555 123 45 67" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            </div>

            <!-- Telefon Gösterimi -->
            <div class="flex items-center">
                <input type="hidden" name="show_phone" value="0">
                <input id="show_phone" name="show_phone" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('show_phone', $user->show_phone) ? 'checked' : '' }}>
                <label for="show_phone" class="ml-2 text-sm text-gray-600">
                    📞 Telefon numaramı herkese göster
                </label>
        </div>

        <!-- Hakkımda -->
        <div>
            <x-input-label for="bio" :value="__('Hakkımda')" />
            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Kendinizi kısaca tanıtın...">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            <p class="mt-1 text-sm text-gray-500">Maksimum 1000 karakter</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Kaydet') }}</x-primary-button>

            @if (session('status'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ session('status') }}</p>
            @endif
            
            @if (session('error'))
                <p class="text-sm text-red-600">{{ session('error') }}</p>
            @endif
        </div>
    </form>
</section>

    <script>
const cities = @json($cities);
        
document.getElementById('profile_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    
    if (file) {
        // Dosya boyutu kontrolü (10MB)
        if (file.size > 10 * 1024 * 1024) {
                            showModernToast('📁 Dosya boyutu 10MB\'dan büyük olamaz.', 'error');
            e.target.value = '';
            previewContainer.classList.add('hidden');
            return;
        }
        
        // Dosya tipi kontrolü
        if (!file.type.startsWith('image/')) {
                            showModernToast('🖼️ Lütfen bir resim dosyası seçin.', 'error');
            e.target.value = '';
            previewContainer.classList.add('hidden');
            return;
        }
        
        // Önizleme göster
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.classList.add('hidden');
    }
});

function updateDistricts() {
            const citySelect = document.getElementById('current_city');
            const districtSelect = document.getElementById('current_district');
            const selectedCity = citySelect.value;
            
            // İlçe seçimini temizle
            districtSelect.innerHTML = '<option value="">İlçe Seçin</option>';
            
    if (selectedCity && cities[selectedCity]) {
        cities[selectedCity].forEach(district => {
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
        
function toggleRetirementDetail() {
    const retirementDetailDiv = document.getElementById('retirement_detail_div');
            const selectedProfession = document.getElementById('profession_id').value;
            
            if (selectedProfession === '82') {
                retirementDetailDiv.style.display = 'block';
            } else {
                retirementDetailDiv.style.display = 'none';
            }
        }
        
// Sayfa yüklendiğinde ilçeleri güncelle
        document.addEventListener('DOMContentLoaded', function() {
    updateDistricts();
    toggleRetirementDetail();
        });
    </script>