@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form id="formBank">
                        <div class="row">
                            <div class="col-2">
                                <input type="hidden" id="id">
                                <div class="profile-container">
                                    <img src="{{ asset('admin/images/users/default-img.jpg') }}" alt="Foto Profil" class="img-fluid" id="profilePic">
                                    <div class="overlay-me">
                                        <div class="camera-icon">
                                            <i class="ri-camera-line"></i>
                                            <span class="tooltip-me">Upload Foto Profil</span>
                                        </div>
                                    </div>
                                </div>                                                
                                <input type="file" id="profil" name="profil"  accept="image/*" style="display:none;">
                                <p class="fs-6 text-muted">
                                    <i>Gunakan foto profil dengan ukuran 600x600px untuk hasil yang lebih baik</i>
                                </p>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-10">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Nama</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input type="text" name="nama" id="nama" class="form-control" style="border-radius:5px;">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Institusi Asal</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input type="text" name="institusi" id="institusi" class="form-control" style="border-radius:5px;">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Review</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <textarea name="review" id="review"></textarea>
                                                <div class="invalid-feedback"></div>
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
                                <th>Nama</th>
                                <th>Institusi Asal</th>
                                <th>Review</th>
                                <th>Tombol Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

</div> <!-- container -->
@endsection

@push('styles')
    <!-- Datatables css -->
    <link href="{{ asset('admin/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .border-error {
            border: 2px solid red!important;
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
        .status-page{
            cursor: pointer;
        }
        .status-page.aktif{
            background-color: aqua;
        }
        .my-column{
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
<!-- Datatables js -->
<script src="{{ asset('admin/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
{{-- <script src="admin/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="admin/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script> --}}
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
    $(document).ready(function () {
        let table = $("#fixed-header-datatable").DataTable({
            scrollX: !0,
            responsive:true,
            language:{
                paginate:{
                    previous:"<i class='ri-arrow-left-s-line'>",
                    next:"<i class='ri-arrow-right-s-line'>"
                }
            },
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [
                {
                    className: "my-column",
                    mData: "DT_RowIndex",
                    orderable: false, 
                    searchable: false,
                    mRender: function(data, type, row) {
                        return data;
                    }
                },
                {
                    className: "my-column",
                    mData: "nama",
                    mRender: function(data, type, row) {
                        return row.nama;
                    }
                },
                {
                    className: "my-column",
                    mData: "institusi",
                    mRender: function(data, type, row) {
                        return `${row.institusi}`;
                    }
                },
                {
                    mData: "review",
                    searchable: false,
                    mRender: function(data, type, row) {
                        return row.review;
                    }
                },
                {
                    className: "my-column",
                    mData: "",
                    orderable: false,
                    searchable: false,
                    mRender: function(data, type, row) {
                        return `
                        <div class="btn-group btn-group-sm gap-2" role="group" aria-label="Small button group">
                            <button type="button" class="btn btn-warning edit" data-toggle="tooltip" data-placement="top" title="Edit Item" data-id="${row.id}"><i class="ri-edit-2-line"></i></a>
                            <button type="button" class="btn btn-danger delete" data-toggle="tooltip" data-placement="top" title="Hapus Item" data-id="${row.id}"><i class="ri-delete-bin-5-line"></i> </button>
                        </div>
                        `;
                    }
                }

            ],
            drawCallback:function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            }
        });

        $("#review").summernote({
            minHeight: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear','fontname','fontsize','color','ul', 'ol', 'paragraph']]
            ]
        });

        $('.overlay-me').on('click', function(e) {
            e.stopImmediatePropagation();  // Cegah event bubbling
            $('#profil').click();
            e.preventDefault();
        });

        $('#profil').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profilePic').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $("#addRecord").click(function() {

            let fileInput = $('#profil')[0];
            let formData = new FormData();

            if(fileInput.files.length > 0) {
                formData.append('profil', fileInput.files[0]);
            }

            formData.append('id', $("#id").val() ?? null);            
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('nama', $("#nama").val());
            formData.append('institusi', $("#institusi").val());
            formData.append('review', $("#review").summernote('code'));

            $.ajax({
                url: "{{ route('admin.testi') }}", 
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('input').removeClass('is-invalid');
                    $(".profile-container").removeClass('border-error');
                    $("#addRecord").attr("disabled","disabled");
                    $("#addRecord").html(`<span class="spinner-border spinner-border-sm me-1" role="status"
                    aria-hidden="true"></span>
                    Loading...`);
                },
                success: function(response) {
                    table.draw();

                    Swal.fire({
                        title: response.msg_type,
                        text: response.message,
                        icon: response.msg_type
                    });

                },
                complete: function() {
                    $("#addRecord").removeAttr("disabled");
                    $("#addRecord").html(`<i class="ri-add-circle-line"></i> Simpan`);
                },
                statusCode: {
                    400: function(xhr) {
                        let res = xhr.responseJSON ?? {};
                        if(res.message) {
                            if(res.message.nama) {
                                const errors = res.message.nama;
                                $("#nama").siblings('.invalid-feedback').text(errors.join(","));
                                $("#nama").addClass('is-invalid');
                            }
                            if(res.message.institusi) {
                                const errors = res.message.institusi;
                                $("#institusi").siblings('.invalid-feedback').text(errors.join(","));
                                $("#institusi").addClass('is-invalid');
                            }
                            if(res.message.review) {
                                const errors = res.message.review;
                                $("#review").siblings('.invalid-feedback').text(errors.join(","));
                                $("#review").addClass('is-invalid');
                            }
                            if(res.message.profil) {
                                const errors = res.message.profil;
                                $("#profil").siblings('.invalid-feedback').text(errors.join(","));
                                $("#profil").addClass('is-invalid');
                                $(".profile-container").addClass('border-error');
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
        
        $(document).on('click','.delete', function() {
            let id = $(this).attr("data-id");
            $("#id").val("");
            Swal.fire({
            title: "Apakah anda yakin?",
            text: "Perubahan tidak dapat dikembalikan",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.testi-delete') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil",
                            text: response.msg,
                            icon: "success"
                        });

                        table.draw();
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            }
            });
            
        });

        $(document).on('click','.edit', function() {
            $("#profil").val('');
            let id = $(this).attr("data-id");
            $.get(`{{ url('cms-testi-detail') }}/${id}`, function (obj) {
                let success = obj.success;
                let msg = obj.msg;
                let data = obj.data;

                if(data)
                {
                    $("#id").val(id);
                    $("#nama").val(data.nama);
                    $("#institusi").val(data.institusi);
                    $("#review").summernote('code', data.review);
                    $("#profilePic").attr("src", data.profil);
                    $("#nama").focus();
                    $("#addRecord").html(`<i class="ri-save-3-fill"></i> Simpan`);
                }
            });
        })

        $("#reset").click(function() {
            $('input').val("");
            $('input').removeClass('is-invalid');
            $('#profilePic').attr('src', "{{ asset('admin/images/users/default-img.jpg') }}");
            $(".profile-container").removeClass('border-error');
            $("#review").summernote('code',"");
        })

    });
</script>
@endpush