<!-- Report Modal -->
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden p-4" style="z-index: 9999 !important;">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">İçeriği Bildir</h3>
                </div>
                <button type="button" onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <p class="text-gray-600 mb-6">Bu içerik topluluk kurallarına aykırı mı? Bize bildirin.</p>

            <!-- Reported Content Info -->
            <div id="reportedContentInfo" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-semibold text-gray-800 mb-2">Bildirilen İçerik:</h4>
                <div id="contentDetails" class="text-sm text-gray-700"></div>
            </div>

            <!-- Report Form -->
            <form id="reportForm" class="space-y-5">
                @csrf
                <input type="hidden" id="reportType" name="type">
                <input type="hidden" id="reportId" name="item_id">

                <!-- Reason Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Bildiri Nedeni</label>
                    <select id="reportReason" name="reason" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4 text-gray-900" required>
                        <option value="">Neden seçin...</option>
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Açıklama <span class="text-gray-500 font-normal">(İsteğe bağlı)</span></label>
                    <textarea 
                        id="reportDescription" 
                        name="description" 
                        rows="4" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 py-3 px-4 text-gray-900 resize-none"
                        placeholder="Bu bildiri hakkında daha fazla detay ekleyebilirsiniz..."
                        maxlength="500"
                    ></textarea>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-xs text-gray-500">Bildiri nedeninizi detaylandırabilirsiniz</p>
                        <span class="text-xs text-gray-400" id="charCount">0/500</span>
                    </div>
                </div>

                <!-- reCAPTCHA -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <x-recaptcha action="report" />
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3 pt-2">
                    <button 
                        type="button" 
                        onclick="closeReportModal()"
                        class="flex-1 px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400"
                    >
                        İptal
                    </button>
                    <button 
                        type="submit" 
                        id="reportSubmitBtn"
                        class="flex-1 px-6 py-3 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Bildir
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Report Modal Functions
let reportModalData = {};

async function openReportModal(type, id) {
    try {
        // Modal verilerini al
        const response = await fetch(`/reports/create?type=${type}&id=${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        if (!data.success) {
            showModernToast(data.message, 'error');
            return;
        }

        // Modal verilerini sakla
        reportModalData = data.data;

        // Form alanlarını doldur
        document.getElementById('reportType').value = data.data.type;
        document.getElementById('reportId').value = data.data.id;

        // İçerik bilgilerini göster
        const contentInfoDiv = document.getElementById('reportedContentInfo');
        const contentDetailsDiv = document.getElementById('contentDetails');
        
        if (data.data.content_info) {
            const contentInfo = data.data.content_info;
            let contentHtml = '';
            
            if (data.data.type === 'comment') {
                contentHtml = `
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.906-1.289L3 21l1.289-5.094A9.863 9.863 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="bg-white rounded-lg p-3 border">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900">${contentInfo.user_name}</span>
                                    <span class="text-xs text-gray-500">${contentInfo.created_at}</span>
                                </div>
                                <p class="text-gray-700">"${contentInfo.content}"</p>
                            </div>
                        </div>
                    </div>
                `;
            } else if (data.data.type === 'post') {
                contentHtml = `
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="bg-white rounded-lg p-3 border">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900">${contentInfo.user_name}</span>
                                    <span class="text-xs text-gray-500">${contentInfo.created_at}</span>
                                </div>
                                <p class="text-gray-700">"${contentInfo.content}"</p>
                            </div>
                        </div>
                    </div>
                `;
            } else if (data.data.type === 'message') {
                contentHtml = `
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="bg-white rounded-lg p-3 border">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900">${contentInfo.user_name}</span>
                                    <span class="text-xs text-gray-500">${contentInfo.created_at}</span>
                                </div>
                                <p class="text-gray-700">"${contentInfo.content}"</p>
                            </div>
                        </div>
                    </div>
                `;
            } else if (data.data.type === 'user') {
                contentHtml = `
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="bg-white rounded-lg p-3 border">
                                <p class="font-medium text-gray-900">${contentInfo.name}</p>
                                <p class="text-sm text-gray-600">${contentInfo.email}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            contentDetailsDiv.innerHTML = contentHtml;
            contentInfoDiv.classList.remove('hidden');
        } else {
            contentInfoDiv.classList.add('hidden');
        }

        // Reason dropdown'ını doldur
        const reasonSelect = document.getElementById('reportReason');
        reasonSelect.innerHTML = '<option value="">Neden seçin</option>';
        
        Object.entries(data.data.reasons).forEach(([key, value]) => {
            const option = document.createElement('option');
            option.value = key;
            option.textContent = value;
            reasonSelect.appendChild(option);
        });

        // Comments modal'ı geçici olarak gizle
        const commentsModal = document.getElementById('commentsModal');
        let commentsWasVisible = false;
        if (commentsModal && !commentsModal.classList.contains('hidden')) {
            commentsWasVisible = true;
            commentsModal.style.display = 'none';
        }
        
        // Modal'ı göster
        document.getElementById('reportModal').classList.remove('hidden');
        document.getElementById('reportModal').setAttribute('data-comments-was-visible', commentsWasVisible);
        
        // Scroll'u kilitle
        document.body.style.overflow = 'hidden';
        
        // Character counter'ı initialize et
        const textarea = document.getElementById('reportDescription');
        const charCount = document.getElementById('charCount');
        
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = `${currentLength}/500`;
            
            if (currentLength > 450) {
                charCount.className = 'text-xs text-orange-500 font-medium';
            } else if (currentLength > 400) {
                charCount.className = 'text-xs text-yellow-500';
            } else {
                charCount.className = 'text-xs text-gray-400';
            }
        });
        
    } catch (error) {
        console.error('Report modal error:', error);
        showModernToast('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
    }
}

