<!-- Report Modal -->
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
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
            alert(data.message);
            return;
        }

        // Modal verilerini sakla
        reportModalData = data.data;

        // Form alanlarını doldur
        document.getElementById('reportType').value = data.data.type;
        document.getElementById('reportId').value = data.data.id;

        // Reason dropdown'ını doldur
        const reasonSelect = document.getElementById('reportReason');
        reasonSelect.innerHTML = '<option value="">Neden seçin</option>';
        
        Object.entries(data.data.reasons).forEach(([key, value]) => {
            const option = document.createElement('option');
            option.value = key;
            option.textContent = value;
            reasonSelect.appendChild(option);
        });

        // Modal'ı göster
        document.getElementById('reportModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Scroll'u kilitle
        
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
        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
    }
}

function closeReportModal() {
    document.getElementById('reportModal').classList.add('hidden');
    document.getElementById('reportForm').reset();
    document.body.style.overflow = 'auto'; // Scroll'u aç
    reportModalData = {};
    
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
            alert(data.message);
            closeReportModal();
        } else {
            alert(data.message || 'Bir hata oluştu.');
        }

    } catch (error) {
        console.error('Report submit error:', error);
        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
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
</script> 