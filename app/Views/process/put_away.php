<?= $this->extend('shared/layout') ?>

<?= $this->section('content') ?>
<?= $this->section('content') ?>
<main class="app-main">
    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm rounded-3 card-table mb-3 mt-3">
                <div id="section-create-header">
                    <div class="card-header text-center custom-card-purple">
                        <h5 class="m-0" style="color:#FFD700;">
                            <i class="fas fas fa-box-open me-2"></i> Putaway
                        </h5>
                    </div>
                    <ul class="nav nav-tabs custom-tabs" id="putawayTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-scan-pallet" data-bs-toggle="tab"
                                data-bs-target="#content-scan-pallet" type="button" role="tab">
                                <i class="fas fa-pallet me-1"></i> Scan Pallet
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-scan-material" data-bs-toggle="tab"
                                data-bs-target="#content-scan-material" type="button" role="tab">
                                <i class="fas fa-barcode me-1"></i> Scan Material
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="content-scan-pallet" role="tabpanel">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <input type="text" id="scan_pallet_input" class="form-control"
                                        placeholder="Scan Pallet Here" autofocus>
                                </div>

                                <hr>

                                <div id="material_list" style="display: none;">
                                    <h5 class="fw-bold mb-3">Material List</h5>
                                    <table class="table table-bordered table-hover table-custom" id="table_delivery_detail">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Delivery</th>
                                                <th class="text-center">Material</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_delivery_detail_body"></tbody>
                                    </table>
                                    <div class="row mt-3 align-items-center">
                                        <div class="col-auto d-flex align-items-center">
                                            <span class="legend-box me-1" style="background:#ff7a87ff;"></span> Open
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <span class="legend-box me-1" style="background:#ffd36b;"></span> Partial
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <span class="legend-box me-1" style="background:#9ee6a0;"></span> Complete
                                        </div>
                                        <div class="col-auto text-muted">
                                            | Qty: <code>remaining / received</code>
                                        </div>
                                    </div>
                                    <div class="mt-3 p-3 rounded" style="border: 3px solid;">
                                        <label class="form-label fw-bold mb-2">Scan Storage QR</label>

                                        <input type="text" id="scan_storage_input"
                                            class="form-control form-control mb-3"
                                            placeholder="Scan here..." autofocus>

                                        <div id="scan_result" class="d-none">
                                            <div class="alert alert-info py-2 px-3 mb-0 fw-bold">
                                                <strong>Scanned Storage:</strong>
                                                <span id="scan_rack" class="ms-2 me-3"></span>
                                                <span id="scan_bin"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="content-scan-material" role="tabpanel">
                            <div id="putaway_section" style="display: none;">
                                <div class=" card-body">
                                    <div class="d-flex justify-content-center mb-3">
                                        <input type="text" id="scan_material_input" class="form-control"
                                            placeholder="Scan Material Here">
                                    </div>

                                    <div id="material_putaway_table_area">
                                        <h5 class="fw-bold mb-3">Putaway Details</h5>
                                        <table class="table table-bordered table-hover table-custom" id="table_putaway_detail">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Material</th>
                                                    <th class="text-center">From</th>
                                                    <th class="text-center">To Rack</th>
                                                    <th class="text-center">To Bin</th>
                                                    <th class="text-center">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_putaway_detail_body"></tbody>
                                        </table>
                                        <div class="row mt-3 align-items-center">
                                            <div class="col-auto d-flex align-items-center">
                                                <span class="legend-box me-1" style="background:#ffd36b;"></span> Validating
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <span class="legend-box me-1" style="background:#9ee6a0;"></span> Stored
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-3">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-success px-4" onclick="open_confirm_store()">
                                            <i class="fas fa-check-circle"></i> Confirm Store
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="confirm_store_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-barcode me-1"></i> Scan Rack to Confirm
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="submit_store">
                <div class="modal-body">
                    <p class="text-muted small">
                        Please scan the <strong>Rack QR</strong> of the location you selected.
                    </p>

                    <input type="text" id="scan_storage_confirm" class="form-control"
                        placeholder="Scan Rack ID Here" autofocus name="scan_storage_confirm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="store_submit_button" class="btn btn-success" disabled>
                        <i class="fas fa-check"></i> Submit Store
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<style>
    .custom-tabs .nav-link {
        color: #5f0188;
        font-weight: 500;
        text-align: center;
        transition: all 0.2s ease-in-out;
        font-size: medium;
    }

    .custom-tabs .nav-link:hover {
        background-color: #fff;
        color: #5f0188;
    }

    .custom-tabs .nav-link.active {
        color: #5f0188;
        background-color: #fff;
        border-bottom: 3px solid #5f0188;
        font-weight: 600;
    }

    table.dataTable tbody tr.table-open td {
        background-color: #ff7a87ff !important;
    }

    table.dataTable tbody tr.table-partial td {
        background-color: #ffd36b !important;
    }

    table.dataTable tbody tr.table-complete td {
        background-color: #9ee6a0 !important;
    }

    .legend-box {
        width: 16px;
        height: 16px;
        border-radius: 3px;
        display: inline-block;
        border: 1px solid #999;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<script>
    $("#submit_store").on("submit", function(e) {
        e.preventDefault();

        let dataForm = new FormData(this);
        dataForm.append("rackValue", rackValue);
        dataForm.append("binValue", binValue);
        dataForm.append("expectedQR", expectedQR);
        dataForm.append("putaway_detail_ids", JSON.stringify(window.putaway_detail_ids));
        for (const pair of dataForm.entries()) {
            console.log(`${pair[0]}: ${pair[1]}`);
        }
        Swal.fire({
            title: "Are you sure?",
            text: "Submit this putaway?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('process/submit_putaway') ?>",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    dataType: "json"
                }).then((res) => {
                    if (!res.status) {
                        throw new Error(res.message);
                    }
                    return res;
                }).catch((error) => {
                    Swal.showValidationMessage(
                        `Request failed: ${error.message || error}`
                    );
                });

            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.value.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    $("#confirm_store_modal").modal("hide");
                    if (window.palletItem) {
                        get_pallet_delivery(window.palletItem);
                    }
                    get_putaway_detail();
                });

            }
        });
    });

    function palletScan(decodedText) {
        console.log("Pallet Scan:", decodedText);

        let line = decodedText.trim();

        const formatRegex = /^([^;]+);([^;]+);$/;
        if (!formatRegex.test(line)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Format',
                html: `Scanned data is invalid:<br>
                   <code>${line}</code><br><br>
                   Expected: <code>invoice_no;vendor;</code>`
            });

            $("#scan_pallet_input").val('').focus();
            return;
        }
        let parts = line.split(";");
        let item = {
            invoice_no: parts[0].trim(),
            vendor: parts[1].trim(),
        };

        window.invoice_no = item.invoice_no;
        window.palletItem = item;

        get_pallet_delivery(item);
        get_putaway_detail()
    }

    function processMaterialScan(decodedText) {
        console.log("Material Scan:", decodedText);

        let line = decodedText.trim();

        const formatRegex = /^([^;]+);([^;]+);([^;]+);([^;]+);$/;
        if (!formatRegex.test(line)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Format',
                html: `Scanned data is invalid:<br>
                   <code>${line}</code><br><br>
                   Expected: <code>delivery_number;material_number;qty_order;uom;</code>`
            });

            $("#scan_material_input").val('').focus();
            return;
        }
        let parts = line.split(";");
        let item = {
            delivery: parts[0].trim(),
            material: parts[1].trim(),
            qty: parts[2].trim(),
            uom: parts[3].trim(),
            invoice_no: window.invoice_no
        };
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => Swal.showLoading()
        });
        $.ajax({
            url: "<?= base_url('process/scan_putaway_detail'); ?>",
            type: "POST",
            data: item,
            dataType: "json",
            success: function(res) {
                Swal.close();

                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    get_putaway_detail();
                    if (window.palletItem) {
                        get_pallet_delivery(window.palletItem);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Request Failed',
                    text: error
                });
            },
            complete: function() {
                $("#scan_material_input").val('').focus();
            }
        });
    }

    $(document).ready(function() {

        $(document).on('keypress', '#scan_pallet_input', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                const scannedText = $(this).val().trim();
                if (scannedText) {
                    palletScan(scannedText);
                }
            }
        });

        $(document).on('keypress', '#scan_material_input', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                const scannedText = $(this).val().trim();
                if (scannedText) {
                    processMaterialScan(scannedText);
                }
            }
        });
    });

    let rackValue = "";
    let binValue = "";
    let expectedQR = "";

    $("#scan_storage_input").on("keyup", function(e) {
        if (e.key === "Enter") {
            let scanned = $(this).val().trim();
            $(this).val("");
            let parts = scanned.split("|");
            if (parts.length !== 3 || parts[0] !== "STORAGE") {
                Swal.fire({
                    icon: "error",
                    title: "Invalid QR",
                    text: "Format must be STORAGE|RACK|BIN."
                });
                return;
            }
            $.ajax({
                url: "<?= base_url('process/check_location') ?>",
                type: "POST",
                data: {
                    location_code: scanned
                },
                dataType: "json",
                success: function(res) {
                    if (!res.status) {
                        Swal.fire({
                            icon: "error",
                            title: "Invalid Location",
                            text: res.message
                        });
                        return;
                    }
                    $("#putaway_section").show();
                    rackValue = parts[1];
                    binValue = parts[2];
                    expectedQR = scanned;
                    $("#scan_rack").text("Rack: " + rackValue);
                    $("#scan_bin").text("Bin: " + binValue);
                    $("#scan_result").removeClass("d-none");
                }
            });
        }
    });

    function open_confirm_store() {
        if (!expectedQR) {
            Swal.fire({
                icon: "warning",
                title: "Scan Required",
                text: "Please scan storage QR first."
            });
            return;
        }

        $("#scan_storage_confirm").val("");
        $("#store_submit_button").prop("disabled", true);

        $("#confirm_store_modal").modal("show");
    }

    $("#scan_storage_confirm").on("keyup", function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const scannedText = $(this).val().trim();
            if (!scannedText) return;
            if (scannedText !== expectedQR) {
                Swal.fire({
                    icon: "error",
                    title: "Mismatch",
                    html: `
                    Scanned: <code>${scannedText}</code><br>
                    Expected: <code>${expectedQR}</code>
                `
                });
                $("#store_submit_button").prop("disabled", true);
                $(this).val("").focus();
                return;
            }
            $("#store_submit_button").prop("disabled", false);
            Swal.fire({
                icon: "success",
                title: "Rack Verified",
                text: "You scanned the correct storage location!",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });

    function get_pallet_delivery(item) {
        $("#material_list").show();

        if ($.fn.DataTable.isDataTable('#table_delivery_detail')) {
            $('#table_delivery_detail').DataTable().destroy();
            $('#table_delivery_detail tbody').empty();
        }
        $('#table_delivery_detail_body').html(`
        <tr id="table_loading">
            <td colspan="4" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('process/putaway_pallet_table'); ?>",
            type: "GET",
            data: item,
            dataType: "html",
            success: function(res) {
                $('#table_delivery_detail_body').html(res);
                initializeDataTable('table_delivery_detail');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#table_delivery_detail_body').html(`
                <tr>
                    <td colspan="4" class="text-center text-black p-3">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
            },
            complete: function() {
                // $("#scan_pallet_input").val('').focus();
            }
        });
    }

    function get_putaway_detail() {
        if ($.fn.DataTable.isDataTable('#table_putaway_detail')) {
            $('#table_putaway_detail').DataTable().destroy();
            $('#table_putaway_detail tbody').empty();
        }
        $('#table_putaway_detail_body').html(`
        <tr id="table_loading">
            <td colspan="5" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('process/putaway_material_table'); ?>",
            type: "GET",
            data: {
                invoice_no: window.invoice_no
            },
            dataType: "json",
            success: function(res) {
                $('#table_putaway_detail_body').html(res.html);
                initializeDataTable('table_putaway_detail');
                window.putaway_detail_ids = res.ids;
                console.log("Putaway Detail IDs:", window.putaway_detail_ids);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#table_putaway_detail_body').html(`
                <tr>
                    <td colspan="5" class="text-center text-black p-3">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
            },
            complete: function() {
                // $("#scan_pallet_input").val('').focus();
            }
        });
    }

    function initializeDataTable(tableId) {
        let table = $('#' + tableId);
        // $('#' + tableId + ' thead tr.search-row').remove();

        // $('#' + tableId + ' thead tr')
        //     .clone(true)
        //     .addClass('search-row')
        //     .appendTo('#' + tableId + ' thead');

        // $('#' + tableId + ' thead tr.search-row th').each(function(index) {
        //     if (index === 6) {
        //         $(this).html('');
        //     } else {
        //         $(this).html('<input type="text" placeholder="Search" class="form-control form-control-sm" />');
        //     }
        // });

        let datatable = table.DataTable({
            pageLength: 10,
            lengthChange: true,
            searching: true,
            ordering: true,
            scrollX: true,
            orderCellsTop: true,
            fixedHeader: true,
            // initComplete: function() {
            //     var api = this.api();
            //     api.columns().every(function(colIdx) {
            //         $('input', $('.search-row th').eq(colIdx)).on('keyup change clear', function() {
            //             api.column(colIdx).search(this.value).draw();
            //         });
            //     });
            // }
        });
    }
</script>
<?= $this->endSection() ?>