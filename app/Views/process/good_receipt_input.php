<?= $this->extend('shared/layout') ?>

<?= $this->section('content') ?>
<main class="app-main">

    <input type="hidden" id="delivery_number">


    <div class="app-content">
        <div class="container-fluid">

            <div class="card shadow-sm rounded-3 card-table mb-3 mt-3">

                <div id="section-create-header">
                    <div class="card-header text-center custom-card-purple">
                        <h5 class="m-0" style="color:#FFD700;">
                            <i class="fas fa-file-invoice me-2"></i> Create New GR
                        </h5>
                    </div>

                    <ul class="nav nav-tabs custom-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" type="button" role="tab">
                                <i class="fas fa-file-invoice me-1"></i> GR Header
                            </button>
                        </li>
                    </ul>
                    <form id="create_gr">
                        <div class="card-body">
                            <div class="row g-2 mb-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Document Date</label>
                                    <input type="date" name="gr_date" id="date_doc" class="form-control" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Lorry Date</label>
                                    <input type="date" name="lorry_date" id="lorry_date" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Type</label>
                                    <select name="type" id="delivery_type" class="form-control" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="NORMAL">NORMAL</option>
                                        <option value="URGENT">URGENT</option>
                                        <option value="RETURN">RETURN</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Invoice No</label>
                                    <input type="text" name="invoice_no" id="invoice_no" class="form-control" placeholder="Enter Invoice Number" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Vendor</label>
                                    <input type="text" name="vendor" id="vendor" class="form-control" placeholder="Enter Vendor" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="<?= auth()->user()->username; ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" id="start_scan_delivery">
                                <i class="fas fa-check"></i> Create GR
                            </button>
                        </div>
                    </form>
                </div>

                <div id="section-scan-delivery" style="display:none">
                    <div class="card-header text-center custom-card-purple">
                        <h5 class="m-0" style="color:#FFD700;">
                            <i class="fas fa-file-invoice me-2"></i> Scan Delivery QR
                        </h5>
                    </div>
                    <ul class="nav nav-tabs custom-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" type="button" role="tab">
                                <i class="fas fa-file-invoice me-1"></i> Scan DO
                            </button>
                        </li>
                    </ul>

                    <div class="card-body">
                        <div class="d-flex justify-content-center" id="input_delivery">
                            <div style="width: 500px;">
                                <textarea id="scanner-input" class="form-control" rows="4" placeholder="Scan Delivery Here" autofocus></textarea>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover table-custom" id="table_delivery_detail" style="display: none;">
                            <thead>
                                <tr>
                                    <th class="text-center">Delivery Number</th>
                                    <th class="text-center">Material Number</th>
                                    <th class="text-end">Qty Ordered</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Shipment ID</th>
                                    <th class="text-center">Customer PO</th>
                                    <th class="text-center">PO Line</th>
                                </tr>
                            </thead>
                            <tbody id="table_delivery_detail_body">
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-secondary" id="start_scan_material" disabled>
                            <i class=""></i> Next
                        </button>
                    </div>
                </div>

                <div id="section-scan-material" style="display:none">
                    <div class="card-header text-center custom-card-purple">
                        <h5 class="m-0" style="color:#FFD700;">
                            <i class="fas fa-box-open me-2"></i> Scan Material QR
                        </h5>
                    </div>
                    <ul class="nav nav-tabs custom-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" type="button" role="tab">
                                <i class="fas fa-box-open me-1"></i> Scan Material
                            </button>
                        </li>
                    </ul>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <input type="text" id="material-input" class="form-control" placeholder="Scan Material Here" autofocus>
                        </div>
                        <table class="table table-bordered table-hover table-custom" id="table_material_detail">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">Delivery Number</th>
                                    <th class="text-center">Material Number</th>
                                    <th class="text-center">Material Description</th>
                                    <th class="text-end">Qty Ordered</th>
                                    <th class="text-end">Qty Received</th>
                                    <th class="text-center">UOM</th>
                                </tr>
                            </thead>
                            <tbody id="table_material_detail_body">

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success" id="submit_gr">
                            <i class="fas fa-save me-2"></i> Submit GR
                        </button>
                    </div>
                </div>

                <div id="section-print-material" style="display:none">
                    <div class="card-header text-center custom-card-purple">
                        <h5 class="m-0" style="color:#FFD700;">
                            <i class="fas fa-print me-2"></i> Print Material QR
                        </h5>
                    </div>
                    <ul class="nav nav-tabs custom-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" type="button" role="tab">
                                <i class="fas fa-print me-1"></i> Print Material
                            </button>
                        </li>
                    </ul>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover table-custom" id="table_print">
                            <thead>
                                <tr>
                                    <th class="text-center">Delivery Number</th>
                                    <th class="text-center">Material Number</th>
                                    <th class="text-center">Material Description</th>
                                    <th class="text-end">Qty Ordered</th>
                                    <th class="text-end">Qty Received</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_print_detail">

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" onclick="print_pallet_id()">
                            <i class="fas fa-print me-1"></i> Print Pallet Label
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>

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
</style>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<script>
    $("#create_gr").on("submit", function(e) {
        e.preventDefault();

        let dataForm = new FormData(this);

        Swal.fire({
            title: "Are you sure?",
            text: "Create this GR Header?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {

                return $.ajax({
                    url: "<?= base_url('process/create_temp_gr_header') ?>",
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
                console.log(result.value)

                window.temp_gr_id = result.value.temp_gr_id;
                window.invoice_no = result.value.invoice_no;
                window.vendor = result.value.vendor;

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.value.message,
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    $("#section-create-header").hide();
                    $("#section-scan-delivery").show();
                });

            }
        });
    });

    let scannedItems = [];

    function processScannedData(decodedText) {
        console.log(`Scan result raw:`, decodedText);

        decodedText = decodedText.trim();

        let lines = decodedText.split(";")
            .map(x => x.trim())
            .filter(x => x !== "");

        console.log("After cleaning:", lines);

        if (lines.length % 7 !== 0) {
            let expectedFormat =
                "delivery_number;material_number;qty_order;uom;shipment_id;customer_po;customer_po_line";

            Swal.fire({
                icon: 'error',
                title: 'Invalid Scan Format',
                html: `
                <b>Your scanned data is incorrect.</b><br><br>
                <b>Expected 7 fields per item:</b><br>
                <code>${expectedFormat}</code><br><br>

                <b>Example:</b><br>
                <code>DEL-0011;MAT-1001;10;PCS;SHIP001;PO12345;10</code><br><br>

                <b>But your scan contains:</b><br>
                <code>${decodedText}</code>`
            });
            return;
        }

        // scannedItems = [];
        for (let i = 0; i < lines.length; i += 7) {
            scannedItems.push({
                delivery_number: lines[i],
                material_number: lines[i + 1],
                qty_order: lines[i + 2],
                uom: lines[i + 3],
                shipment_id: lines[i + 4],
                customer_po: lines[i + 5],
                customer_po_line: lines[i + 6]
            });
        }

        console.log("Parsed items:", scannedItems);
        get_table_delivery_local(scannedItems);
        $("#table_delivery_detail").show();
        $("#input_delivery").hide();
        $("#start_scan_material").prop("disabled", false);
        $("#scanner-input").val('');
    }


    function get_table_delivery_local(items) {
        let html = "";

        items.forEach(item => {
            html += `
            <tr>
                <td class="text-center">${item.delivery_number}</td>
                <td class="text-center">${item.material_number}</td>
                <td class="text-end">${item.qty_order}</td>
                <td class="text-center">${item.uom}</td>
                <td class="text-center">${item.shipment_id}</td>
                <td class="text-center">${item.customer_po}</td>
                <td class="text-center">${item.customer_po_line}</td>
            </tr>
        `;
        });
        let table = $('#table_delivery_detail').DataTable();
        table.clear().destroy();
        $("#table_delivery_detail_body").html(html);
        $('#table_delivery_detail').DataTable();
    }

    $("#start_scan_material").click(function() {
        if (scannedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Data',
                text: 'Please scan delivery number first.'
            });
            return;
        }

        Swal.fire({
            title: 'Proceed to Material Validation?',
            html: `
        You scanned <b>${scannedItems.length}</b> item(s).<br><br>
        <div class="text-center">
            <b>Invoice Number:</b> ${window.invoice_no}<br>
            <b>Vendor:</b> ${window.vendor}
        </div>
    `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, continue',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "<?= base_url('process/scan_delivery_number'); ?>",
                    type: "POST",
                    data: {
                        items: scannedItems,
                        temp_gr_id: window.temp_gr_id,
                        invoice_no: window.invoice_no
                    },
                    dataType: "json",
                    success: function(res) {
                        Swal.close();

                        if (res.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                                timer: 3000,
                                showConfirmButton: false
                            });

                            $("#section-scan-delivery").hide();
                            $("#section-scan-material").show();
                            get_table_material();
                            check_submit_gr()
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
                    }
                });

            }
        });
    });

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

            $("#material-input").val('').focus();
            return;
        }
        let parts = line.split(";");
        let item = {
            delivery: parts[0].trim(),
            material: parts[1].trim(),
            qty: parts[2].trim(),
            uom: parts[3].trim(),
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
            url: "<?= base_url('process/scan_material'); ?>",
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
                        timer: 1000,
                        showConfirmButton: false
                    });
                    get_table_material();
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
                $("#material-input").val('').focus();
            }
        });
    }

    $(document).ready(function() {
        let today = new Date().toISOString().split("T")[0];
        $("#date_doc").val(today);
        $("#lorry_date").val(today);
        $(document).on('click', '#process-scan', function() {
            const scannedText = $("#scanner-input").val().trim();
            if (scannedText) {
                processScannedData(scannedText);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Data',
                    text: 'Please scan something first.'
                });
            }
        });
        $(document).on('keypress', '#scanner-input', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                const scannedText = $(this).val().trim();
                if (scannedText) {
                    processScannedData(scannedText);
                }
            }
        });


        $(document).on('click', '#process-material-scan', function() {
            const scannedText = $("#material-input").val().trim();
            if (scannedText) {
                processMaterialScan(scannedText);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Data',
                    text: 'Please scan something first.'
                });
            }
        });
        $(document).on('keypress', '#material-input', function(e) {
            if (e.which === 13) {
                e.preventDefault();

                const scannedText = $(this).val().trim();
                if (scannedText) {
                    processMaterialScan(scannedText);
                }
            }
        });

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Delete this Material!!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Confirm!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('process/delete_temp_detail') ?>",
                        type: "POST",
                        data: {
                            id: id
                        },
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
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        get_table_material();
                    });
                }
            });
        });

        $(document).on("click", ".print-label-btn", function() {
            let delivery = $(this).data("delivery");
            let material = $(this).data("material");
            let qty = $(this).data("qty");
            let uom = $(this).data("uom");

            Swal.fire({
                title: "Print Label?",
                html: `
            <div class="text-center">
                <b>Delivery:</b> ${delivery}<br>
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
                        "<?= base_url('process/gr_detail_label') ?>?material=" + material + "&qty=" + qty + "&uom=" + uom + "&delivery=" + delivery,
                        "_blank"
                    );
                }
            });
        });

    });

    function check_submit_gr() {
        let disable_submit = false;
        $("#table_material_detail_body tr").each(function() {
            if ($(this).hasClass("table-open")) {
                disable_submit = true;
            }
        });
        $("#submit_gr").prop("disabled", disable_submit);
    }

    function get_table_material() {

        if ($.fn.DataTable.isDataTable('#table_material_detail')) {
            $('#table_material_detail').DataTable().destroy();
            $('#table_material_detail tbody').empty();
        }
        $('#table_material_detail_body').html(`
        <tr id="table_loading">
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('process/gr_temp_material_table'); ?>",
            type: "GET",
            data: {
                temp_gr_id: window.temp_gr_id,
                type: 'material'
            },
            dataType: "html",
            success: function(res) {
                $('#table_material_detail_body').html(res);
                initializeDataTable('table_material_detail');
                check_submit_gr();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#table_material_detail_body').html(`
                <tr>
                    <td colspan="7" class="text-center text-black p-3">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
            }
        });
    }

    function get_table_print() {
        if ($.fn.DataTable.isDataTable('#table_print')) {
            $('#table_print').DataTable().destroy();
            $('#table_print tbody').empty();
        }
        $('#table_print_detail').html(`
        <tr id="table_loading">
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('process/gr_print_detail'); ?>",
            type: "GET",
            data: {
                invoice_no: window.invoice_no,
            },
            dataType: "html",
            success: function(res) {
                $('#table_print_detail').html(res);
                initializeDataTable('table_print');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#table_print_detail').html(`
                <tr>
                    <td colspan="7" class="text-center text-black p-3">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
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

    $("#submit_gr").on("click", function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Submit this Request",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('process/submit_gr') ?>",
                    type: "POST",
                    data: {
                        temp_gr_id: window.temp_gr_id,
                    },
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
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    get_table_print();
                    $("#section-scan-material").hide();
                    $("#section-print-material").show();
                    print_pallet_id();
                });
            }
        });
    });

    function print_pallet_id() {
        window.open(
            "<?= base_url('process/print_pallet_id') ?>?invoice_no=" + window.invoice_no + "&vendor=" + window.vendor,
            "_blank"
        );
    }
</script>
<?= $this->endSection() ?>