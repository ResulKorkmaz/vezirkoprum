<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid grid-cols-1 gap-4">
        <!-- Name -->
        <div>
                <x-input-label for="name" value="Ad Soyad" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
            <div>
                <x-input-label for="email" value="E-posta" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

            <!-- Profession -->
            <div>
                <x-input-label for="profession_id" value="Meslek *" />
                <select id="profession_id" name="profession_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Meslek Seçin</option>
                    @foreach(\App\Models\Profession::where('is_active', true)->orderBy('name')->get() as $profession)
                        <option value="{{ $profession->id }}" {{ old('profession_id') == $profession->id ? 'selected' : '' }}>
                            {{ $profession->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('profession_id')" class="mt-2" />
            </div>

            <!-- City -->
            <div>
                <x-input-label for="current_city" value="Yaşadığınız Şehir *" />
                <select id="current_city" name="current_city" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="updateDistrictsRegister()">
                    <option value="">Şehir Seçin</option>
                    @foreach(config('turkiye.cities') as $cityName => $districts)
                        <option value="{{ $cityName }}" {{ old('current_city') == $cityName ? 'selected' : '' }}>
                            {{ $cityName }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('current_city')" class="mt-2" />
            </div>

            <!-- District -->
            <div>
                <x-input-label for="current_district" value="İlçe *" />
                <select id="current_district" name="current_district" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">İlçe Seçin</option>
                </select>
                <x-input-error :messages="$errors->get('current_district')" class="mt-2" />
            </div>

        <!-- Password -->
            <div>
                <x-input-label for="password" value="Şifre" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="Şifre Tekrarı" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- KVKK Onay -->
        <div class="mt-6">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="kvkk_consent" name="kvkk_consent" type="checkbox" value="1" 
                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded {{ $errors->get('kvkk_consent') ? 'border-red-500' : '' }}" 
                           {{ old('kvkk_consent') ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                    <label for="kvkk_consent" class="text-gray-700">
                        <a href="{{ route('kvkk') }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">
                            Kişisel Verilerin Korunması Kanunu (KVKK)
                        </a> 
                        kapsamında kişisel verilerimin işlenmesini kabul ediyorum. *
                    </label>
                </div>
            </div>
            <x-input-error :messages="$errors->get('kvkk_consent')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-rose-600 hover:text-rose-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 font-medium" href="{{ route('login') }}">
                Zaten hesabınız var mı? Giriş Yapın
            </a>

            <x-primary-button class="ms-4">
                Kayıt Ol
            </x-primary-button>
        </div>
    </form>

    <!-- Login Call to Action -->
    <div class="mt-6 text-center">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Zaten hesabınız var mı?</span>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-emerald-600 hover:to-teal-600 focus:from-emerald-600 focus:to-teal-600 active:from-emerald-700 active:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Giriş Yap
            </a>
        </div>
    </div>

    <script>
        const citiesRegister = @json(config('turkiye.cities'));
        
        function updateDistrictsRegister() {
            const citySelect = document.getElementById('current_city');
            const districtSelect = document.getElementById('current_district');
            const selectedCity = citySelect.value;
            
            // İlçe seçimini temizle
            districtSelect.innerHTML = '<option value="">İlçe Seçin</option>';
            
            if (selectedCity && citiesRegister[selectedCity]) {
                citiesRegister[selectedCity].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    if ('{{ old("current_district") }}' === district) {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            }
        }
        
        // Sayfa yüklendiğinde çalıştır
        document.addEventListener('DOMContentLoaded', updateDistrictsRegister);
    </script>
</x-guest-layout>
