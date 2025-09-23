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
                        @csrf
                        <div class="row">
                            <div class="col-6">
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
                                    <label class="col-sm-3">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <textarea name="desc" id="desc" class="form-control" style="border-radius:5px;" cols="5" rows="5">{{ $content?->desc ?? "" }}</textarea>
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
                                    <img src="{{  $content?->image_hero ?? "#" }}" alt="" class="img-fluid" id="image_heroPrev">
                                </div>
                            </div>
                        </div>
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
                                               <input type="file" name="image_visimisi" id="image_visimisi">
                                                <div class="invalid-feedback">
                                                    Gambar kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <img src="{{  $content?->image_visimisi ?? "#" }}" alt="" class="img-fluid" id="image_visimisiPrev">
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
                let fileInputVisiMisi = $('#image_visimisi')[0];
                let formData = new FormData();

                if(fileInput.files.length > 0) {
                    formData.append('image_hero', fileInput.files[0]);
                }

                if(fileInputVisiMisi.files.length > 0) {
                    formData.append('image_visimisi', fileInputVisiMisi.files[0]);
                }

                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $("#id").val());
                formData.append('title', $("#title").val());
                formData.append('desc', $("#desc").val());
                formData.append('visi', $("#visi").val());
                $("input[name='misi[]']").each(function() {
                    formData.append('misi[]', $(this).val());
                });

                $.ajax({
                    url: "{{ route('admin.about') }}", 
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
                        
                        let data = response.data;

                        $("#image_heroPrev").prop("src", data.image_hero);
                        $("#image_visimisiPrev").prop("src", data.image_visimisi);

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
                                if(res.message.desc) {
                                    const errors = res.message.desc;
                                    $("#desc").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#desc").addClass('is-invalid');
                                }
                                if(res.message.visi) {
                                    const errors = res.message.visi;
                                    $("#visi").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#visi").addClass('is-invalid');
                                }
                                if(res.message.misi) {
                                    const errors = res.message.misi;
                                    $("#misiCon").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#misi").addClass('is-invalid');
                                }
                                if(res.message.image_hero) {
                                    const errors = res.message.image_hero;
                                    $("#image_hero").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#image_hero").addClass('is-invalid');
                                }
                                if(res.message.image_visimisi) {
                                    const errors = res.message.image_visimisi;
                                    $("#image_visimisi").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#image_visimisi").addClass('is-invalid');
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