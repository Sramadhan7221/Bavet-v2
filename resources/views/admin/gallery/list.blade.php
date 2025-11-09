@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-end mb-2">
        <div class="col-12">
            <a href="{{ route('admin.gallery.detail') }}" class="btn btn-primary"><i class="ri-add-line"></i> Tambah Galeri</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Banner</th>
                                <th>Tanggal Upload</th>
                                <th>Status</th>
                                <th>Tombol Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
@endsection

@push('styles')
    <!-- Datatables css -->
    <link href="{{ asset('admin/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .status-page{
            cursor: pointer;
        }
        .my-column{
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            ajax: "{{ route('admin.gallery') }}",
            columns: [
                {
                    mData: "DT_RowIndex",
                    orderable: false, 
                    searchable: false,
                    mRender: function(data, type, row) {
                        return data;
                    }
                },
                {
                    className: "my-column",
                    mData: "title",
                    mRender: function(data, type, row) {
                        return `${row.title}`;
                    }
                },
                {
                    className: "my-column",
                    mData: "banner",
                    searchable: false,
                    mRender: function(data, type, row) {
                        return `<img src="${row.banner}" alt="${row.title}" width="100px"/>`;
                    }
                },
                {
                    className: "my-column",
                    mData: "created_at",
                    searchable: false,
                    mRender: function(data, type, row) {
                        return `${row.created_at}`;
                    }
                },
                {
                    className: "my-column",
                    mData: "is_active",
                    searchable: false,
                    mRender: function(data, type, row) {
                        return `${row.is_active == 'true' ? 'Aktif' : 'Tidak Aktif'}`;
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
                            <a href="{{ route('admin.gallery.detail') }}?slug=${row.slug}" class="btn btn-warning edit" data-toggle="tooltip" data-placement="top" title="Edit Item"><i class="ri-edit-2-line"></i></a>
                            <button type="button" class="btn btn-danger delete" data-toggle="tooltip" data-placement="top" title="Hapus Item" data-id="${row.slug}"><i class="ri-delete-bin-5-line"></i> </button>
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Status
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li class="dropdown-item status-page" data-id="${row.slug}">Aktif</li>
                                    <li class="dropdown-item status-page" data-id="${row.slug}">Non-Aktif</li>
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

        $(document).on('click', '.status-page', function() {
            var slug = $(this).attr('data-id');
            var newStatus = $(this).text() === 'Aktif' ? 'true' : 'false';

            $.ajax({
                url: "{{ route('admin.page-status') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    slug: slug,
                    is_active: newStatus
                },
                success: function(response) {
                    Swal.fire('Sukses', response.message, 'success');
                    table.draw();
                },
                error: function(xhr) {
                    var err = JSON.parse(xhr.responseText);
                    Swal.fire('Error', err.message, 'error');
                }
            });
        });

        //delete record handler
        $(document).on('click','.delete', function() {
            let id = $(this).attr("data-id");
            Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda tidak akan mengembalikan data yang sudah dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.page-delete') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        slug: id
                    },
                    success: function(response) {
                        Swal.fire({
                            title: response.msg_type == "success" ? "Success" : "Attention",
                            text: response.message,
                            icon: response.msg_type
                        });

                        table.draw();
                    },
                    error: function(response) {
                        Swal.fire({
                            title: "Failed",
                            text: response.responseJSON.message,
                            icon: response.responseJSON.msg_type
                        });
                    }
                });
            }
            });

        });
    });
</script>
@endpush