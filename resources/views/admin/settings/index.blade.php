<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl mb-8 border border-rose-100">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                <span class="bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                                    Site Ayarları
                                </span>
                            </h1>
                            <p class="text-gray-600">Site genelinde kullanılan ayarları buradan yönetebilirsiniz.</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m0 7h18"></path>
                                </svg>
                                Dashboard'a Dön
                            </a>
                            <button onclick="document.getElementById('defaultsModal').classList.remove('hidden')"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Varsayılan Ayarları Yükle
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-red-800">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Settings Form -->
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
                @csrf
                @method('PUT')

                @if($groupedSettings->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Henüz ayar bulunmuyor</h3>
                        <p class="mt-1 text-sm text-gray-500">Başlamak için varsayılan ayarları yükleyebilirsiniz.</p>
                    </div>
                @else
                    <!-- Settings Groups -->
                    @foreach($groupedSettings as $groupName => $settings)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900">
                                    @switch($groupName)
                                        @case('general')
                                            🏠 Genel Ayarlar
                                            @break
                                        @case('appearance')
                                            🎨 Görünüm Ayarları
                                            @break
                                        @case('seo')
                                            🔍 SEO Ayarları
                                            @break
                                        @case('social')
                                            📱 Sosyal Medya
                                            @break
                                        @case('email')
                                            📧 E-posta Ayarları
                                            @break
                                        @default
                                            📋 {{ ucfirst($groupName) }}
                                    @endswitch
                                </h2>
                            </div>
                            
                            <div class="p-6 space-y-6">
                                @foreach($settings as $setting)
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                                        <!-- Label & Description -->
                                        <div class="lg:col-span-1">
                                            <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700">
                                                {{ $setting->label }}
                                            </label>
                                            @if($setting->description)
                                                <p class="mt-1 text-sm text-gray-500">{{ $setting->description }}</p>
                                            @endif
                                        </div>

                                        <!-- Input Field -->
                                        <div class="lg:col-span-2">
                                            @switch($setting->type)
                                                @case('text')
                                                @case('email')
                                                @case('url')
                                                    <input type="{{ $setting->type }}" 
                                                           id="setting_{{ $setting->key }}"
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="{{ $setting->value }}"
                                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                                                    @break

                                                @case('number')
                                                    <input type="number" 
                                                           id="setting_{{ $setting->key }}"
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="{{ $setting->value }}"
                                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                                                    @break

                                                @case('textarea')
                                                    <textarea id="setting_{{ $setting->key }}"
                                                              name="settings[{{ $setting->key }}]" 
                                                              rows="3"
                                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500">{{ $setting->value }}</textarea>
                                                    @break

                                                @case('boolean')
                                                    <div class="flex items-center">
                                                        <label class="relative inline-flex items-center cursor-pointer">
                                                            <input type="checkbox" 
                                                                   id="setting_{{ $setting->key }}"
                                                                   name="settings[{{ $setting->key }}]" 
                                                                   value="1"
                                                                   {{ $setting->value ? 'checked' : '' }}
                                                                   class="sr-only peer">
                                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600"></div>
                                                            <span class="ml-3 text-sm text-gray-700">{{ $setting->value ? 'Aktif' : 'Pasif' }}</span>
                                                        </label>
                                                    </div>
                                                    @break

                                                @case('select')
                                                    <select id="setting_{{ $setting->key }}"
                                                            name="settings[{{ $setting->key }}]"
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                                                        @if($setting->options)
                                                            @foreach($setting->options as $optionValue => $optionLabel)
                                                                <option value="{{ $optionValue }}" {{ $setting->value == $optionValue ? 'selected' : '' }}>
                                                                    {{ $optionLabel }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @break
                                            @endswitch
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Save Button -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 text-white rounded-lg font-medium"
                                    style="background: linear-gradient(to right, #B76E79, #A85D68);">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Ayarları Kaydet
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Initialize Defaults Modal -->
    <div id="defaultsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="mt-2 px-7 py-3">
                    <h3 class="text-lg font-medium text-gray-900 text-center">Varsayılan Ayarları Yükle</h3>
                    <p class="text-sm text-gray-500 mt-2 text-center">
                        Bu işlem site için gerekli temel ayarları oluşturacak.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 mt-4">
                    <button onclick="document.getElementById('defaultsModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        İptal
                    </button>
                    <form method="POST" action="{{ route('admin.settings.initialize') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Yükle
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<script>
// Toggle labels for boolean inputs
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('input[type="checkbox"]');
    toggles.forEach(function(toggle) {
        const label = toggle.parentNode.querySelector('span');
        if (label) {
            toggle.addEventListener('change', function() {
                label.textContent = this.checked ? 'Aktif' : 'Pasif';
            });
        }
    });
});
</script> 