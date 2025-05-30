<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-blue-600">Kullanıcı Şifresi Sıfırla</h1>
            
            <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg">
                <div class="flex items-center mb-6">
                    <svg class="h-8 w-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3a1 1 0 011-1h2.586l6.414-6.414a6 6 0 015.743-7.743z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-blue-800">Şifre Sıfırlama İşlemi</h2>
                </div>
                
                <div class="mb-6 p-4 bg-white rounded border">
                    <h3 class="font-medium text-gray-900 mb-2">Şifresi Sıfırlanacak Kullanıcı:</h3>
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full object-cover mr-4" 
                             src="{{ $user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                             alt="{{ $user->name }}">
                        <div>
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            <p class="text-sm text-gray-600">#{{ $user->unique_user_id }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6 p-4 bg-blue-100 rounded border border-blue-300">
                    <h3 class="font-medium text-blue-800 mb-2">Bu işlem şunları yapacaktır:</h3>
                    <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                        <li>Kullanıcının mevcut şifresi değiştirilecek</li>
                        <li>Kullanıcı yeni şifre ile giriş yapabilecek</li>
                        <li>Eski şifre artık geçerli olmayacak</li>
                        <li>Kullanıcıya yeni şifre bildirilmelidir</li>
                    </ul>
                </div>
                
                <form action="{{ route('admin.users.reset-password.store', $user) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-blue-700 mb-2">Yeni Şifre *</label>
                        <input type="password" name="password" id="password" required
                               class="w-full border-blue-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="En az 8 karakter olmalıdır">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-blue-700 mb-2">Şifre Onayı *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full border-blue-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Yeni şifreyi tekrar girin">
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="confirmReset" required class="rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-blue-700">Bu kullanıcının şifresini sıfırlamak istediğimi onaylıyorum</span>
                        </label>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="submit" id="resetButton" disabled
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed hover:bg-blue-700">
                            Şifreyi Sıfırla
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" 
                           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-700">
                            İptal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmCheckbox = document.getElementById('confirmReset');
            const resetButton = document.getElementById('resetButton');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            confirmCheckbox.addEventListener('change', function() {
                resetButton.disabled = !this.checked;
            });
            
            // Şifre eşleşme kontrolü
            function checkPasswordMatch() {
                if (confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('Şifreler eşleşmiyor');
                } else {
                    confirmPasswordInput.setCustomValidity('');
                }
            }
            
            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            
            // Form gönderilmeden önce son onay
            resetButton.addEventListener('click', function(e) {
                if (!confirm('Bu kullanıcının şifresini sıfırlamak istediğinizden emin misiniz?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout> 