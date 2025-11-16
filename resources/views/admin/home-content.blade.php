@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h3 style="margin-bottom: 2.5rem; color: #b8860b;">Master Mahasiswa</h3> --}}
                    <form id="formMenus" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-6">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Judul</label>
                                    <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" name="title" id="title" class="form-control" style="border-radius:5px;" value="{{ $content?->title ?? "" }}">
                                            <div class="invalid-feedback">
                                                Judul kosong
                                            </div>
                                            <input type="hidden" name="id" id="id" value="{{ $content?->id ?? "" }}">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Sub judul</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <textarea name="subtitle" id="subtitle" class="form-control" style="border-radius:5px;" cols="3" rows="3">{{ $content?->subtitle ?? "" }}</textarea>
                                                <div class="invalid-feedback">
                                                    Sub Judul kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                    <label class="col-sm-3">Profil Struktural</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input type="number" name="maks_struktural" id="maks_struktural" class="form-control" style="border-radius:5px;" value="{{ $content?->maks_struktural ?? "0" }}">
                                                <p class="fs-6 text-muted">
                                                   <i>Jumlah profil struktural yang akan ditampilkan di halaman utama</i>
                                                </p>
                                                <div class="invalid-feedback">
                                                    Link Player Kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Gambar</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                               <input type="file" name="image_hero" id="image_hero">
                                                <div class="invalid-feedback">
                                                    Gambar kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <img src="{{  $content?->image_hero ?? "#" }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Simpan input" id="addRecord">
                            <i class="ri-add-circle-line"></i> Simpan 
                        </button>
                        {{-- <button type="button" class="btn btn-outline-secondary rounded-pill" data-toggle="tooltip" data-placement="top" title="Reset Form" id="reset">
                            <i class="ri-arrow-go-back-line"></i> Reset 
                        </button> --}}
                    </div>
                </div>
                <div class="card-body">
                    
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
                            if(res.message) {
                                if(res.message.title) {
                                    const errors = res.message.title;
                                    $("#title").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#title").addClass('is-invalid');
                                }
                                if(res.message.subtitle) {
                                    const errors = res.message.subtitle;
                                    $("#subtitle").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#subtitle").addClass('is-invalid');
                                }
                                if(res.message.yt_link) {
                                    const errors = res.message.yt_link;
                                    $("#yt_link").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#yt_link").addClass('is-invalid');
                                }
                                if(res.message.maks_struktural) {
                                    const errors = res.message.maks_struktural;
                                    $("#maks_struktural").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#maks_struktural").addClass('is-invalid');
                                }
                                if(res.message.image_hero) {
                                    const errors = res.message.image_hero;
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
        });
    </script>
@endpush