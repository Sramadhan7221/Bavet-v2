@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="upload-container">
                        <!-- Dropzone Upload Section -->
                        <h4 class="mb-4">Upload Foto Galeri</h4>
                        <form action="{{ route('asset.upload') }}" class="dropzone" id="imageUpload">
                            @csrf
                        </form>

                        <form id="pageForm">
                            <input type="hidden" name="id" id="id" value="{{ $gallery?->id ?? '' }}">
                            
                            <div class="row mt-1">
                                <!-- Title Field -->
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3" for="title">Judul</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" id="title" class="form-control" 
                                               style="border-radius:5px;" value="{{ $gallery?->title ?? '' }}">
                                        <div class="invalid-feedback">Judul kosong</div>
                                    </div>
                                </div>

                                <!-- Banner Field -->
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3" for="banner">Banner</label>
                                    <div class="col-sm-9">
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-sm-4">
                                                <input type="file" name="banner" id="banner" accept="image/*">
                                                <p class="fs-6 text-muted">
                                                    <i>Pilih Gambar dengan posisi lanscape untuk hasil yang lebih baik</i>
                                                </p>
                                                <div class="invalid-feedback">Gambar kosong</div>
                                            </div>
                                            <div class="col-sm-6">
                                                <img src="{{ $gallery?->banner ?? '' }}" alt="Banner Preview" 
                                                     class="img-fluid" id="bannerPrev" style="max-height: 15rem;"
                                                     @if(!$gallery?->banner) hidden @endif>
                                            </div>
                                        </div>
                                    </div>   
                                </div>

                                <!-- Content Field -->
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3" for="content">Konten Singkat</label>
                                    <div class="col-sm-9">
                                        <textarea name="content" id="content" class="form-control" 
                                                  style="border-radius:5px;" cols="3" rows="3">{{ $gallery?->content ?? '' }}</textarea>
                                        <div class="invalid-feedback">Konten kosong</div>
                                    </div>
                                </div>

                                <!-- Hidden fields for assets -->
                                <input type="hidden" name="assets" id="pageAssets" value="">
                                <input type="hidden" name="deleted_assets" id="deletedAssets" value="">
                            </div>
                        </form>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-info rounded-pill" 
                                    data-toggle="tooltip" data-placement="top" title="Tambah Baru" id="resetForm">
                                <i class="ri-add-circle-line"></i> Baru 
                            </button>
                            <button type="button" class="btn btn-outline-primary rounded-pill" 
                                    data-toggle="tooltip" data-placement="top" title="Simpan input" id="addRecord">
                                <i class="ri-add-circle-line"></i> Simpan 
                            </button>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
