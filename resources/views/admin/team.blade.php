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
                                <div class="profile-container">
                                    <img src="{{ asset('admin/images/users/default-img.jpg') }}" alt="Foto Profil" class="img-fluid" id="profilePic">
                                    <div class="overlay-me">
                                        <div class="camera-icon">
                                            <i class="ri-camera-line"></i>
                                            <span class="tooltip-me">Upload Foto Profil</span>
                                        </div>
                                    </div>
                                </div>                                                
                                <input type="file" id="img_profile" name="img_profile"  accept="image/*" style="display:none;">
                                <p class="fs-6 text-muted">
                                    <i>Gunakan foto profil dengan ukuran 600x600px untuk hasil yang lebih baik</i>
                                </p>
                                <div class="invalid-feedback">
                                    Konten kosong
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-7">Urutan saat ditampilkan</label>
                                            <div class="col-sm-5">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <input type="number" name="urutan" id="urutan" class="form-control" style="border-radius:5px;" value="0">
                                                    <div class="invalid-feedback">
                                                        Konten kosong
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3">NIP</label>
                                            <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-11">
                                                    <input type="text" name="nip" id="nip" class="form-control" style="border-radius:5px;">
                                                    <input type="hidden" name="id" id="id">
                                                    <div class="invalid-feedback">
                                                        Konten kosong
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3">Nama</label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-11">
                                                        <input type="text" name="nama" id="nama" class="form-control" style="border-radius:5px;">
                                                        <div class="invalid-feedback">
                                                            Konten kosong
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3">Jabatan</label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-11">
                                                        <input type="text" name="jabatan" id="jabatan" class="form-control" style="border-radius:5px;">
                                                        <div class="invalid-feedback">
                                                            Konten kosong
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3  d-flex align-items-center">Link &nbsp; <i class="bi bi-instagram"></i></label>
                                            <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-11">
                                                    <input type="text" name="instagram" id="instagram" class="form-control" style="border-radius:5px;">
                                                    <div class="invalid-feedback">
                                                        Konten kosong
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3  d-flex align-items-center">Link &nbsp; <i class="bi bi-facebook"></i></label>
                                            <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-11">
                                                    <input type="text" name="facebook" id="facebook" class="form-control" style="border-radius:5px;">
                                                    <div class="invalid-feedback">
                                                        Konten kosong
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3  d-flex align-items-center">Link &nbsp; <i class="bi bi-tiktok"></i></label>
                                            <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-11">
                                                    <input type="text" name="tiktok" id="tiktok" class="form-control" style="border-radius:5px;">
                                                    <div class="invalid-feedback">
                                                        Konten kosong
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="text-center mb-2">Bio</label>
                                    <div class="form-group row mb-3">
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="bio" id="bio" rows="2"></textarea>
                                            <div class="invalid-feedback">
                                                Konten kosong
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
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Bio</th>
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
            ajax: "{{ route('admin.tim') }}",
            columns: [
                {
                    className: "my-column",
                    mData: "urutan",
                    orderable: false, 
                    searchable: false,
                    mRender: function(data, type, row) {
                        return row.urutan;
                    }
                },
                {
                    className: "my-column",
                    mData: "nama",
                    mRender: function(data, type, row) {
                        return row.nama;
                        // return `<a href="{{ url('/') }}/employee/${row.e_id}" style="text-decoration:none;">${row.nip}</a>`;
                    }
                },
                {
                    className: "my-column",
                    mData: "nip",
                    mRender: function(data, type, row) {
                        return `${row.nip}`;
                    }
                },
                {
                    className: "my-column",
                    mData: "jabatan",
                    searchable: false,
                    mRender: function(data, type, row) {
                        return `${row.jabatan}`;
                    }
                },
                {
                    className: "my-column",
                    mData: "bio",
                    searchable: false,
                    mRender: function(data, type, row) {
                        return `${row.bio}`;
                    }
                },
                {
                    mData: "",
                    orderable: false,
                    searchable: false,
                    mRender: function(data, type, row) {
                        let isStruktural = row.struktural ? ["aktif",""] : ["","aktif"];

                        return `
                        <div class="btn-group btn-group-sm gap-2" role="group" aria-label="Small button group">
                            <button type="button" class="btn btn-warning edit" data-toggle="tooltip" data-placement="top" title="Edit Item" data-id="${row.id}"><i class="ri-edit-2-line"></i></a>
                            <button type="button" class="btn btn-danger delete" data-toggle="tooltip" data-placement="top" title="Hapus Item" data-id="${row.id}"><i class="ri-delete-bin-5-line"></i> </button>
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Struktural
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li class="dropdown-item status-page ${isStruktural[0]}" data-id="${row.id}">Ya</li>
                                    <li class="dropdown-item status-page ${isStruktural[1]}" data-id="${row.id}">Tidak</li>
                                </ul>
                            </div>
                        </div>
                        `;
                    }
                }

            ],
            drawCallback:function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            }
        });

        $("#bio").summernote({
            minHeight: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear','fontname','fontsize','color','ul', 'ol', 'paragraph']]
            ]
        });

        $('.overlay-me').on('click', function(e) {
            e.stopImmediatePropagation();  // Cegah event bubbling
            $('#img_profile').click();
            e.preventDefault();
        });

        $('#img_profile').on('change', function(event) {
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

            let fileInput = $('#img_profile')[0];
            let formData = new FormData();

            if(fileInput.files.length > 0) {
                formData.append('img_profile', fileInput.files[0]);
            }

            formData.append('id', $("#id").val());            
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('nama', $("#nama").val());
            formData.append('urutan', $("#urutan").val());
            formData.append('nip', $("#nip").val());
            formData.append('jabatan', $("#jabatan").val());
            formData.append('instagram', $("#instagram").val());
            formData.append('facebook', $("#facebook").val());
            formData.append('tiktok', $("#tiktok").val());
            formData.append('bio', $("#bio").summernote('code'));

            $.ajax({
                url: "{{ route('admin.tim') }}", 
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
                            if(res.message.urutan) {
                                const errors = res.message.urutan;
                                $("#urutan").siblings('.invalid-feedback').text(errors.join(","));
                                $("#urutan").addClass('is-invalid');
                            }
                            if(res.message.nip) {
                                const errors = res.message.nip;
                                $("#nip").siblings('.invalid-feedback').text(errors.join(","));
                                $("#nip").addClass('is-invalid');
                            }
                            if(res.message.nama) {
                                const errors = res.message.nama;
                                $("#nama").siblings('.invalid-feedback').text(errors.join(","));
                                $("#nama").addClass('is-invalid');
                            }
                            if(res.message.jabatan) {
                                const errors = res.message.jabatan;
                                $("#jabatan").siblings('.invalid-feedback').text(errors.join(","));
                                $("#jabatan").addClass('is-invalid');
                            }
                            if(res.message.instagram) {
                                const errors = res.message.instagram;
                                $("#instagram").siblings('.invalid-feedback').text(errors.join(","));
                                $("#instagram").addClass('is-invalid');
                            }
                            if(res.message.facebook) {
                                const errors = res.message.facebook;
                                $("#facebook").siblings('.invalid-feedback').text(errors.join(","));
                                $("#facebook").addClass('is-invalid');
                            }
                            if(res.message.tiktok) {
                                const errors = res.message.tiktok;
                                $("#tiktok").siblings('.invalid-feedback').text(errors.join(","));
                                $("#tiktok").addClass('is-invalid');
                            }
                            if(res.message.bio) {
                                const errors = res.message.bio;
                                $("#bio").siblings('.invalid-feedback').text(errors.join(","));
                                $("#bio").addClass('is-invalid');
                            }
                            if(res.message.img_profile) {
                                const errors = res.message.img_profile;
                                $("#img_profile").siblings('.invalid-feedback').text(errors.join(","));
                                $("#img_profile").addClass('is-invalid');
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
                    url: "{{ route('admin.tim-delete') }}",
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
            $("#img_profile").val('');
            let id = $(this).attr("data-id");
            $.get(`{{ url('cms-tim-detail') }}/${id}`, function (obj) {
                let success = obj.success;
                let msg = obj.msg;
                let data = obj.data;

                if(data)
                {
                    $("#id").val(id);
                    $("#urutan").val(data.urutan);
                    $("#nip").val(data.nip);
                    $("#nama").val(data.nama);
                    $("#jabatan").val(data.jabatan);
                    $("#bio").summernote('code', data.bio);
                    $("#instagram").val(data.instagram);
                    $("#facebook").val(data.facebook);
                    $("#tiktok").val(data.tiktok);
                    $("#profilePic").attr("src", data.img_profile);
                    $("#nama").focus();
                    $("#addRecord").html(`<i class="ri-save-3-fill"></i> Simpan`);
                }
            });
        })

        $(document).on('click', '.status-page', function() {
            var id = $(this).attr('data-id');
            var isStruktural = $(this).text() === 'Ya';

            $.ajax({
                url: "{{ route('admin.tim-struktur') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    struktural: isStruktural
                },
                success: function(response) {
                    Swal.fire('Sukses', response.message, 'success');
                    table.draw(false);
                },
                error: function(xhr) {
                    var err = JSON.parse(xhr.responseText);
                    Swal.fire('Error', err.message, 'error');
                }
            });
        });

        $("#reset").click(function() {
            $('input').val("");
            $('input').removeClass('is-invalid');
            $("#urutan").val(0);
            $('#profilePic').attr('src', "{{ asset('admin/images/users/default-img.jpg') }}");
            $(".profile-container").removeClass('border-error');
            $("#bio").summernote('code',"");
        })

    });
</script>
@endpush