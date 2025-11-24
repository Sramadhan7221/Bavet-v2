@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="upload-container">
                        <form id="pageForm">
                            <input type="hidden" name="id" id="id" value="{{ $berita?->id ?? '' }}">
                            
                            <div class="row mt-1">
                                <!-- Title Field -->
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3" for="title">Judul</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" id="title" class="form-control" 
                                               style="border-radius:5px;" value="{{ $berita?->title ?? '' }}">
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
                                                <img src="{{ $berita?->banner ?? '' }}" alt="Banner Preview" 
                                                     class="img-fluid" id="bannerPrev" style="max-height: 15rem;"
                                                     @if(!$berita?->banner) hidden @endif>
                                            </div>
                                        </div>
                                    </div>   
                                </div>

                                <!-- Content Field -->
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3" for="content">Konten</label>
                                    <div class="col-sm-9">
                                        <textarea name="content" id="content" class="form-control" 
                                                  style="border-radius:5px;" cols="3" rows="3">{{ $berita?->content ?? '' }}</textarea>
                                        <div class="invalid-feedback">Konten kosong</div>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-sm-3" for="title">Penanda</label>
                                    <div class="col-sm-9">
                                        <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                            <option value=""></option>
                                            @if ($berita)    
                                                @foreach($berita->tags as $tag)
                                                    <option value="{{ $tag->tag_name }}" selected>{{ $tag->tag_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">Judul kosong</div>
                                    </div>
                                </div>

                                <!-- Hidden fields for assets (fixed duplicate ID bug) -->
                                <input type="hidden" name="assets" id="pageAssets" value="">
                                <input type="hidden" name="deleted_assets" id="deletedAssets" value="">
                            </div>
                        </form>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-info rounded-pill"" 
                                    data-toggle="tooltip" data-placement="top" title="Tambah Baru" id="resetForm">
                                <i class="ri-add-circle-line"></i> Baru 
                            </button>
                            <button type="button" class="btn btn-outline-primary rounded-pill" 
                                    data-toggle="tooltip" data-placement="top" title="Simpan input" id="addRecord">
                                <i class="ri-save-3-fill"></i> Simpan 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .border-error {
        border: 2px solid red !important;
    }
    .note-editable {
        min-height: 200px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
(function() {
    'use strict';
    
    // Track uploaded and deleted assets properly
    const uploadedAssets = [];
    const deletedAssets = [];
    const csrfToken = "{{ csrf_token() }}";
    
    // Routes
    const routes = {
        assetUpload: "{{ route('asset.upload') }}",
        saveBerita: "{{ route('admin.berita.detail') }}"
    };

    $(document).ready(function() {
        initSummernote();
        initBannerPreview();
        initFormSubmission();
        initTooltips();
        initResetForm();

        $("#tags").select2({
            placeholder: "Pilih Penanda atau Kategori Berita",
            tags: true,
            language: {
                inputTooShort: function () {
                    return "Harap masukkan minimal 3 karakter";
                }
            },
            ajax: {
                url: "{{ route('admin.berita.tags') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.data.map(function (item) {
                            return {
                                id: item.tag_name,
                                text: item.tag_name
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3,
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newOption: true
                };
            },
            templateResult: function (repo) {
                if (repo.loading) {
                    return repo.text;
                }
                var $container = $("<div></div>");
                if (repo.newOption) {
                    $container.text(repo.text + " (Tambah Baru)");
                } else {
                    $container.text(repo.text);
                }
                return $container;
            },
            templateSelection: function (repo) {
                return repo.text;
            }
        });
    });

    function initResetForm() {
        $('#resetForm').on('click', function() {
            // Clear all form fields
            $('#pageForm')[0].reset();
            $('#content').summernote('code', '');
            $('#bannerPrev').attr('hidden', true).attr('src', '');
            $('#tags').val(null).trigger('change');

            // Clear validation errors
            clearValidationErrors();

            // Clear asset tracking
            uploadedAssets.length = 0;
            deletedAssets.length = 0;
            updateAssetInputs();
        });
    }

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

    function initSummernote() {
        $('#content').summernote({
            minHeight: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['font', ['fontname', 'fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['picture']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    const editor = $(this);
                    for (let i = 0; i < files.length; i++) {
                        uploadImage(files[i], editor);
                    }
                },
                onMediaDelete: function(target) {
                    const src = $(target).attr('src');
                    if (src) {
                        // Remove from uploaded assets if exists
                        const uploadedIdx = uploadedAssets.indexOf(src);
                        if (uploadedIdx > -1) {
                            uploadedAssets.splice(uploadedIdx, 1);
                        }
                        // Add to deleted assets
                        deletedAssets.push(src);
                        updateAssetInputs();
                    }
                },
                onChange: function(contents, $editable) {
                    normalizeImageSizes($editable, {
                        usePercentage: true,
                        roundTo: 0  // Integer percentages: 25%, 50%, 75%
                    });
                }
            }
        });
    }

    function uploadImage(file, editor) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showAlert('Error', 'File harus berupa gambar', 'error');
            return;
        }

        // Validate file size (max 5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            showAlert('Error', 'Ukuran file maksimal 5MB', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('upload', file);
        formData.append('_token', csrfToken);

        $.ajax({
            url: routes.assetUpload,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.url) {
                    const $img = $('<img>')
                        .attr('src', response.url)
                        .css('max-width', '-moz-available')
                        .css('width', '100%')
                        .css('height', 'auto');
                    
                    editor.summernote('insertNode', $img[0]);
                    uploadedAssets.push(response.url);
                    updateAssetInputs();
                } else {
                    showAlert('Error', 'Upload gagal!', 'error');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON || {};
                showAlert('Error', response.message || 'Upload gagal!', 'error');
            }
        });
    }

    function normalizeImageSizes($editable, options = {}) {
        const defaults = {
            usePercentage: true,        // Convert to percentage (true) or keep pixels (false)
            maxWidth: null,             // Maximum width in pixels (null = no limit)
            maxHeight: null,            // Maximum height in pixels (null = no limit)
            roundTo: 0,                 // Decimal places (0 = integer, 2 = two decimals)
            moveToStyle: false,         // Move width/height to style attribute instead
            allowedUnits: ['%', 'px']   // Units allowed by Purifier
        };
        
        const config = { ...defaults, ...options };
        const $images = $editable.find('img');
        
        // Early return if no images
        if ($images.length === 0) return;
        
        $images.each(function() {
            const $img = $(this);
            const parentWidth = $img.parent().width();
            const imageWidth = $img.width();
            const imageHeight = $img.height();
            
            if (!parentWidth || !imageWidth) return;
            
            // Calculate dimensions based on configuration
            let finalWidth, finalHeight;
            
            if (config.usePercentage) {
                // Convert to percentage
                let widthPercent = (imageWidth / parentWidth) * 100;
                
                // Round based on configuration
                if (config.roundTo === 0) {
                    widthPercent = Math.round(widthPercent);
                } else {
                    widthPercent = Math.round(widthPercent * Math.pow(10, config.roundTo)) / Math.pow(10, config.roundTo);
                }
                
                // Ensure percentage is within bounds (1-100%)
                widthPercent = Math.max(1, Math.min(100, widthPercent));
                
                finalWidth = widthPercent + '%';
                
                // Calculate proportional height if needed
                if (imageHeight && config.maxHeight) {
                    const aspectRatio = imageHeight / imageWidth;
                    let heightPercent = widthPercent * aspectRatio;
                    heightPercent = Math.round(heightPercent * Math.pow(10, config.roundTo)) / Math.pow(10, config.roundTo);
                    finalHeight = heightPercent + '%';
                }
            } else {
                // Keep as pixels (Purifier-safe)
                finalWidth = Math.round(imageWidth);
                finalHeight = Math.round(imageHeight);
                
                // Apply max constraints
                if (config.maxWidth && finalWidth > config.maxWidth) {
                    const ratio = config.maxWidth / finalWidth;
                    finalWidth = config.maxWidth;
                    if (finalHeight) finalHeight = Math.round(finalHeight * ratio);
                }
                
                if (config.maxHeight && finalHeight > config.maxHeight) {
                    const ratio = config.maxHeight / finalHeight;
                    finalHeight = config.maxHeight;
                    finalWidth = Math.round(finalWidth * ratio);
                }
                
                finalWidth = finalWidth + 'px';
                if (finalHeight) finalHeight = finalHeight + 'px';
            }
            
            // Apply width/height based on configuration
            if (config.moveToStyle) {
                // Move to inline style (Purifier must allow style attribute)
                $img.removeAttr('width').removeAttr('height');
                
                let styleValue = `width: ${finalWidth};`;
                if (finalHeight) styleValue += ` height: ${finalHeight};`;
                
                const existingStyle = $img.attr('style') || '';
                // Remove existing width/height from style
                const cleanedStyle = existingStyle.replace(/width\s*:\s*[^;]+;?/gi, '')
                                                .replace(/height\s*:\s*[^;]+;?/gi, '')
                                                .trim();
                
                const newStyle = cleanedStyle ? `${cleanedStyle}; ${styleValue}` : styleValue;
                $img.attr('style', newStyle);
            } else {
                // Set as HTML attributes (default)
                $img.css('width', '').css('height', ''); // Clear inline styles
                $img.attr('width', finalWidth.replace('px', '')); // Remove 'px' for HTML attributes
                if (finalHeight) {
                    $img.attr('height', finalHeight.replace('px', ''));
                }
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
            const idPage = $('#id').val();

            // Append file if selected
            if (fileInput.files.length > 0) {
                formData.append('banner', fileInput.files[0]);
            }

            // Append ID if editing
            if (idPage) {
                formData.append('id', idPage);
            }

            formData.append('_token', csrfToken);
            formData.append('title', $('#title').val().trim());
            formData.append('content', $('#content').summernote('code'));
            formData.append('assets', JSON.stringify(uploadedAssets));
            formData.append('delete_assets', JSON.stringify(deletedAssets));
            formData.append('tags', JSON.stringify($("#tags").val()));

            $.ajax({
                url: routes.saveBerita,
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
            // Validation errors
            const errors = response.message;
            
            if (errors.title) {
                showFieldError('#title', errors.title);
            }
            if (errors.banner) {
                showFieldError('#banner', errors.banner);
            }
            if (errors.content) {
                // For Summernote, add error to the editor container
                const $contentError = $('#content').siblings('.invalid-feedback');
                $contentError.text(Array.isArray(errors.content) ? errors.content.join(', ') : errors.content);
                $('.note-editor').addClass('border-error');
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