function closeReportModal() {
    const reportModal = document.getElementById('reportModal');
    const commentsWasVisible = reportModal.getAttribute('data-comments-was-visible') === 'true';
    
    reportModal.classList.add('hidden');
    document.getElementById('reportForm').reset();
    reportModalData = {};
    
    // İçerik bilgilerini temizle
    const contentInfoDiv = document.getElementById('reportedContentInfo');
    const contentDetailsDiv = document.getElementById('contentDetails');
    contentInfoDiv.classList.add('hidden');
    contentDetailsDiv.innerHTML = '';
    
    // Comments modal'ı geri göster
    const commentsModal = document.getElementById('commentsModal');
    if (commentsModal && commentsWasVisible) {
        commentsModal.style.display = '';
        document.body.style.overflow = 'hidden'; // Comments modal açık olduğu için scroll kilitle
    } else {
        document.body.style.overflow = 'auto'; // Normal scroll'a dön
    }
    
    // Character counter'ı reset et
    const charCount = document.getElementById('charCount');
    if (charCount) {
        charCount.textContent = '0/500';
        charCount.className = 'text-xs text-gray-400';
    }
}

// Report Form Submit
document.getElementById('reportForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('reportSubmitBtn');
    const originalText = submitBtn.textContent;
    
    // Button durumunu değiştir
    submitBtn.disabled = true;
    submitBtn.textContent = 'Bildiriliyor...';
    
    try {
        // reCAPTCHA token ekle
        await addRecaptchaToForm(this, 'report');
        
        // Form verilerini al
        const formData = new FormData(this);
        
        // AJAX ile gönder
        const response = await fetch('/reports', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        if (data.success) {
            showModernToast(data.message, 'success');
            closeReportModal();
        } else {
            showModernToast(data.message || 'Bir hata oluştu.', 'error');
        }

    } catch (error) {
        console.error('Report submit error:', error);
        showModernToast('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
    } finally {
        // Button durumunu eski haline getir
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

// Modal dışına tıklandığında kapat
document.getElementById('reportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReportModal();
    }
});

// Modern Toast Notification System
function showModernToast(message, type = 'info', duration = 4000) {
    // Toast container oluştur (yoksa)
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'fixed top-4 right-4 z-[9999] space-y-2';
        document.body.appendChild(toastContainer);
    }
    
    // Toast element oluştur
    const toast = document.createElement('div');
    toast.className = `transform transition-all duration-300 ease-in-out translate-x-full opacity-0`;
    
    // Tip'e göre renk ve ikon belirle
    let bgColor, textColor, icon;
    switch(type) {
        case 'success':
            bgColor = 'bg-green-500';
            textColor = 'text-white';
            icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>`;
            break;
        case 'error':
            bgColor = 'bg-red-500';
            textColor = 'text-white';
            icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>`;
            break;
        case 'warning':
            bgColor = 'bg-yellow-500';
            textColor = 'text-white';
            icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>`;
            break;
        case 'info':
        default:
            bgColor = 'bg-blue-500';
            textColor = 'text-white';
            icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`;
            break;
    }
    
    toast.innerHTML = `
        <div class="${bgColor} ${textColor} px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 min-w-[320px] max-w-md">
            <div class="flex-shrink-0">
                ${icon}
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 opacity-70 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    // Toast'ı container'a ekle
    toastContainer.appendChild(toast);
    
    // Animasyonlu gösterim
    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
    });
    
    // Otomatik kaldırma
    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.parentElement.removeChild(toast);
            }
        }, 300);
    }, duration);
}
</script> 