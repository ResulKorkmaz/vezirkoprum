<!-- Report Modal -->
<div id="reportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">İçeriği Bildir</h3>
                <button type="button" onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Report Form -->
            <form id="reportForm" class="space-y-4">
                @csrf
                <input type="hidden" id="reportType" name="reportable_type">
                <input type="hidden" id="reportId" name="reportable_id">

                <!-- Reason Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bildiri Nedeni *</label>
                    <select id="reportReason" name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Neden seçin</option>
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Açıklama (İsteğe bağlı)</label>
                    <textarea 
                        id="reportDescription" 
                        name="description" 
                        rows="3" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Bildiri nedeninizi detaylandırabilirsiniz..."
                        maxlength="500"
                    ></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimum 500 karakter</p>
                </div>

                <!-- reCAPTCHA -->
                <div>
                    <x-recaptcha action="report" />
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button 
                        type="button" 
                        onclick="closeReportModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        İptal
                    </button>
                    <button 
                        type="submit" 
                        id="reportSubmitBtn"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
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
        document.getElementById('reportType').value = data.data.model_type;
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
        
    } catch (error) {
        console.error('Report modal error:', error);
        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
    }
}

function closeReportModal() {
    document.getElementById('reportModal').classList.add('hidden');
    document.getElementById('reportForm').reset();
    reportModalData = {};
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