<style>
    .border-error {
        border: 2px solid red !important;
    }
    .gallery-item {
        position: relative;
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
    }
    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .gallery-item .delete-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }
    .gallery-item .delete-btn:hover {
        background: rgba(255, 0, 0, 1);
        transform: scale(1.1);
    }
    .dropzone {
        border: 2px dashed #0087F7 !important;
        border-radius: 8px !important;
        background: #f9f9f9 !important;
        min-height: 150px !important;
        padding: 20px !important;
        text-align: center !important;
        margin-bottom: 30px;
    }
    .dropzone.dz-drag-hover {
        background-color: #e3f2fd !important;
        border-color: #1976d2 !important;
    }
    .dz-message {
        margin: 2rem 0 !important;
        color: #0087F7 !important;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
(function() {
    'use strict';

    // Track uploaded and deleted assets
    const uploadedAssets = [];
    const deletedAssets = [];
    const csrfToken = "{{ csrf_token() }}";
    
    // Routes
    const routes = {
        assetUpload: "{{ route('asset.upload') }}",
        saveGallery: "{{ route('admin.gallery.detail') }}"
    };

    // Module-level variable for Dropzone instance
    let myDropzone;

    window.existingAssets = @json($assets ?? []);

    // Disable auto-discovery
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        initBannerPreview();
        initDropzone();
        initFormSubmission();
        initResetForm();
        initTooltips();
    });

    function initTooltips() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    function initBannerPreview() {
        $('#banner').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    showAlert('Error', 'File harus berupa gambar', 'error');
                    $(this).val('');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#bannerPrev').attr('src', event.target.result).removeAttr('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function initDropzone() {
        myDropzone = new Dropzone("#imageUpload", {
            url: routes.assetUpload,
            addRemoveLinks: true,
            acceptedFiles: "image/*",
            paramName: "upload",
            dictDefaultMessage: "Seret gambar ke sini atau klik untuk upload",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            init: function() {
                // Load existing images
                if (window.existingAssets && window.existingAssets.length > 0) {
                    window.existingAssets.forEach(url => {
                        const mockFile = {
                            name: url.split('/').pop(),
                            size: 12345,
                            accepted: true
                        };
                        this.displayExistingFile(mockFile, url);
                        uploadedAssets.push(url);
                    });
                }

                // Handle new uploads
                this.on("success", function(file, response) {
                    if (response.url) {
                        uploadedAssets.push(response.url);
                        updateAssetInputs();
                    }
                });

                // Handle file removal
                this.on("removedfile", function(file) {
                    const src = file.xhr ? file.xhr.response.url : null;
                    if (src) {
                        const idx = uploadedAssets.indexOf(src);
                        if (idx > -1) {
                            uploadedAssets.splice(idx, 1);
                            deletedAssets.push(src);
                            updateAssetInputs();
                        }
                    } else {
                        // For existing files, find by name
                        const fileName = file.name;
                        const assetToRemove = window.existingAssets.find(url => url.includes(fileName));
                        if (assetToRemove) {
                            const idx = uploadedAssets.indexOf(assetToRemove);
                            if (idx > -1) {
                                uploadedAssets.splice(idx, 1);
                            }
                            deletedAssets.push(assetToRemove);
                            updateAssetInputs();
                        }
                    }
                });
            }
        });
    }

    function updateAssetInputs() {
        $('#pageAssets').val(JSON.stringify(uploadedAssets));
        $('#deletedAssets').val(JSON.stringify(deletedAssets));
    }

    function initFormSubmission() {
        $('#addRecord').on('click', function() {
            const $btn = $(this);
            const fileInput = $('#banner')[0];
            const formData = new FormData();
            const idGallery = $('#id').val();

            // Append file if selected
            if (fileInput.files.length > 0) {
                formData.append('banner', fileInput.files[0]);
            }

            // Append ID if editing
            if (idGallery) {
                formData.append('id', idGallery);
            }

            formData.append('_token', csrfToken);
            formData.append('title', $('#title').val().trim());
            formData.append('content', $('#content').val().trim());
            formData.append('assets', JSON.stringify(uploadedAssets));
            formData.append('delete_assets', JSON.stringify(deletedAssets));

            $.ajax({
                url: routes.saveGallery,
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    clearValidationErrors();
                    setButtonLoading($btn, true);
                },
                success: function(response) {
                    if (response.banner) {
                        $('#bannerPrev').attr('src', response.banner).removeAttr('hidden');
                    }
                    
                    // Update ID if new record was created
                    if (response.id) {
                        $('#id').val(response.id);
                    }
                    
                    // Clear asset tracking after successful save
                    uploadedAssets.length = 0;
                    deletedAssets.length = 0;
                    updateAssetInputs();
                    
                    showAlert(
                        response.msg_type === 'success' ? 'Berhasil' : 'Info',
                        response.message,
                        response.msg_type || 'success'
                    );
                },
                error: function(xhr) {
                    handleFormError(xhr);
                },
                complete: function() {
                    setButtonLoading($btn, false);
                }
            });
        });
    }

    function initResetForm() {
        $('#resetForm').on('click', function() {
            $('#pageForm')[0].reset();
            $('#id').val('');
            $('#bannerPrev').attr('hidden', '');
            uploadedAssets.length = 0;
            deletedAssets.length = 0;
            updateAssetInputs();
            clearValidationErrors();
            myDropzone.removeAllFiles(true);
            showAlert('Info', 'Form berhasil direset', 'info');
        });
    }

    function setButtonLoading($btn, isLoading) {
        if (isLoading) {
            $btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
            );
        } else {
            $btn.prop('disabled', false).html('<i class="ri-add-circle-line"></i> Simpan');
        }
    }

    function clearValidationErrors() {
        $('input, textarea').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }

    function handleFormError(xhr) {
        const status = xhr.status;
        const response = xhr.responseJSON || {};

        if (status === 400 && response.message) {
            const errors = response.message;
            
            if (errors.title) {
                showFieldError('#title', errors.title);
            }
            if (errors.banner) {
                showFieldError('#banner', errors.banner);
            }
            if (errors.content) {
                showFieldError('#content', errors.content);
            }
        } else if (status === 404) {
            showAlert('Warning', response.message || 'Data tidak ditemukan', 'warning');
        } else {
            showAlert('Error', response.message || 'Terjadi kesalahan', 'error');
        }
    }

    function showFieldError(selector, errors) {
        const $field = $(selector);
        const errorText = Array.isArray(errors) ? errors.join(', ') : errors;
        $field.addClass('is-invalid').siblings('.invalid-feedback').text(errorText);
    }

    function showAlert(title, text, icon) {
        Swal.fire({ title, text, icon });
    }
})();
</script>
@endpush