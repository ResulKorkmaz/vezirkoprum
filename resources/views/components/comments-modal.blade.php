<!-- Yorum Modal -->
<div id="commentsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                </svg>
                <h3 class="text-lg font-bold text-gray-900">Yorumlar</h3>
                <span id="modalCommentCount" class="px-2 py-1 bg-gray-100 text-gray-600 text-sm rounded-full">0</span>
            </div>
            <button onclick="closeCommentsModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body - Scrollable Comments -->
        <div class="flex-1 overflow-y-auto p-6">
            <div id="modalCommentsList" class="space-y-4">
                <!-- Comments will be loaded here -->
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-rose-500"></div>
                    <p class="mt-2 text-gray-500">Yorumlar yükleniyor...</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer - Comment Form -->
        <!-- Gizli post ID input - herkese erişilebilir -->
        <input type="hidden" id="modalPostId" value="">
        
        @auth
        <div class="border-t border-gray-200 p-6">
            <form id="modalCommentForm" onsubmit="submitModalComment(event)" class="space-y-4">
                @csrf
                
                <div class="flex items-start space-x-3">
                    <img class="w-10 h-10 rounded-full border-2 border-gray-200" 
                         src="{{ auth()->user()->profile_photo_url }}" 
                         alt="{{ auth()->user()->name }}">
                    <div class="flex-1">
                        <textarea name="content" 
                                  id="modalCommentContent"
                                  placeholder="Yorumunuzu yazın..." 
                                  rows="3" 
                                  maxlength="500"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400 resize-none text-sm"></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center space-x-4">
                                <span class="text-xs text-gray-500">
                                    <span id="modalCharCount">0</span>/500 karakter
                                </span>
                                <span class="text-xs text-gray-400">⏎ Enter ile gönder</span>
                            </div>
                            <button type="submit" 
                                    id="modalCommentSubmit"
                                    class="px-6 py-2 bg-rose-500 text-white text-sm font-medium rounded-lg hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-colors">
                                <span id="modalSubmitText">Gönder</span>
                                <svg id="modalSubmitLoader" class="hidden w-4 h-4 animate-spin ml-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @else
        <div class="border-t border-gray-200 p-6 text-center">
            <p class="text-gray-500 mb-4">Yorum yapmak için giriş yapmanız gerekiyor.</p>
            <a href="{{ route('login') }}" 
               class="inline-flex items-center px-4 py-2 bg-rose-500 text-white text-sm font-medium rounded-lg hover:bg-rose-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Giriş Yap
            </a>
        </div>
        @endauth
    </div>
</div>

<style>
/* Modal animasyonları */
#commentsModal.show {
    animation: modalFadeIn 0.3s ease-out;
}

#commentsModal.show .bg-white {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes modalSlideIn {
    from { 
        opacity: 0;
        transform: scale(0.9) translateY(-20px); 
    }
    to { 
        opacity: 1;
        transform: scale(1) translateY(0); 
    }
}

/* Scrollbar styling */
#modalCommentsList::-webkit-scrollbar {
    width: 6px;
}

#modalCommentsList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#modalCommentsList::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

#modalCommentsList::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style> 