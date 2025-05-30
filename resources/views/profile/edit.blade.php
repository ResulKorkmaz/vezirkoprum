<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profilim
        </h2>
    </x-slot>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container py-5">
        <!-- Success Notification -->
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" id="success-notification">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Başarılı!</strong> Profil başarıyla güncellendi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profil Üst Bölüm -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row align-items-start gap-4">
                    <!-- Avatar -->
                    <div class="position-relative">
                        <img src="{{ $user->getVisibleProfilePhotoUrl($user) }}" 
                             alt="{{ $user->name }} profil fotoğrafı" 
                             class="rounded shadow-sm"
                             style="width: 150px; height: 150px; object-fit: cover;"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjE1MCIgaGVpZ2h0PSIxNTAiIGZpbGw9IiNFNUU3RUIiLz48Y2lyY2xlIGN4PSI3NSIgY3k9IjUwIiByPSIyMCIgZmlsbD0iIzlDQTNBRiIvPjxwYXRoIGQ9Ik0zMCAxMDBDMzAgODUgNDUgNzUgNzUgNzVDMTA1IDc1IDEyMCA4NSAxMjAgMTAwVjEyMEgzMFYxMDBaIiBmaWxsPSIjOUNBM0FGIi8+PC9zdmc+'">
                        <!-- Edit Avatar Button -->
                        <button onclick="openEditModal()" 
                                class="btn btn-primary btn-sm rounded-circle position-absolute"
                                style="bottom: 5px; right: 5px; width: 35px; height: 35px;"
                                aria-label="Profil fotoğrafını düzenle">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    </div>

                    <!-- Kullanıcı Bilgileri -->
                    <div class="flex-grow-1">
                        <h1 class="h2 mb-1 fw-bold text-dark">{{ $user->name }}</h1>
                        @if($user->profession)
                            <h4 class="h5 text-secondary mb-2">{{ $user->profession->name }}</h4>
                        @endif
                        
                        <!-- Konum Bilgisi -->
                        @if($user->current_city)
                            <p class="text-muted mb-3">
                                <i class="bi bi-geo-alt-fill me-1"></i>
                                {{ $user->current_city }}{{ $user->current_district ? ', ' . $user->current_district : '' }}
                            </p>
                        @endif

                        <!-- Aksiyon Butonları -->
                        <div class="d-flex flex-wrap gap-2">
                            <button onclick="openEditModal()" 
                                    class="btn btn-primary"
                                    aria-label="Profili düzenle">
                                <i class="bi bi-pencil-square me-2"></i>Profili Düzenle
                            </button>
                            <button onclick="openPasswordModal()" 
                                class="btn btn-outline-secondary"
                                aria-label="Şifre değiştir">
                                <i class="bi bi-key me-2"></i>Şifre Değiştir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sol Kolon -->
            <div class="col-lg-6">
                <!-- Kişisel Bilgiler Card -->
                <div class="card shadow-sm rounded mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-person-circle me-2 text-primary"></i>Kişisel Bilgiler
                        </h5>
                        
                        <div class="mb-3">
                            <label class="text-muted small mb-1">E-posta</label>
                            <p class="mb-0 fw-medium">{{ $user->email }}</p>
                        </div>

                        @if($user->phone)
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Telefon</label>
                                @if($user->show_phone)
                                    <p class="mb-0 fw-medium">
                                        <a href="tel:{{ $user->phone }}" class="text-decoration-none">{{ $user->display_phone }}</a>
                                    </p>
                                @else
                                    <p class="mb-0 text-muted fst-italic">Gizli</p>
                                @endif
                            </div>
                        @endif

                        @if($user->birth_year)
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Doğum Yılı</label>
                                <p class="mb-0 fw-medium">{{ $user->birth_year }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="text-muted small mb-1">Profil Fotoğrafı</label>
                            <p class="mb-0">
                                @switch($user->profile_photo_visibility)
                                    @case('everyone')
                                        <span class="badge bg-success">
                                            <i class="bi bi-globe me-1"></i>Herkese Açık
                                        </span>
                                        @break
                                    @case('members_only')
                                        <span class="badge bg-primary">
                                            <i class="bi bi-people me-1"></i>Sadece Üyeler
                                        </span>
                                        @break
                                    @case('private')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-lock me-1"></i>Sadece Ben
                                        </span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Hakkımda Card -->
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-info-circle me-2 text-info"></i>Hakkımda
                            </h5>
                            @if(!$user->bio)
                                <button onclick="openEditModal()" class="btn btn-link btn-sm text-decoration-none">
                                    <i class="bi bi-plus-circle me-1"></i>Şimdi Ekle
                                </button>
                            @endif
                        </div>
                        
                        @if($user->bio)
                            <p class="text-secondary">{{ $user->bio }}</p>
                        @else
                            <p class="text-muted mb-0">Henüz hakkında bilgisi eklenmemiş.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sağ Kolon -->
            <div class="col-lg-6">
                <!-- Hesap Yönetimi Card -->
                <div class="card border-danger shadow-sm rounded">
                    <div class="card-body">
                        <h5 class="card-title text-danger mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>Hesap Yönetimi
                        </h5>
                        
                        <div class="alert alert-danger mb-3" role="alert">
                            <h6 class="alert-heading mb-2">Hesabı Kalıcı Olarak Sil</h6>
                            <p class="mb-0 small">Bu işlem geri alınamaz. Tüm verileriniz kalıcı olarak silinecektir.</p>
                        </div>

                        <button onclick="openDeleteModal()" 
                                class="btn btn-danger"
                                aria-label="Hesabı kalıcı olarak sil">
                            <i class="bi bi-trash3 me-2"></i>Hesabı Sil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Profil Bilgilerini Güncelle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Hesabı Kalıcı Olarak Sil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">
                        <i class="bi bi-key me-2"></i>Şifre Değiştir
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Modal açma fonksiyonları
        function openEditModal() {
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        function openDeleteModal() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        function openPasswordModal() {
            const passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            passwordModal.show();
        }

        // Success notification otomatik kapatma
        @if (session('status') === 'profile-updated')
            setTimeout(() => {
                const alert = document.getElementById('success-notification');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        @endif
    </script>

    <!-- Custom Styles -->
    <style>
        /* Pastel tonları ve özel stiller */
        :root {
            --bs-primary: #4a5568;
            --bs-primary-rgb: 74, 85, 104;
        }

        body {
            background-color: #f8f9fa;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn {
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
        }

        /* Responsive düzenlemeler */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
</x-app-layout>
 