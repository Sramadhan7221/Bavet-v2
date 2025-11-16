@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Dropzone Upload Section -->
                    <div class="upload-container">
                        <h4 class="mb-4">Upload Foto</h4>
                        <form action="{{ route('asset.upload') }}" class="dropzone" id="imageUpload">
                            @csrf
                        </form>
                        <form id="pageForm">
                            <input type="hidden" name="id" id="id" value="{{ $gallery?->id ?? "" }}">
                            <div class="row mt-1">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Judul</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input type="text" name="title" id="title" class="form-control" style="border-radius:5px;" value="{{ $gallery?->title ?? "" }}">
                                                <div class="invalid-feedback">
                                                    Judul kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Banner</label>
                                    <div class="col-sm-9">
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-sm-4">
                                                <input type="file" name="banner" id="banner">
                                                <div class="invalid-feedback">
                                                    Gambar kosong
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <img src="{{  $gallery?->banner ?? "#" }}" alt="" class="img-fluid" id="bannerPrev" style="max-height: 15rem;">
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Konten singkat</label>
                                    <div class="col-sm-9">
                                        <textarea name="content" id="content" class="form-control" style="border-radius:5px;" cols="3" rows="3">{{ $gallery?->content ?? "" }}</textarea>
                                        <div class="invalid-feedback">
                                            Konten kosong
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Simpan input" id="addRecord">
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
    <style>
        .border-error {
            border: 2px solid red!important;
        }
        .gallery-container {
            margin-bottom: 30px;
        }
        .gallery-item {
            position: relative;
            margin-bottom: 20px;
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .gallery-item .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            min-height: 150px;
            padding: 20px;
            text-align: center;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
    window.existingAssets = @json($assets);
    // Nonaktifkan auto discover agar Dropzone tidak auto-inisialisasi
    Dropzone.autoDiscover = false;

    // Create array for assets that can't be redefined
    const assets = [];
    const deletedAssets = [];

    // Initialize Dropzone
    const myDropzone = new Dropzone("#imageUpload", {
        url: "{{ route('asset.upload') }}",
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        paramName: "upload",
        dictDefaultMessage: "Drag and drop images here or click to upload",
        init: function() {
            // Load existing images from window.existingAssets
            if (window.existingAssets && window.existingAssets.length > 0) {
                window.existingAssets.forEach(url => {
                    // Create a mock file
                    const mockFile = {
                        name: url.split('/').pop(),
                        size: 12345,
                        accepted: true
                    };

                    // Manually add the file to dropzone
                    this.displayExistingFile(mockFile, url);

                    // Add to our assets array
                    assets.push({
                        url: url,
                        file: mockFile
                    });
                });

                console.log('Loaded existing assets:', assets);
            }
            this.on("success", function(file, response) {
                // Push the new asset to the array
                assets.push({
                    url: response.url,
                    file: file
                });
                console.log("File uploaded successfully. Current assets:", assets);
            });

            this.on("removedfile", function(file) {
                // Find the asset with matching file
                const assetIndex = assets.findIndex(a => a.file === file);
                if (assetIndex !== -1) {
                    const asset = assets[assetIndex];
                    deletedAssets.push(asset);
                    assets.splice(assetIndex, 1);
                }
            });
        }
    });

    $(document).ready(function () {
        $("#content").summernote({
            minHeight: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear','fontname','fontsize','color','ul', 'ol', 'paragraph']]
            ]
        });

        $("#addRecord").click(function() {

            let fileInput = $('#banner')[0];
            let formData = new FormData();
            let idPage = $("#id").val();

            if(fileInput.files.length > 0) {
                formData.append('banner', fileInput.files[0]);
            }

            if(idPage && idPage !== "") {
                formData.append('id', idPage);
            }

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('title', $("#title").val());
            formData.append('content', $("#content").summernote('code'));
            formData.append('assets', JSON.stringify(assets.map(a => a.url)));
            formData.append('delete_assets', JSON.stringify(deletedAssets.map(a => a.url)));
            $.ajax({
                url: "{{ route('admin.gallery.detail') }}", 
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('input').removeClass('is-invalid');
                    $("#addRecord").attr("disabled","disabled");
                    $("#addRecord").html(`<span class="spinner-border spinner-border-sm me-1" role="status"
                    aria-hidden="true"></span>
                    Loading...`);
                },
                success: function(response) {
                    $("#submitFormModal")
                        .removeAttr("data-kt-indicator")
                        .attr("disabled", false);

                    $("#bannerPrev").attr('src', response.banner);
                    Swal.fire({
                        title: response.msg_type,
                        text: response.message,
                        icon: response.msg_type
                    });

                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#submitFormModal")
                        .removeAttr("data-kt-indicator")
                        .attr("disabled", false);
                },
                complete: function() {
                    $("#addRecord").removeAttr("disabled");
                    $("#addRecord").html(`<i class="ri-add-circle-line"></i> Simpan`);
                },
                statusCode: {
                    400: function(xhr) {
                        let res = xhr.responseJSON ?? {};
                        if(res.message) {
                            if(res.message.title) {
                                const errors = res.message.title;
                                $("#title").siblings('.invalid-feedback').text(errors.join(","));
                                $("#title").addClass('is-invalid');
                            }
                            if(res.message.banner) {
                                const errors = res.message.banner;
                                $("#banner").siblings('.invalid-feedback').text(errors.join(","));
                                $("#banner").addClass('is-invalid');
                            }
                            if(res.message.content) {
                                const errors = res.message.content;
                                $("#content").siblings('.invalid-feedback').text(errors.join(","));
                                $("#content").addClass('is-invalid');
                            }
                        }
                    },
                    404: function(xhr) {
                        let res = xhr.responseJSON ?? {};
                        Swal.fire({
                            title: "Warning",
                            text: res.message || 'Validation error',
                            icon: res.msg_type || 'warning'
                        });
                    },
                    500: function(xhr) {
                        let res = xhr.responseJSON ?? {};
                        Swal.fire({
                            title: "Error",
                            text: res.message || 'Something went wrong',
                            icon: res.msg_type || 'error'
                        });
                    }
                },
            });
        })

    });
</script>
@endpush