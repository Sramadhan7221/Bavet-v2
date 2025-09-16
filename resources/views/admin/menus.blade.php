@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h3 style="margin-bottom: 2.5rem; color: #b8860b;">Master Mahasiswa</h3> --}}
                    <form id="formMenus" method="POST" >
                        <div class="row">
                            <div class="col-6">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Judul</label>
                                    <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" name="title" id="title" class="form-control" style="border-radius:5px;">
                                            <div class="invalid-feedback">
                                                Please choose a username.
                                            </div>
                                            <input type="hidden" name="code" id="code">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3">Parent Menu</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <select name="parent_id" id="parentId">
                                                    <option value=""></option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please choose a username.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-4">Tipe Menu</label>
                                    <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <select class="form-control" name="type" id="type">
                                                <option value=""></option>
                                                <option value="static">Statis</option>
                                                <option value="module">Module</option>
                                                <option value="external">Link Eksternal</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose a username.
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-4">Status</label>
                                    <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <select class="form-control" name="is_active" id="isActive">
                                                <option value="true" {{ old('is_active') == "true" ? 'selected' : '' }}>Aktif</option>
                                                <option value="false" {{ old('is_active') == "false" ? 'selected' : '' }}>Tidak Aktif</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose a username.
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Simpan input" id="addRecord">
                            <i class="ri-add-circle-line"></i> Tambah 
                        </button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-toggle="tooltip" data-placement="top" title="Reset Form" id="reset">
                            <i class="ri-arrow-go-back-line"></i> Reset 
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tree" class="table table-bordered table-striped">
                        <colgroup>
                            <col width="300px">
                            <col width="150px">
                            <col width="80px">
                            <col width="100px">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Menu Title</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.jsdelivr.net/npm/jquery.fancytree@2.25/dist/skin-lion/ui.fancytree.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/jquery.fancytree@2.27/dist/jquery.fancytree-all-deps.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $("#tree").fancytree({
                extensions: ["dnd5","table"],
                source: {
                    url: "{{ route('menus.tree') }}" // route ke controller
                },lazyLoad: function(event, data) {
                    data.result = {
                    url: "{{ route('menus.tree') }}",
                    data: { parentId: data.node.key }
                    };
                },
                dnd5: {
                    preventVoidMoves: true,   // tidak boleh drop ke area kosong
                    preventRecursion: true,   // tidak boleh drag ke anak sendiri
                    autoExpandMS: 400,

                    dragStart: function(node, data) {
                        return true; // allow dragging
                    },
                    dragEnter: function(node, data) {
                        // hanya izinkan reorder di level yang sama
                        if(node.parent !== data.otherNode.parent) {
                            return false;
                        }
                        return ["before", "after"]; // hanya boleh drop sebelum/sesudah
                    },
                    dragDrop: function(node, data) {
                        // pindahkan node secara visual
                        data.otherNode.moveTo(node, data.hitMode);

                        // Kirim update urutan ke API
                        let parentId = node.parent.key;

                        $.ajax({
                            url: "{{ route('menus.item-order') }}",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                menu_list: node.parent.children.map(function(child){
                                    return child.key;
                                })
                            },
                            beforeSend: function () {
                                $(".loader").addClass("show");
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: response.msg_type,
                                    text: response.message,
                                    icon: response.msg_type
                                });
                            },
                            complete: function() {
                                $(".loader").removeClass("show");
                            },
                            statusCode: {
                                400: function(xhr) {
                                    let res = xhr.responseJSON ?? {};
                                    Swal.fire({
                                        title: "Warning",
                                        text: res.message || 'Validation error',
                                        icon: res.msg_type || 'warning'
                                    });
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
                    }
                },
                table: {
                    indentation: 20,      // indentasi anak
                    nodeColumnIdx: 0,     // kolom pertama untuk tree
                    checkboxColumnIdx: null
                },
                renderColumns: function(event, data) {
                    var node = data.node;
                    var $tdList = $(node.tr).find(">td");

                    // Kolom 1 (Slug)
                    $tdList.eq(1).text(node.data.slug || '-');

                    // Kolom 2 (Type)
                    $tdList.eq(2).text(node.data.menu_type || '-');

                    // Kolom 2 (Type)
                    $tdList.eq(3).html(`<div class="btn-group btn-group-sm gap-2" 
                        role="group" aria-label="Small button group">
                            <button type="button" class="btn btn-warning edit" data-toggle="tooltip" data-placement="top" title="Edit Menu" data-id="${node.data.menu_id}"><i class="ri-edit-2-line"></i></button>
                            <button type="button" class="btn btn-danger delete" data-toggle="tooltip" data-placement="top" title="Hapus Menu" data-id="${node.data.menu_id}"><i class="ri-delete-bin-5-line"></i> </button>
                        </div>`);
                }
            });

            $("#parentId").select2({
                placeholder: "Pilih Parent Menu",
                allowClear: true,
                tags: true, // Tambahkan opsi ini agar pengguna bisa menambahkan opsi baru
                language: {
                    inputTooShort: function () {
                        return "Harap masukkan minimal 3 karakter";
                    }
                },
                ajax: {
                    url: "{{ route('menus.parent') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Kirim parameter pencarian ke server
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response.data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.title
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3,
                createTag: function (params) {
                    var term = $.trim(params.term);

                    // Jika input kosong, tidak usah buat tag
                    if (term === '') {
                        return null;
                    }

                    // Buat tag baru jika input tidak ada di response AJAX
                    return {
                        id: term, // Gunakan teks input sebagai id
                        text: term, // Gunakan teks input sebagai teks opsi
                        newOption: true
                    };
                },
                templateResult: function (repo) {
                    if (repo.loading) {
                        return repo.text;
                    }

                    var $container = $("<div></div>");

                    // Jika opsi adalah hasil dari tag baru, tandai
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

            $("#addRecord").click(function() {
                $.ajax({
                    url: "{{ route('menus.tree') }}", 
                    method: 'POST',
                    data: $("#formMenus").serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('input').removeClass('is-invalid');
                        $("#addRecord").attr("disabled","disabled");
                        $("#addRecord").html(`<span class="spinner-border spinner-border-sm me-1" role="status"
                        aria-hidden="true"></span>
                        Loading...`);
                    },
                    success: function(response) {
                        reloadTree();
                        if(response.with_parent) {
                            let parent = response.with_parent;
                            var option = new Option(parent.title, parent.id, true, true);
                            $("#parentId").append(option).trigger('change');
                            $("#parentId").removeAttr("disabled");
                        }
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
                        $("#addRecord").html(`<i class="ri-add-circle-line"></i> Tambah`);
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
                                if(res.message.type) {
                                    const errors = res.message.type;
                                    $("#type").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#type").addClass('is-invalid');
                                }
                                if(res.message.is_active) {
                                    const errors = res.message.is_active;
                                    $("#isActive").siblings('.invalid-feedback').text(errors.join(","));
                                    $("#isActive").addClass('is-invalid');
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

            $("#reset").click(function () {
                resetForm();
            })

            $(document).on('click','.edit', function() {
                let Id = $(this).attr("data-id");
                $.get(`{{ url('menu-detail') }}/${Id}`, function (obj) {
                    let data = obj.data;
                    if(data)
                    {
                        $("#code").val(Id);
                        $("#title").val(data.title);
                        $("#title").focus();

                        if(data.parent) {
                            var option = new Option(data.parent.title, data.parent.id, true, true);
                            $("#parentId").append(option).trigger('change');
                            $("#parentId").removeAttr("disabled");
                        }

                        if(data.type === 'parent') {
                            $("#type").val("").trigger('change');
                            $("#type").attr("disabled","disabled");
                            $("#parentId").val("").trigger('change');
                            $("#parentId").attr("disabled","disabled");
                        }
                        else {
                            $("#type").val(data.type).trigger('change');
                            $("#type").removeAttr("disabled");
                        }

                        $("#isActive").val(data.is_active).trigger('change');
                        $("#addRecord").html(`<i class="ri-save-3-fill"></i> Simpan`);
                    }else{
                        Swal.fire({
                            title: "Perhatian",
                            text: "Data tidak ditemukan",
                            icon: "warning"
                        });
                    }
                });
            })

            $(document).on('click','.delete', function() {
                let Id = $(this).attr("data-id");
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
                            url: "{{ route('menus.item-delete') }}",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                code: Id
                            },
                            success: function(response) {
                                let msgTitle = response.msg_type == 'success' ? "Berhasil" : "Perhatian";
                                Swal.fire({
                                    title: msgTitle,
                                    text: response.msg,
                                    icon: response.msg_type
                                });

                                reloadTree();
                            },
                            error: function(response) {
                                let msgTitle = response.responseJSON.msg_type == 'warning' ? "Perhatian" : "Gagal";
                                Swal.fire({
                                    title: msgTitle,
                                    text: response.responseJSON.msg,
                                    icon: response.responseJSON.msg_type
                                });
                            }
                        });
                    }
                });
                
            });

            function reloadTree() {
                const tree = $("#tree").fancytree("getTree");
                tree.reload({
                    url: "{{ route('menus.tree') }}" 
                });
            }

            function resetForm() {
                $("#id").val("");
                $("#title").val("");
                $("#isActive").val("true").trigger('change');
                $("#parentId").val("").trigger('change');
                $("#parentId").removeAttr('disabled');
                $("#type").val("").trigger('change');
                $("#type").removeAttr('disabled');
            }
        });
    </script>
@endpush