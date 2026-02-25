@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Kelola Kontak Lokasi</h4>
                <p class="text-muted">Kelola informasi kontak untuk 6 lokasi yang tersedia</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Form Wizard - Kontak Lokasi</h4>

                    <form id="location-wizard-form" action="{{ route('location.update') }}" method="POST">
                        @csrf
                        
                        <div id="basicwizard">
                            <!-- Navigation Tabs -->
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                                <li class="nav-item" data-target-form="#location1">
                                    <a href="#location1" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 active">
                                        <i class="mdi mdi-office-building-marker me-1"></i>
                                        <span class="d-none d-sm-inline">Kantor Administrasi</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#location2">
                                    <a href="#location2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-flask me-1"></i>
                                        <span class="d-none d-sm-inline">Lab Cikole</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#location3">
                                    <a href="#location3" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-flask me-1"></i>
                                        <span class="d-none d-sm-inline">Lab Losari</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#location4">
                                    <a href="#location4" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-hospital-building me-1"></i>
                                        <span class="d-none d-sm-inline">Satpel Losari</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#location5">
                                    <a href="#location5" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-hospital-building me-1"></i>
                                        <span class="d-none d-sm-inline">Satpel Banjar</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-target-form="#location6">
                                    <a href="#location6" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-hospital-building me-1"></i>
                                        <span class="d-none d-sm-inline">Satpel G. Sindur</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content b-0 mb-0">
                                @foreach([
                                    1 => 'Kantor Administrasi',
                                    2 => 'Laboratorium Cikole',
                                    3 => 'Laboratorium Losari',
                                    4 => 'Satpel Losari',
                                    5 => 'Satpel Banjar',
                                    6 => 'Satpel Gunung Sindur'
                                ] as $id => $name)
                                <div class="tab-pane {{ $id == 1 ? 'active' : '' }}" id="location{{ $id }}">
                                    <input type="hidden" name="locations[{{ $id }}][id]" value="{{ $id }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="mb-3">{{ $name }}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="location{{ $id }}-alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                                <textarea class="form-control location-field" id="location{{ $id }}-alamat" name="locations[{{ $id }}][alamat]" rows="3" placeholder="Masukkan alamat lengkap (gunakan Enter untuk baris baru)" required>{{ isset($locations[$id]) ? $locations[$id]->detail['alamat'] : '' }}</textarea>
                                                <div class="invalid-feedback">Alamat tidak boleh kosong</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="location{{ $id }}-telpon" class="form-label">Telpon <span class="text-danger">*</span></label>
                                                <textarea class="form-control location-field" id="location{{ $id }}-telpon" name="locations[{{ $id }}][telpon]" rows="3" placeholder="Masukkan nomor telpon (gunakan Enter untuk baris baru)" required>{{ isset($locations[$id]) ? $locations[$id]->detail['telpon'] : '' }}</textarea>
                                                <div class="invalid-feedback">Telpon tidak boleh kosong</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="location{{ $id }}-email" class="form-label">Email <span class="text-danger">*</span></label>
                                                <textarea class="form-control location-field" id="location{{ $id }}-email" name="locations[{{ $id }}][email]" rows="3" placeholder="Masukkan email (gunakan Enter untuk baris baru)" required>{{ isset($locations[$id]) ? $locations[$id]->detail['email'] : '' }}</textarea>
                                                <div class="invalid-feedback">Email tidak boleh kosong</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="location{{ $id }}-jam" class="form-label">Jam Pelayanan <span class="text-danger">*</span></label>
                                                <textarea class="form-control location-field" id="location{{ $id }}-jam" name="locations[{{ $id }}][jam_pelayanan]" rows="3" placeholder="Contoh: Senin - Jumat&#10;08:00 - 16:00" required>{{ isset($locations[$id]) ? $locations[$id]->detail['jam_pelayanan'] : '' }}</textarea>
                                                <div class="invalid-feedback">Jam pelayanan tidak boleh kosong</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="location{{ $id }}-map" class="form-label">Google Maps Embed <span class="text-danger">*</span></label>
                                                <textarea class="form-control location-map-field" id="location{{ $id }}-map" name="locations[{{ $id }}][location]" rows="4" placeholder='Masukkan iframe embed dari Google Maps atau "/" jika tidak tersedia' required>{{ isset($locations[$id]) ? $locations[$id]->location : '/' }}</textarea>
                                                <small class="form-text text-muted">
                                                    <i class="mdi mdi-information"></i> Paste kode iframe lengkap dari Google Maps, atau ketik "/" jika lokasi tidak tersedia
                                                </small>
                                                <div class="invalid-feedback">Google Maps embed tidak boleh kosong (gunakan "/" jika tidak tersedia)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Navigation Buttons -->
                            <ul class="list-inline wizard mb-0">
                                <li class="previous list-inline-item">
                                    <button type="button" class="btn btn-secondary" id="prev-btn">
                                        <i class="mdi mdi-arrow-left"></i> Previous
                                    </button>
                                </li>
                                <li class="next list-inline-item float-end">
                                    <button type="button" class="btn btn-primary" id="next-btn">
                                        Next <i class="mdi mdi-arrow-right"></i>
                                    </button>
                                </li>
                                <li class="finish list-inline-item float-end" style="display: none;">
                                    <button type="submit" class="btn btn-success" id="submit-btn">
                                        <i class="mdi mdi-content-save"></i> Simpan Semua Data
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.nav-pills .nav-link {
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: #f8f9fa;
}

