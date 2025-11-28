<?= $this->extend('shared/layout') ?>

<?= $this->section('content') ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-stretch g-2">

                <div class="col-md-3">
                    <div class="card h-100 custom-card-breadcrumb custom-card-slim d-flex align-items-left justify-content-center">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url("home/index"); ?>">Summary</a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card h-100 custom-card-purple custom-card-slim card-button">
                        <div class="h-100 d-flex justify-content-end align-items-center gap-2 flex-wrap">

                            <button class="btn btn-success btn-sm btn-split" data-bs-toggle="modal" data-bs-target="#upload_modal">
                                <span class="btn-icon"><i class="fa fa-upload"></i></span>
                                <span class="btn-text"><strong>Upload Excel</strong></span>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm rounded-3 custom-card-purple card-table">

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-custom" id="table_header">
                            <thead>
                                <tr>
                                    <th class="text-center">Order Number</th>
                                    <th class="text-center">SA FG</th>
                                    <th class="text-center">Order Qty</th>
                                    <th class="text-center">Plant</th>
                                    <th class="text-center">Line</th>
                                    <th class="text-center">Cell Name</th>
                                    <th class="text-center">Picking Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_header_body"></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end::App Content-->
</main>

<div class="modal fade" id="upload_modal" tabindex="-1" aria-labelledby="upload_modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title" id="upload_modalLabel"><i class="fas fa-file-upload me-2"></i>Upload Excel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_upload" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-center justify-content-center border-end">
                            <div class="text-center">
                                <p><strong>Download Template Excel</strong></p>
                                <a href="<?= base_url('assets/template/picking_template.xlsx') ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <p><strong>Upload Excel File</strong></p>
                                <input class="form-control" type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload me-1"></i> Uplod Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<script>
    $('#upload_modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.error, .invalid-feedback').remove();
        $(this).find('.is-invalid').removeClass('is-invalid');
    });

    $(document).ready(function() {
        get_table();

        $(document).on('click', '.edit-btn', function() {

        });

    });

    function get_table() {
        if ($.fn.DataTable.isDataTable('#table_header')) {
            $('#table_header').DataTable().destroy();
            $('#table_header tbody').empty();
        }

        $('#table_header_body').html(`
            <tr id="table_loading">
                <td colspan="9" class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                    <div class="mt-2 fw-bold text-muted">Loading data...</div>
                </td>
            </tr>
        `);

        $.ajax({
            url: "<?= base_url('picking/picking_header_table'); ?>",
            type: "GET",
            dataType: "html",
            success: function(res) {
                $('#table_header_body').html(res);
                initializeDataTable('table_header');
            },
            error: function() {
                $('#table_header_body').html(`
                    <tr>
                        <td colspan="9" class="text-center text-danger p-3">
                            Failed to load data. Please try again.
                        </td>
                    </tr>
                `);
            }
        });
    }

    function initializeDataTable(tableId) {
        let table = $('#' + tableId);
        $('#' + tableId + ' thead tr.search-row').remove();

        $('#' + tableId + ' thead tr')
            .clone(true)
            .addClass('search-row')
            .appendTo('#' + tableId + ' thead');

        $('#' + tableId + ' thead tr.search-row th').each(function(index) {
            if (index === 8) {
                $(this).html('');
            } else {
                $(this).html('<input type="text" placeholder="Search" class="form-control form-control-sm" />');
            }
        });

        let datatable = table.DataTable({
            pageLength: 10,
            lengthChange: true,
            searching: true,
            ordering: true,
            scrollX: true,
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function() {
                var api = this.api();
                api.columns().every(function(colIdx) {
                    $('input', $('.search-row th').eq(colIdx)).on('keyup change', function() {
                        api.column(colIdx).search(this.value).draw();
                    });
                });
            }
        });
    }

    $("#form_upload").on("submit", function(e) {
        e.preventDefault();

        let dataForm = new FormData(this);
        Swal.fire({
            title: "Are you sure?",
            text: "Upload this Picking Excel?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!"
        }).then((result) => {
            if (!result.isConfirmed) return;
            Swal.fire({
                title: 'Processing...',
                html: 'Please wait a moment.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "<?= base_url('picking/importExcel'); ?>",
                type: "POST",
                data: dataForm,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(res) {
                    Swal.close();
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message
                        }).then(() => {
                            $('#upload_modal').modal('hide');
                            get_table();
                        });
                    } else if (res.is_validation) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: res.message,
                            width: '700px'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: res.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    Swal.fire('Error', 'Something went wrong: ' + error, 'error');
                }
            });
        });
    });

    function updateStatus(id, newStatus) {
        Swal.fire({
            title: "Are you sure?",
            text: "Change status to " + newStatus + "?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change it!"
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "<?= base_url('picking/updateStatus'); ?>",
                type: "POST",
                data: {
                    id: id,
                    status: newStatus
                },
                dataType: "json",
                success: function(res) {
                    if (res.status) {
                        Swal.fire("Success", res.message, "success");
                        $("#table_header_body").load("<?= base_url('picking/picking_header_table'); ?>");
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                }
            });
        });
    }
</script>
<?= $this->endSection() ?>