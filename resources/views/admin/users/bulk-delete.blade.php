<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-red-600">Toplu Kullanıcı Silme</h1>
            
            <div class="bg-red-50 border border-red-200 p-6 rounded-lg">
                <div class="flex items-center mb-6">
                    <svg class="h-8 w-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-red-800">DİKKAT: Bu işlem geri alınamaz!</h2>
                </div>
                
                <div class="mb-6 p-4 bg-white rounded border">
                    <h3 class="font-medium text-gray-900 mb-4">Silinecek Kullanıcılar ({{ $users->count() }} kullanıcı):</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto">
                        @foreach($users as $user)
                            <div class="flex items-center p-3 bg-gray-50 rounded border">
                                <img class="h-10 w-10 rounded-full object-cover mr-3" 
                                     src="{{ $user->getVisibleProfilePhotoUrl(auth()->user()) }}" 
                                     alt="{{ $user->name }}">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    <p class="text-sm text-gray-600">#{{ $user->unique_user_id }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mb-6 p-4 bg-red-100 rounded border border-red-300">
                    <h3 class="font-medium text-red-800 mb-2">Bu işlem şunları yapacaktır:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        <li>{{ $users->count() }} kullanıcının hesabı kalıcı olarak silinecek</li>
                        <li>Tüm mesajları ve profil bilgileri silinecek</li>
                        <li>Bu işlem geri alınamaz</li>
                        <li>Kullanıcı verilerinin arşivi admin notlarında saklanacak</li>
                    </ul>
                </div>
                
                <form action="{{ route('admin.users.bulk-delete.store') }}" method="POST">
                    @csrf
                    
                    @foreach($users as $user)
                        <input type="hidden" name="user_ids[]" value="{{ $user->id }}">
                    @endforeach
                    
                    <div class="mb-6">
                        <label for="reason" class="block text-sm font-medium text-red-700 mb-2">Toplu Silme Sebebi *</label>
                        <textarea name="reason" id="reason" rows="4" required
                                  class="w-full border-red-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                                  placeholder="Bu kullanıcıların neden toplu olarak silindiğini açıklayın...">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="admin_password" class="block text-sm font-medium text-red-700 mb-2">Admin Şifreniz *</label>
                        <input type="password" name="admin_password" id="admin_password" required
                               class="w-full border-red-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                               placeholder="Güvenlik için admin şifrenizi girin">
                        @error('admin_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="confirmDelete" required class="rounded border-red-300 text-red-600 focus:ring-red-500">
                            <span class="ml-2 text-sm text-red-700">Bu {{ $users->count() }} kullanıcıyı kalıcı olarak silmek istediğimi onaylıyorum</span>
                        </label>
                    </div>
                    
                    <div class="mb-6 p-4 bg-yellow-100 border border-yellow-300 rounded">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <p class="text-sm text-yellow-800">
                                <strong>Son Uyarı:</strong> Bu işlem {{ $users->count() }} kullanıcıyı kalıcı olarak silecektir ve geri alınamaz!
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="submit" id="deleteButton" disabled
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed hover:bg-red-700">
                            {{ $users->count() }} Kullanıcıyı Sil
                        </button>
                        <a href="{{ route('admin.users.index') }}" 
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
            const confirmCheckbox = document.getElementById('confirmDelete');
            const deleteButton = document.getElementById('deleteButton');
            
            confirmCheckbox.addEventListener('change', function() {
                deleteButton.disabled = !this.checked;
            });
            
            // Form gönderilmeden önce son onay
            deleteButton.addEventListener('click', function(e) {
                if (!confirm('{{ $users->count() }} kullanıcıyı kalıcı olarak silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout> 