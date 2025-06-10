<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-red-600">Kullanıcıyı Kalıcı Yasakla</h1>
            
            <div class="bg-red-50 border border-red-200 p-6 rounded-lg">
                <div class="flex items-center mb-6">
                    <svg class="h-8 w-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-red-800">DİKKAT: Bu işlem geri alınamaz!</h2>
                </div>
                
                <div class="mb-6 p-4 bg-white rounded border">
                    <h3 class="font-medium text-gray-900 mb-2">Yasaklanacak Kullanıcı:</h3>
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
                
                <div class="mb-6 p-4 bg-red-100 rounded border border-red-300">
                    <h3 class="font-medium text-red-800 mb-2">Bu işlem şunları yapacaktır:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        <li>Kullanıcının hesabı kalıcı olarak yasaklanacak</li>
                        <li>Hesap tamamen silinecek ve geri getirilemeyecek</li>
                        <li>Aynı e-posta ile bir daha kayıt olamayacak</li>
                        <li>Aynı telefon numarası ile bir daha kayıt olamayacak</li>
                        <li>Bu işlem geri alınamaz!</li>
                    </ul>
                </div>
                
                <form action="{{ route('admin.users.ban.store', $user) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="reason" class="block text-sm font-medium text-red-700 mb-2">Yasaklama Sebebi *</label>
                        <textarea name="reason" id="reason" rows="4" required
                                  class="w-full border-red-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                                  placeholder="Kullanıcının neden kalıcı olarak yasaklandığını detaylı açıklayın...">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="confirmBan" required class="rounded border-red-300 text-red-600 focus:ring-red-500">
                            <span class="ml-2 text-sm text-red-700">Bu kullanıcıyı kalıcı olarak yasaklamak istediğimi onaylıyorum</span>
                        </label>
                    </div>
                    
                    <div class="mb-6 p-4 bg-yellow-100 border border-yellow-300 rounded">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <p class="text-sm text-yellow-800">
                                <strong>Son Uyarı:</strong> Bu işlem kullanıcıyı kalıcı olarak yasaklayacak ve hesabını silecektir. Bu işlem geri alınamaz!
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="submit" id="banButton" disabled
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed hover:bg-red-700">
                            Kalıcı Yasakla
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
            const confirmCheckbox = document.getElementById('confirmBan');
            const banButton = document.getElementById('banButton');
            
            confirmCheckbox.addEventListener('change', function() {
                banButton.disabled = !this.checked;
            });
            
            // Form gönderilmeden önce son onay
            banButton.addEventListener('click', function(e) {
                if (!confirm('Bu kullanıcıyı kalıcı olarak yasaklamak istediğinizden emin misiniz? Bu işlem GERİ ALINAMAZ!')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout> 