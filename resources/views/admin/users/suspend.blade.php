<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-orange-600">Kullanıcıyı Askıya Al</h1>
            
            <div class="bg-orange-50 border border-orange-200 p-6 rounded-lg">
                <div class="flex items-center mb-6">
                    <svg class="h-8 w-8 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-orange-800">Kullanıcı Askıya Alma İşlemi</h2>
                </div>
                
                <div class="mb-6 p-4 bg-white rounded border">
                    <h3 class="font-medium text-gray-900 mb-2">Askıya Alınacak Kullanıcı:</h3>
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
                
                <div class="mb-6 p-4 bg-orange-100 rounded border border-orange-300">
                    <h3 class="font-medium text-orange-800 mb-2">Bu işlem şunları yapacaktır:</h3>
                    <ul class="list-disc list-inside text-sm text-orange-700 space-y-1">
                        <li>Kullanıcının hesabı geçici olarak askıya alınacak</li>
                        <li>Kullanıcı sisteme giriş yapamayacak</li>
                        <li>Mesaj gönderme ve alma işlemleri durduracak</li>
                        <li>Askı süresi dolduğunda otomatik olarak kaldırılacak</li>
                    </ul>
                </div>
                
                <form action="{{ route('admin.users.suspend.store', $user) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="reason" class="block text-sm font-medium text-orange-700 mb-2">Askıya Alma Sebebi *</label>
                        <textarea name="reason" id="reason" rows="4" required
                                  class="w-full border-orange-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                  placeholder="Kullanıcının neden askıya alındığını açıklayın...">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="duration" class="block text-sm font-medium text-orange-700 mb-2">Askı Süresi *</label>
                        <select name="duration" id="duration" required
                                class="w-full border-orange-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Süre Seçin</option>
                            <option value="3_months" {{ old('duration') === '3_months' ? 'selected' : '' }}>3 Ay (Geçici Askı)</option>
                            <option value="permanent" {{ old('duration') === 'permanent' ? 'selected' : '' }}>Süresiz (Kalıcı Askı)</option>
                        </select>
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="confirmSuspend" required class="rounded border-orange-300 text-orange-600 focus:ring-orange-500">
                            <span class="ml-2 text-sm text-orange-700">Bu kullanıcıyı askıya almak istediğimi onaylıyorum</span>
                        </label>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="submit" id="suspendButton" disabled
                                class="bg-orange-600 text-white px-6 py-3 rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed hover:bg-orange-700">
                            Kullanıcıyı Askıya Al
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
            const confirmCheckbox = document.getElementById('confirmSuspend');
            const suspendButton = document.getElementById('suspendButton');
            
            confirmCheckbox.addEventListener('change', function() {
                suspendButton.disabled = !this.checked;
            });
            
            // Form gönderilmeden önce son onay
            suspendButton.addEventListener('click', function(e) {
                const duration = document.getElementById('duration').value;
                const durationText = duration === '3_months' ? '3 ay boyunca' : 'süresiz olarak';
                
                if (!confirm('Bu kullanıcıyı ' + durationText + ' askıya almak istediğinizden emin misiniz?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout> 