.nav-pills .nav-link.active {
    background-color: #5cb85c;
    border-color: #5cb85c;
}

.form-wizard-header {
    margin-bottom: 2rem;
}

.is-invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(.375em + .1875rem) center;
    background-size: calc(.75em + .375rem) calc(.75em + .375rem);
}

.is-valid {
    border-color: #28a745 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(.375em + .1875rem) center;
    background-size: calc(.75em + .375rem) calc(.75em + .375rem);
}

/* FIXED: Hide invalid-feedback by default */
.invalid-feedback {
    display: none !important;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* FIXED: Only show when field is invalid */
.form-control.is-invalid ~ .invalid-feedback {
    display: block !important;
}

/* FIXED: Handle case where form-text is between field and invalid-feedback */
.form-control.is-invalid ~ .form-text ~ .invalid-feedback {
    display: block !important;
}

.wizard {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
}

textarea.form-control {
    resize: vertical;
    min-height: 60px;
}

.tab-content {
    min-height: 450px;
    padding: 20px 0;
}

.card-body {
    padding: 2rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

.page-title-box {
    padding: 1.5rem 0;
}

/* Button styling */
.btn {
    padding: 0.5rem 1.5rem;
}

.btn i {
    font-size: 1rem;
}

/* Tab responsive */
@media (max-width: 768px) {
    .nav-pills .nav-link span {
        display: inline !important;
        font-size: 0.8rem;
    }
    
    .nav-pills .nav-link {
        padding: 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<!-- SweetAlert2 for notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        let currentTab = 0;
        const totalTabs = 6;
        
        // Show initial tab
        showTab(currentTab);
        
        // Next button click
        $('#next-btn').click(function() {
            if (validateCurrentTab()) {
                currentTab++;
                showTab(currentTab);
            }
        });
        
        // Previous button click
        $('#prev-btn').click(function() {
            currentTab--;
            showTab(currentTab);
        });
        
        // Tab click navigation
        $('.nav-pills a').click(function(e) {
            const targetTab = $(this).attr('href');
            const tabIndex = parseInt(targetTab.replace('#location', '')) - 1;
            
            // Validate all previous tabs before allowing navigation forward
            if (tabIndex > currentTab) {
                let canNavigate = true;
                for (let i = currentTab; i < tabIndex; i++) {
                    if (!validateTab(i)) {
                        canNavigate = false;
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Silakan lengkapi form pada tab sebelumnya terlebih dahulu',
                            confirmButtonColor: '#3085d6'
                        });
                        return false;
                    }
                }
            }
            
            currentTab = tabIndex;
            showTab(currentTab);
        });
        
        function showTab(n) {
            // Update buttons
            if (n === 0) {
                $('#prev-btn').prop('disabled', true);
            } else {
                $('#prev-btn').prop('disabled', false);
            }
            
            if (n === totalTabs - 1) {
                $('#next-btn').hide();
                $('.finish').show();
            } else {
                $('#next-btn').show();
                $('.finish').hide();
            }
            
            // Activate correct tab
            $('.nav-pills a').removeClass('active');
            $('.nav-pills a').eq(n).addClass('active');
            $('.tab-pane').removeClass('active show');
            $('.tab-pane').eq(n).addClass('active show');
            
            // Scroll to top
            $('html, body').animate({ scrollTop: 0 }, 300);
        }
        
        function validateCurrentTab() {
            return validateTab(currentTab);
        }
        
        function validateTab(tabIndex) {
            const tabPane = $('.tab-pane').eq(tabIndex);
            let isValid = true;
            
            // Validate all required fields
            tabPane.find('.location-field, .location-map-field').each(function() {
                const field = $(this);
                const value = field.val().trim();
                
                if (value === '') {
                    field.addClass('is-invalid');
                    field.removeClass('is-valid');
                    isValid = false;
                } else {
                    field.removeClass('is-invalid');
                    field.addClass('is-valid');
                    
                    // Special validation for map field
                    if (field.hasClass('location-map-field')) {
                        if (value !== '/' && !value.includes('<iframe')) {
                            field.addClass('is-invalid');
                            field.removeClass('is-valid');
                            // Update feedback message for map field
                            field.siblings('.invalid-feedback').text('Format tidak valid. Gunakan iframe embed atau "/"');
                            isValid = false;
                        }
                    }
                }
            });
            
            if (!isValid) {
                // Scroll to first invalid field
                const firstInvalid = tabPane.find('.is-invalid').first();
                if (firstInvalid.length) {
                    $('html, body').animate({
                        scrollTop: firstInvalid.offset().top - 100
                    }, 300);
                }
            }
            
            return isValid;
        }
        
        // Real-time validation on blur
        $('.location-field, .location-map-field').on('blur', function() {
            const field = $(this);
            const value = field.val().trim();
            
            if (value === '') {
                field.addClass('is-invalid');
                field.removeClass('is-valid');
            } else {
                field.removeClass('is-invalid');
                field.addClass('is-valid');
                
                // Special validation for map field
                if (field.hasClass('location-map-field')) {
                    if (value !== '/' && !value.includes('<iframe')) {
                        field.addClass('is-invalid');
                        field.removeClass('is-valid');
                    }
                }
            }
        });
        
        // Remove validation styling on input
        $('.location-field, .location-map-field').on('input', function() {
            $(this).removeClass('is-invalid is-valid');
        });
        
        // Form submission
        $('#location-wizard-form').submit(function(e) {
            e.preventDefault();
            
            // Validate all tabs
            let allValid = true;
            let firstInvalidTab = -1;
            
            for (let i = 0; i < totalTabs; i++) {
                if (!validateTab(i)) {
                    allValid = false;
                    if (firstInvalidTab === -1) {
                        firstInvalidTab = i;
                    }
                }
            }
            
            if (!allValid) {
                currentTab = firstInvalidTab;
                showTab(currentTab);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Silakan lengkapi semua form dengan benar',
                    confirmButtonColor: '#d33'
                });
                return false;
            }
            
            // Show loading
            $('#submit-btn').html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...').prop('disabled', true);
            
            // Submit form via AJAX
            const formData = $(this).serialize();
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data lokasi berhasil disimpan',
                        confirmButtonColor: '#5cb85c',
                        timer: 2000
                    }).then(function() {
                        // Reload page
                        location.reload();
                    });
                },
                error: function(xhr) {
                    // Show error message
                    let errorMsg = 'Terjadi kesalahan saat menyimpan data';
                    
                    if (xhr.status === 422) {
                        // Validation error
                        const errors = xhr.responseJSON.errors;
                        let errorList = '<ul class="text-start">';
                        $.each(errors, function(key, value) {
                            errorList += '<li>' + value[0] + '</li>';
                        });
                        errorList += '</ul>';
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: errorList,
                            confirmButtonColor: '#d33'
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMsg,
                            confirmButtonColor: '#d33'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMsg,
                            confirmButtonColor: '#d33'
                        });
                    }
                    
                    // Reset button
                    $('#submit-btn').html('<i class="mdi mdi-content-save"></i> Simpan Semua Data').prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush