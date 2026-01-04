@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    {{-- Hero Section --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 style="color: #b8860b;">Hero</h3>
                </div>
                <div class="card-body">
                    <form id="formMenus" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-6">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Motto</label>
                                    <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" name="title" id="title" class="form-control" style="border-radius:5px;" value="{{ $content?->title ?? "" }}">
                                            <div class="invalid-feedback">
                                                Motto kosong
                                            </div>
                                            <input type="hidden" name="id" id="id" value="{{ $content?->id ?? "" }}">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <textarea name="subtitle" id="subtitle" class="form-control" style="border-radius:5px;" cols="3" rows="3">{{ $content?->subtitle ?? "" }}</textarea>
                                                <div class="invalid-feedback">
                                                    Deskripsi kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Link Youtube</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input type="text" name="yt_link" id="yt_link" class="form-control" style="border-radius:5px;" value="{{ $content?->yt_link ?? "" }}">
                                                <div class="invalid-feedback">
                                                    Link Player Kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Gambar Sampul</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                               <input type="file" name="image_hero" id="image_hero">
                                                <div class="invalid-feedback">
                                                    Gambar Sampul kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Simpan input" id="addRecord">
                                <i class="ri-save-3-line"></i> Simpan 
                            </button>
                        </div>
                        <hr>
                        <h4>Gambar sampul tersimpan</h4>
                        <div class="row d-flex justify-content-center">
                            <div class="col-6">
                                <img src="{{  $content?->image_hero ?? "#" }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
    {{-- Visi Misi --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 style="color: #b8860b;">Visi Misi</h3>
                </div>
                <div class="card-body">
                    <form id="formVm" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Visi</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <textarea name="visi" id="visi" class="form-control" style="border-radius:5px;" cols="3" rows="3">{{ $content?->visi ?? "" }}</textarea>
                                                <div class="invalid-feedback">
                                                    Visi kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Misi</label>
                                    @php
                                        $misiList = explode("|",$content?->misi);
                                    @endphp
                                    <div class="col-sm-9" id="misiFill">
                                        <div class="d-flex gap-2" id="misiCon">
                                            <input 
                                                type="text" 
                                                name="misi[]" 
                                                id="misi" 
                                                class="form-control" 
                                                style="border-radius:5px;"
                                            value="{{ isset($misiList[0]) ? $misiList[0] : "" }}"
                                            >
                                            <button type="button" class="btn btn-primary" id="addMisi">
                                                <i class="ri-add-circle-line"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">
                                            Misi kosong
                                        </div>
                                        @foreach ($misiList as $idx => $item)
                                            @if ($idx > 0)    
                                                <div class="row mt-1">
                                                    <div class="col-sm-12">
                                                        <input type="text" name="misi[]" value="{{ $item }}" class="form-control" style="border-radius:5px;">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Gambar</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                               <input type="file" name="vm_banner" id="vm_banner">
                                                <div class="invalid-feedback">
                                                    Gambar kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Simpan input" id="addVM">
                                <i class="ri-save-3-line"></i> Simpan 
                            </button>
                        </div>
                        <hr>
                        <h4>Banner visi misi tersimpan</h4>
                        <div class="row d-flex justify-content-center">
                            <div class="col-6">
                                <img src="{{  $content?->vm_banner ?? "#" }}" alt="" class="img-fluid" id="vm_bannerPrev">
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    {{-- Jumlah Pengujian --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 style="color: #b8860b;">Statistik Pengujian</h3>
                </div>
                <div class="card-body">
                    <form id="formPengujian" method="POST">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Tahun</label>
                                    <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="number" name="p_year" id="p_year" class="form-control" style="border-radius:5px;" value="{{ $content?->p_year ?? "" }}">
                                            <div class="invalid-feedback">
                                                Tahun kosong
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Jml Pengujian Hewan</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input type="number" name="p_hewan" id="p_hewan" class="form-control" style="border-radius:5px;" value="{{ $content?->p_hewan ?? "" }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Jml Pengujian Produk Hewan</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                               <input type="number" name="p_produk" id="p_produk" class="form-control" style="border-radius:5px;" value="{{ $content?->p_produk ?? "" }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Jml Pengujian Kesmavet</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                               <input type="number" name="p_kesmavet" id="p_kesmavet" class="form-control" style="border-radius:5px;" value="{{ $content?->p_kesmavet ?? "" }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Simpan input" id="addStatData">
                                <i class="ri-save-3-line"></i> Simpan 
                            </button>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->


</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $("#addRecord").click(function() {

                let fileInput = $('#image_hero')[0];
                let formData = new FormData();
                if(fileInput.files.length > 0) {
                    formData.append('image_hero', fileInput.files[0]);
                }

                formData.append('_token', "{{ csrf_token() }}");
                formData.append('type', "hero");
                formData.append('id', $("#id").val());
                formData.append('title', $("#title").val());
                formData.append('subtitle', $("#subtitle").val());
                formData.append('yt_link', $("#yt_link").val());
                formData.append('maks_struktural', $("#maks_struktural").val());

                $.ajax({
                    url: "{{ route('admin.home') }}", 
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
                            if(res.errors) {
                                if(res.errors.title) {
                                    const errors = res.errors.title;
                                    $("#title").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#title").addClass('is-invalid');
                                }
                                if(res.errors.subtitle) {
                                    const errors = res.errors.subtitle;
                                    $("#subtitle").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#subtitle").addClass('is-invalid');
                                }
                                if(res.errors.yt_link) {
                                    const errors = res.errors.yt_link;
                                    $("#yt_link").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#yt_link").addClass('is-invalid');
                                }
                                if(res.errors.maks_struktural) {
                                    const errors = res.errors.maks_struktural;
                                    $("#maks_struktural").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#maks_struktural").addClass('is-invalid');
                                }
                                if(res.errors.image_hero) {
                                    const errors = res.errors.image_hero;
                                    $("#image_hero").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#image_hero").addClass('is-invalid');
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

            $("#addVM").click(function() {

                let fileInputVisiMisi = $('#vm_banner')[0];
                let formData = new FormData();

                if(fileInputVisiMisi.files.length > 0) {
                    formData.append('vm_banner', fileInputVisiMisi.files[0]);
                }

                formData.append('_token', "{{ csrf_token() }}");
                formData.append('type', "vm");
                formData.append('id', $("#id").val());
                formData.append('visi', $("#visi").val());
                $("input[name='misi[]']").each(function() {
                    formData.append('misi[]', $(this).val());
                });

                $.ajax({
                    url: "{{ route('admin.home') }}", 
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('input').removeClass('is-invalid');
                        $("#addVM").attr("disabled","disabled");
                        $("#addVM").html(`<span class="spinner-border spinner-border-sm me-1" role="status"
                        aria-hidden="true"></span>
                        Loading...`);
                    },
                    success: function(response) {
                        
                        let data = response.data;

                        if(data.image_hero)
                            $("#image_heroPrev").prop("src", data.image_hero);
                        if(data.vm_banner)
                            $("#vm_bannerPrev").prop("src", data.vm_banner);

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
                        $("#addVM").removeAttr("disabled");
                        $("#addVM").html(`<i class="ri-add-circle-line"></i> Simpan`);
                    },
                    statusCode: {
                        400: function(xhr) {
                            let res = xhr.responseJSON ?? {};
                            if(res.errors) {
                                if(res.errors.visi) {
                                    const errors = res.errors.visi;
                                    $("#visi").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#visi").addClass('is-invalid');
                                }
                                if(res.errors.misi) {
                                    const errors = res.errors.misi;
                                    $("#misi").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#misi").addClass('is-invalid');
                                }
                                if(res.errors.vm_banner) {
                                    const errors = res.errors.vm_banner;
                                    $("#vm_banner").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#vm_banner").addClass('is-invalid');
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

            $("#addStatData").click(function() {

                let formData = new FormData();

                formData.append('_token', "{{ csrf_token() }}");
                formData.append('type', "pengujian");
                formData.append('id', $("#id").val());
                formData.append('p_year', $("#p_year").val());
                formData.append('p_hewan', $("#p_hewan").val());
                formData.append('p_produk', $("#p_produk").val());
                formData.append('p_kesmavet', $("#p_kesmavet").val());

                $.ajax({
                    url: "{{ route('admin.home') }}", 
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('input').removeClass('is-invalid');
                        $("#addStatData").attr("disabled","disabled");
                        $("#addStatData").html(`<span class="spinner-border spinner-border-sm me-1" role="status"
                        aria-hidden="true"></span>
                        Loading...`);
                    },
                    success: function(response) {
                        
                        let data = response.data;

                        Swal.fire({
                            title: response.msg_type,
                            text: response.message,
                            icon: response.msg_type
                        });

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        $("#addStatData")
                            .removeAttr("data-kt-indicator")
                            .attr("disabled", false);
                    },
                    complete: function() {
                        $("#addStatData").removeAttr("disabled");
                        $("#addStatData").html(`<i class="ri-add-circle-line"></i> Simpan`);
                    },
                    statusCode: {
                        400: function(xhr) {
                            let res = xhr.responseJSON ?? {};
                            if(res.errors) {
                                if(res.errors.p_year) {
                                    const errors = res.errors.p_year;
                                    $("#p_year").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#p_year").addClass('is-invalid');
                                }
                                if(res.errors.p_hewan) {
                                    const errors = res.errors.p_hewan;
                                    $("#p_hewan").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#p_hewan").addClass('is-invalid');
                                }
                                if(res.errors.p_produk) {
                                    const errors = res.errors.p_produk;
                                    $("#p_produk").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#p_produk").addClass('is-invalid');
                                }
                                if(res.errors.p_kesmavet) {
                                    const errors = res.errors.p_kesmavet;
                                    $("#p_kesmavet").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#p_kesmavet").addClass('is-invalid');
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

            $("#addMisi").click(function () {
                if($("#misi").val()) {
                    let isi  = $("#misi").val();
                    $("#misiFill").append(`
                        <div class="row mt-1">
                            <div class="col-sm-12">
                                <input type="text" name="misi[]" value="${isi}" class="form-control" style="border-radius:5px;">
                            </div>
                        </div>
                    `);
                    $("#misi").val("");
                }
            })
        });
    </script>
@endpush