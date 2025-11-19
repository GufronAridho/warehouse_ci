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

                            <button class="btn btn-split btn-info btn-sm" id="download_excel">
                                <span class="btn-icon"><i class="fa fa-file-excel"></i></span>
                                <span class="btn-text"><strong>Download</strong></span>
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
                    <table class="table table-bordered table-striped table-hover table-custom" id="table_header">
                        <thead>
                            <tr>
                                <th class="text-center">Delivery No</th>
                                <th class="text-center">Vendor</th>
                                <th class="text-center">GR Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Received By</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_header_body"></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!--end::App Content-->
</main>

<div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="edit_modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    GR Detail — Delivery: <span id="modal_delivery_number"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-custom" id="table_detail">
                    <thead>
                        <tr>
                            <th class="text-center">Material Number</th>
                            <th class="text-center">Qty Received</th>
                            <th class="text-center">Qty Ordered</th>
                            <th class="text-center">Qty Remaining</th>
                            <th class="text-center">UOM</th>
                            <th class="text-center">Staging Location</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_detail_body"></tbody>
                </table>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        get_table();
        $(document).on('click', '.edit-btn', function() {

            const gr_id = $(this).data('gr_id');
            const delivery_number = $(this).data('delivery_number');
            $('#modal_delivery_number').text(delivery_number);

            $('#edit_modal').modal('show');

            if ($.fn.DataTable.isDataTable('#table_detail')) {
                $('#table_detail').DataTable().destroy();
                $('#table_detail tbody').empty();
            }

            $('#table_detail_body').html(`
            <tr id="table_loading">
                <td colspan="8" class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                    <div class="mt-2 fw-bold text-muted">Loading data...</div>
                </td>
            </tr>
        `);

            $.ajax({
                url: "<?= base_url('summary/gr_detail'); ?>",
                type: "GET",
                data: {
                    gr_id,
                    delivery_number
                },
                dataType: "html",
                success: function(res) {
                    $('#table_detail_body').html(res);
                    initializeDataTable('table_detail');
                },
                error: function() {
                    $('#table_detail_body').html(`
                    <tr>
                        <td colspan="8" class="text-center text-danger p-3">
                            Failed to load data. Please try again.
                        </td>
                    </tr>
                `);
                }
            });

        });

        $(document).on("click", ".print-label-btn", function() {
            let material = $(this).data("material");
            let qty = $(this).data("qty");
            let uom = $(this).data("uom");

            Swal.fire({
                title: "Print Label?",
                html: `
            <div class="text-center">
                <b>Material:</b> ${material}<br>
                <b>Qty:</b> ${qty}<br>
                <b>UOM:</b> ${uom}
            </div>
        `,
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Print",
            }).then((res) => {
                if (res.isConfirmed) {
                    window.open(
                        "<?= base_url('process/gr_detail_label') ?>?material=" + material + "&qty=" + qty + "&uom=" + uom,
                        "_blank"
                    );
                }
            });
        });
    });

    function get_table() {
        if ($.fn.DataTable.isDataTable('#table_header')) {
            $('#table_header').DataTable().destroy();
            $('#table_header tbody').empty();
        }

        $('#table_header_body').html(`
            <tr id="table_loading">
                <td colspan="6" class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                    <div class="mt-2 fw-bold text-muted">Loading data...</div>
                </td>
            </tr>
        `);

        $.ajax({
            url: "<?= base_url('summary/gr_header'); ?>",
            type: "GET",
            dataType: "html",
            success: function(res) {
                $('#table_header_body').html(res);
                initializeDataTable('table_header');
            },
            error: function() {
                $('#table_header_body').html(`
                    <tr>
                        <td colspan="6" class="text-center text-danger p-3">
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
            if (tableId == 'table_header') {
                if (index === 5) {
                    $(this).html('');
                } else {
                    $(this).html('<input type="text" placeholder="Search" class="form-control form-control-sm" />');
                }
            } else {
                if (index === 7) {
                    $(this).html('');
                } else {
                    $(this).html('<input type="text" placeholder="Search" class="form-control form-control-sm" />');
                }
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
            buttons: [{
                extend: 'excelHtml5',
                text: '',
                filename: 'GR_Header_Summary_' + new Date().toISOString().slice(0, 10),
                exportOptions: {
                    columns: ':visible'
                }
            }],
            initComplete: function() {
                var api = this.api();
                api.columns().every(function(colIdx) {
                    $('input', $('.search-row th').eq(colIdx)).on('keyup change', function() {
                        api.column(colIdx).search(this.value).draw();
                    });
                });
            }
        });

        $('#download_excel').off('click').on('click', function() {
            datatable.button('.buttons-excel').trigger();
        });
    }
</script>
<?= $this->endSection() ?>