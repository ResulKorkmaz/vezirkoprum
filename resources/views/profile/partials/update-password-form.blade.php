<section>
    <header>
        <h2 class="h5 mb-3">
            Şifre Güncelle
        </h2>

        <p class="text-muted mb-4">
            Hesabınızın güvenliğini sağlamak için uzun ve karmaşık bir şifre kullandığınızdan emin olun.
        </p>
    </header>

    <!-- Alert alanı -->
    <div id="password-alert" class="d-none"></div>

    <form id="password-form" method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Mevcut Şifre</label>
            <input type="password" 
                   class="form-control" 
                   id="update_password_current_password" 
                   name="current_password" 
                   autocomplete="current-password"
                   required>
            <div class="invalid-feedback" id="current_password_error"></div>
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Yeni Şifre</label>
            <input type="password" 
                   class="form-control" 
                   id="update_password_password" 
                   name="password" 
                   autocomplete="new-password"
                   required>
            <div class="invalid-feedback" id="password_error"></div>
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Şifre Tekrarı</label>
            <input type="password" 
                   class="form-control" 
                   id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   autocomplete="new-password"
                   required>
            <div class="invalid-feedback" id="password_confirmation_error"></div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary" id="password-submit-btn">
                <span id="submit-text">
                    <i class="bi bi-check-lg me-2"></i>Kaydet
                </span>
                <span id="submit-loading" class="d-none">
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Kaydediliyor...
                </span>
            </button>
        </div>
    </form>

    <script>
        document.getElementById('password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('password-submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitLoading = document.getElementById('submit-loading');
            const alertDiv = document.getElementById('password-alert');
            
            // Loading state
            submitBtn.disabled = true;
            submitText.classList.add('d-none');
            submitLoading.classList.remove('d-none');
            
            // Clear previous errors
            form.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(error => {
                error.textContent = '';
            });
            alertDiv.classList.add('d-none');
            
            // Prepare form data
            const formData = new FormData(form);
            // Laravel için PUT method'unu ekle
            formData.append('_method', 'PUT');
            
            // Submit form with proper headers
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const data = await response.json();
                
                if (response.ok) {
                    // Success
                    if (data.success || data.message === 'password-updated') {
                        alertDiv.className = 'alert alert-success mb-3';
                        alertDiv.innerHTML = '<i class="bi bi-check-circle me-2"></i>Şifreniz başarıyla değiştirildi!';
                        alertDiv.classList.remove('d-none');
                        
                        // Clear form
                        form.reset();
                        
                        // Close modal after 2 seconds
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('passwordModal'));
                            if (modal) {
                                modal.hide();
                            }
                            alertDiv.classList.add('d-none');
                        }, 2000);
                    }
                } else if (response.status === 422) {
                    // Validation errors
                    if (data.errors) {
                        // Show field-specific validation errors
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const input = form.querySelector(`[name="${field}"]`);
                            const errorDiv = document.getElementById(`${field}_error`);
                            if (input && errorDiv) {
                                input.classList.add('is-invalid');
                                errorDiv.textContent = messages[0];
                            }
                        }
                    } else {
                        // Generic validation error
                        alertDiv.className = 'alert alert-danger mb-3';
                        alertDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Girilen bilgilerde hata var. Lütfen kontrol edin.';
                        alertDiv.classList.remove('d-none');
                    }
                } else {
                    // Other server errors
                    alertDiv.className = 'alert alert-danger mb-3';
                    alertDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Şifre değiştirilemedi. Lütfen tekrar deneyin.';
                    alertDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alertDiv.className = 'alert alert-danger mb-3';
                alertDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Bir hata oluştu. Lütfen tekrar deneyin.';
                alertDiv.classList.remove('d-none');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitText.classList.remove('d-none');
                submitLoading.classList.add('d-none');
            });
        });
    </script>
</section>
