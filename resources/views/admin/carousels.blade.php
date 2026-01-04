@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-4">
                    <div class="upload-container">
                        <!-- Dropzone Upload Section -->
                        <h4 class="mb-4">Upload Konten Carousel</h4>
                        <form class="dropzone" id="imageUpload">
                            @csrf
                        </form>
                    </div>
                </div> <!-- end card body-->
                <div class="card-body">
                    <table id="fixed-header-datatable" class="table table-striped dt-responsive nowrap table-striped w-100">
                        <thead>
                            <tr>
                                <th>No Urut</th>
                                <th>Konten</th>
                                <th>Status</th>
                                <th>Tombol Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
<!-- Datatables css -->
    <link href="{{ asset('admin/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .my-column {
        vertical-align: middle;
    }

    .border-error {
        border: 2px solid red !important;
    }
    .gallery-item {
        position: relative;
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
    }
    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .gallery-item .delete-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }
    .gallery-item .delete-btn:hover {
        background: rgba(255, 0, 0, 1);
        transform: scale(1.1);
    }
    .dropzone {
        border: 2px dashed #0087F7 !important;
        border-radius: 8px !important;
        background: #f9f9f9 !important;
        min-height: 150px !important;
        padding: 20px !important;
        text-align: center !important;
        margin-bottom: 30px;
    }
    .dropzone.dz-drag-hover {
        background-color: #e3f2fd !important;
        border-color: #1976d2 !important;
    }
    .dz-message {
        margin: 2rem 0 !important;
        color: #0087F7 !important;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
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
(function() {
    'use strict';

    const csrfToken = "{{ csrf_token() }}";
    
    // Routes
    const routes = {
        assetUpload: "{{ route('admin.carousels') }}",
        assetDelete: "{{ route('admin.carousels-delete') }}",
        assetUpdate: "{{ route('admin.carousels-update') }}"
    };

    // Module-level variables
    let myDropzone;
    let table;
    let uploadingFileIds = new Set(); // Track file IDs being uploaded

    // Disable auto-discovery
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        initDropzone();
        initDataTable();
        initTooltips();
        initDragAndDrop();
        initStatusHandler();
    });

    function initTooltips() {
        // Re-initialize tooltips after table draw
        $(document).on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $('[data-toggle="tooltip"]').tooltip();
    }

    function initDropzone() {
        myDropzone = new Dropzone("#imageUpload", {
            url: routes.assetUpload,
            addRemoveLinks: true,
            acceptedFiles: "image/*",
            paramName: "banner",
            dictDefaultMessage: "Seret gambar ke sini atau klik untuk upload",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            init: function() {
                // Handle successful upload
                this.on("success", function(file, response) {
                    if (response.id) {
                        // Store the MySQL auto increment ID in the file object
                        file.serverId = response.id;
                        
                        // Add to uploading files set
                        uploadingFileIds.add(response.id);
                        
                        // Reload datatable to show new data
                        if (table) {
                            table.ajax.reload(null, false); // false = stay on current page
                        }
                        
                        Swal.fire({
                            title: "Berhasil",
                            text: "Gambar berhasil diupload",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });

                // Handle upload error
                this.on("error", function(file, errorMessage, xhr) {
                    let message = "Gagal mengupload gambar";
                    
                    if (typeof errorMessage === 'string') {
                        message = errorMessage;
                    } else if (errorMessage.message) {
                        message = errorMessage.message;
                    }
                    
                    Swal.fire({
                        title: "Error",
                        text: message,
                        icon: "error"
                    });
                    
                    // Remove file from dropzone
                    this.removeFile(file);
                });

                // Handle file removal
                this.on("removedfile", function(file) {
                    const id = file.serverId;
                    
                    if (id) {
                        // Remove from tracking set
                        uploadingFileIds.delete(id);
                        
                        sendDelete(id).then(() => {
                            // Reload datatable after successful deletion
                            if (table) {
                                table.ajax.reload(null, false);
                            }
                        });
                    }
                });
            }
        });
    }

    function initDataTable() {
        table = $("#fixed-header-datatable").DataTable({
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
            ajax: "{{ route('admin.carousels') }}",
            columns: [
                {
                    className: "my-column drag-handle",
                    data: "urutan",
                    searchable: false,
                    render: function(data, type, row) {
                        return `<i class="ri-menu-line" style="cursor: move;"></i> ${data}`;
                    }
                },
                {
                    className: "my-column",
                    data: "img_path",
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="banner" style="width: 50px; height: 50px; object-fit: cover;">`;
                    }
                },
                {
                    className: "my-column",
                    data: "status",
                    render: function(data, type, row) {
                        const statusClass = data === 'active' ? 'success' : 'secondary';
                        const statusText = data === 'active' ? 'Aktif' : 'Non-Aktif';
                        return `<span class="badge bg-${statusClass}">${statusText}</span>`;
                    }
                },
                {
                    className: "my-column",
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const isUploading = isFileInDropzone(row.id);
                        const deleteDisabled = isUploading ? 'disabled' : '';
                        const deleteOpacity = isUploading ? 'opacity: 0.5;' : '';
                        
                        return `
                            <div class="btn-group btn-group-sm gap-2" role="group" aria-label="Small button group">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item status-change" href="#" data-id="${row.id}" data-status="active">Aktif</a></li>
                                        <li><a class="dropdown-item status-change" href="#" data-id="${row.id}" data-status="inactive">Non-Aktif</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-danger delete" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="${isUploading ? 'File masih di upload' : 'Hapus Item'}" 
                                    data-id="${row.id}"
                                    ${deleteDisabled}
                                    style="${deleteOpacity}">
                                    <i class="ri-delete-bin-5-line"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            rowId: function(data) {
                return 'row-' + data.id; // Set row ID with prefix
            },
            order: [[0, 'asc']], // Sort by urutan column
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                initTooltips(); // Reinitialize tooltips after draw
            }
        });

        // Delete record handler
        $(document).on('click', '.delete:not([disabled])', function(e) {
            e.preventDefault();
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
                    sendDelete(id).then(() => {
                        table.ajax.reload(null, false);
                    });
                }
            });
        });
    }

    function initDragAndDrop() {
        const tbody = document.querySelector('#fixed-header-datatable tbody');
        
        if (!tbody) return;

        let draggedRow = null;

        // Use event delegation for dynamically created rows
        $(document).on('dragstart', '#fixed-header-datatable tbody tr', function(e) {
            draggedRow = this;
            e.originalEvent.dataTransfer.effectAllowed = 'move';
            $(this).addClass('dragging');
        });

        $(document).on('dragend', '#fixed-header-datatable tbody tr', function(e) {
            $(this).removeClass('dragging');
            draggedRow = null;
        });

        $(document).on('dragover', '#fixed-header-datatable tbody tr', function(e) {
            e.preventDefault();
            e.originalEvent.dataTransfer.dropEffect = 'move';
            
            if (this === draggedRow) return;
            
            const bounding = this.getBoundingClientRect();
            const offset = e.originalEvent.clientY - bounding.top;
            
            if (offset > bounding.height / 2) {
                $(this).after(draggedRow);
            } else {
                $(this).before(draggedRow);
            }
        });

        $(document).on('drop', '#fixed-header-datatable tbody tr', function(e) {
            e.preventDefault();
            updateRowOrder();
        });

        // Make rows draggable
        $(document).on('draw.dt', function() {
            $('#fixed-header-datatable tbody tr').attr('draggable', true);
        });
    }

    function updateRowOrder() {
        const rows = $('#fixed-header-datatable tbody tr').toArray();
        const banners = [];
        
        rows.forEach((row, index) => {
            const rowId = $(row).attr('id');
            if (rowId) {
                const id = parseInt(rowId.replace('row-', ''));
                banners.push({
                    id: id,
                    urutan: index + 1
                });
            }
        });

        if (banners.length === 0) return;

        // Send update request
        $.ajax({
            url: routes.assetUpdate,
            type: 'POST',
            data: {
                _token: csrfToken,
                banners: banners
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Menyimpan...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    title: "Berhasil",
                    text: response.message,
                    icon: response.msg_type,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                table.ajax.reload(null, false);
            },
            error: function(xhr) {
                const response = xhr.responseJSON || {};
                Swal.fire({
                    title: "Gagal",
                    text: response.message || "Terjadi kesalahan saat mengupdate urutan",
                    icon: "error"
                });
                
                // Reload to restore original order
                table.ajax.reload(null, false);
            }
        });
    }

    function initStatusHandler() {
        $(document).on('click', '.status-change', function(e) {
            e.preventDefault();
            
            const id = $(this).data('id');
            const status = $(this).data('status');
            
            $.ajax({
                url: routes.assetUpdate,
                type: 'POST',
                data: {
                    _token: csrfToken,
                    id: id,
                    status: status
                },
                success: function(response) {
                    Swal.fire({
                        title: "Berhasil",
                        text: response.message,
                        icon: response.msg_type,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON || {};
                    Swal.fire({
                        title: "Gagal",
                        text: response.message || "Terjadi kesalahan",
                        icon: "error"
                    });
                }
            });
        });
    }

    function sendDelete(id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: routes.assetDelete,
                type: 'POST',
                data: {
                    _token: csrfToken,
                    id: id
                },
                success: function(response) {
                    Swal.fire({
                        title: response.msg_type === "success" ? "Berhasil" : "Perhatian",
                        text: response.message,
                        icon: response.msg_type,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    resolve(response);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON || {};
                    Swal.fire({
                        title: "Gagal",
                        text: response.message || "Terjadi kesalahan",
                        icon: "error"
                    });
                    reject(xhr);
                }
            });
        });
    }

    function isFileInDropzone(id) {
        // Check if this MySQL ID is currently tracked in uploadingFileIds
        return uploadingFileIds.has(id);
    }

})();
</script>
@endpush