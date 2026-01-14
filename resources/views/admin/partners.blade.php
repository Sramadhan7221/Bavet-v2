@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-4">
                    <form id="formBank">
                        <input type="hidden" id="id">
                        <div class="row">
                            <div class="col-3">
                                <div class="profile-container">
                                    <img src="{{ asset('assets/img/icon-img.png') }}" alt="Logo" class="img-fluid" id="iconPict">
                                    <div class="overlay-me">
                                        <div class="camera-icon">
                                            <i class="ri-camera-line"></i>
                                            <span class="tooltip-me">Upload Logo</span>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" id="logo" name="logo" accept="image/*" style="display:none;">
                                <p class="fs-6 text-muted">
                                    <i>Gunakan format foto dengan ukuran square untuk hasil yang baik</i>
                                </p>
                                <div class="invalid-feedback">Konten kosong</div>
                            </div>
                            <div class="col-9 pl-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3">Nama Mitra</label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-11">
                                                        <input type="text" name="nama" id="nama" class="form-control" style="border-radius:5px;" placeholder="Judul Layanan">
                                                        <div class="invalid-feedback">Konten kosong</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3">Url website</label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-11">
                                                        <input type="text" name="url" id="url" class="form-control" style="border-radius:5px;" placeholder="Deskripsi Singkat Layanan">
                                                        <div class="invalid-feedback">Konten kosong</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-toggle="tooltip" data-placement="top" title="Reset input" id="reset">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </button>
                        <button type="button" class="btn btn-outline-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Simpan input" id="addRecord">
                            <i class="ri-add-circle-line"></i> Simpan
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Logo</th>
                                <th>Nama Mitra</th>
                                <th>Tombol Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('admin/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .border-error {
            border: 2px solid red !important;
        }

        .profile-container {
            position: relative;
        }

        .profile-pic {
            z-index: 1;
            position: relative;
        }

        .overlay-me {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            cursor: pointer;
        }

        .profile-container:hover .overlay-me {
            pointer-events: auto;
            opacity: 1;
        }

        .camera-icon {
            color: white;
            font-size: 24px;
            position: relative;
        }

        .tooltip-me {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            background-color: black;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .profile-container:hover .tooltip-me {
            opacity: 1;
        }

        .my-column {
            vertical-align: middle;
        }

        .banner-preview {
            border: 2px dashed #ced4da;
            border-radius: 5px;
            height: 150px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .banner-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            padding: 5px
        }

        .no-banner {
            color: #6c757d;
            text-align: center;
        }

        .no-banner img {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('admin/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = $("#fixed-header-datatable").DataTable({
                scrollX: true,
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='ri-arrow-left-s-line'>",
                        next: "<i class='ri-arrow-right-s-line'>"
                    }
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.mitra') }}",
                columns: [
                    {
                        className: "my-column",
                        data: "DT_RowIndex",
                        orderable: false,
                        searchable: false
                    },
                    {
                        className: "my-column",
                        data: "logo",
                        render: function(data, type, row) {
                            return `<img src="${data}" width="76" height="76">`;
                        }
                    },
                    {
                        className: "my-column",
                        data: "nama"
                    }
                ],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                }
            });

            // Icon upload overlay click handler
            $('.overlay-me').on('click', function(e) {
                e.stopImmediatePropagation();
                e.preventDefault();
                $('#icon').click();
            });

            // Icon preview handler
            $('#logo').on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#iconPict').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Add/Update record handler
            $("#addRecord").on('click', function() {
                const formData = new FormData();
                
                // Append files
                const iconFile = $('#logo')[0].files[0];
                
                if (iconFile) {
                    formData.append('icon', iconFile);
                }

                // Append form fields
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $("#id").val() || '');
                formData.append('nama', $("#nama").val());
                formData.append('url', $("#url").val());

                $.ajax({
                    url: "{{ route('admin.mitra') }}",
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        // Clear previous errors
                        $('input, textarea').removeClass('is-invalid');
                        $(".profile-container").removeClass('border-error');
                        
                        // Disable button
                        $("#addRecord").prop("disabled", true);
                        $("#addRecord").html(`
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Loading...
                        `);
                    },
                    success: function(response) {
                        table.draw();
                        resetForm();
                        
                        Swal.fire({
                            title: response.msg_type || 'Success',
                            text: response.message,
                            icon: response.msg_type || 'success'
                        });
                    },
                    complete: function() {
                        $("#addRecord").prop("disabled", false);
                        $("#addRecord").html(`<i class="ri-add-circle-line"></i> Simpan`);
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                    },
                    statusCode: {
                        404: function(xhr) {
                            let res = xhr.responseJSON ?? {};
                            Swal.fire({
                                title: "Warning",
                                text: res.message || 'Validation error',
                                icon: res.msg_type || 'warning'
                            });
                        },
                        400: function(xhr) {
                            let res = xhr.responseJSON ?? {};
                            if(res.message) {
                                if(res.message.nama) {
                                    const errors = res.message.nama;
                                    $("#nama").next('.invalid-feedback').text(errors.join(","));
                                    $("#nama").addClass('is-invalid');
                                }
                                if(res.message.url) {
                                    const errors = res.message.url;
                                    $("#url").next('.invalid-feedback').text(errors.join(","));
                                    $("#url").addClass('is-invalid');
                                }
                                if(res.message.logo) {
                                    const errors = res.message.logo;
                                    Swal.fire({
                                        title: "Perhatian",
                                        text: errors.join(", "),
                                        logo: res.msg_type || 'warning'
                                    });
                                }
                            }
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
            });

            // Delete record handler
            $(document).on('click', '.delete', function() {
                const id = $(this).data("id");
                
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Perubahan tidak dapat dikembalikan",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.mitra-delete') }}",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Berhasil",
                                    text: response.msg || 'Data berhasil dihapus',
                                    icon: "success"
                                });
                                table.draw();
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON || {};
                                Swal.fire({
                                    title: "Error",
                                    text: response.message || 'Terjadi kesalahan',
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

            // Edit record handler
            $(document).on('click', '.edit', function() {
                const id = $(this).data("id");
                
                $.get(`{{ url('cms-mitra-detail') }}/${id}`, function(obj) {
                    const data = obj.data;
                    
                    if (data) {
                        $("#id").val(id);
                        $("#nama").val(data.title || '');
                        $("#url").val(data.desc || '');
                        $("#iconPict").attr("src", data?.logo !== "" ? extractSrc(data.logo) : "{{ asset('assets/img/icon-img.png') }}");
                        $("#nama").focus();
                        $("#addRecord").html(`<i class="ri-save-3-fill"></i> Simpan`);
                    }
                }).fail(function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal memuat data",
                        icon: "error"
                    });
                });
            });

            // Reset button handler
            $("#reset").on('click', function() {
                resetForm();
            });

            // Helper function to reset form
            function resetForm() {
                $("#formBank")[0].reset();
                $("#id").val('');
                $("#logo").val('');
                $('input').removeClass('is-invalid').val('');
                $(".profile-container").removeClass('border-error');
                $('#iconPict').attr('src', "{{ asset('assets/img/icon-img.png') }}");
                $("#addRecord").html(`<i class="ri-add-circle-line"></i> Simpan`);
            }

            // Helper function to handle AJAX errors
            function handleAjaxError(xhr) {
                const res = xhr.responseJSON || {};
                
                if (xhr.status === 400 && res.message) {
                    // Validation errors
                    const errorFields = ['nama', 'url', 'logo'];
                    
                    errorFields.forEach(field => {
                        if (res.message[field]) {
                            const errors = res.message[field];
                            $(`#${field}`).siblings('.invalid-feedback').text(errors.join(", "));
                            $(`#${field}`).addClass('is-invalid');
                            
                            if (field === 'logo') {
                                $(".profile-container").addClass('border-error');
                            }
                        }
                    });
                } else {
                    // General error
                    Swal.fire({
                        title: res.msg_type || "Error",
                        text: res.message || 'Terjadi kesalahan',
                        icon: res.msg_type || 'error'
                    });
                }
            }
        });

        function extractSrc(htmlString) {
            let parser = new DOMParser();
            let doc = parser.parseFromString(htmlString, 'text/html');
            let src = doc.querySelector('img').src;

            return src;
        }
    </script>
@endpush