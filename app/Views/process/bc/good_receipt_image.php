<?= $this->extend('shared/layout') ?>

<?= $this->section('content') ?>
<main class="app-main">

    <input type="hidden" id="delivery_number">


    <div class="app-content">
        <div class="container-fluid">

            <div class="card shadow-sm rounded-3 card-table mb-3 mt-3">

                <div id="section-scan-delivery">
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
                        <div class="d-flex justify-content-center">
                            <div id="reader" style="width: 500px;">
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-hover table-custom" id="table_delivery_detail" style="display: none;">
                            <thead>
                                <tr>
                                    <th class="text-center">Material Number</th>
                                    <th class="text-end">Qty Ordered</th>
                                    <th class="text-center">UOM</th>
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
                            <div id="reader-material" style="width: 500px;"></div>
                        </div>
                        <table class="table table-bordered table-striped table-hover table-custom" id="table_material_detail">
                            <thead>
                                <tr>
                                    <th class="text-center">Status</th>
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
</style>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<script>
    let scannedItems = [];

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`, decodedResult);

        let lines = decodedText.trim().split("\n");
        scannedItems = [];
        let isValid = true;

        const formatRegex = /^([^;]+);([^;]+);([^;]+);([^;]+);([^;]+)$/;

        lines.forEach((line, index) => {
            line = line.trim();

            if (!formatRegex.test(line)) {
                isValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid QR Format',
                    html: `Line <b>${index + 1}</b> is not valid:<br><code>${line}</code><br><br>
                   Expected format:<br>
                   <code>DELIVERY;MATERIAL;QTY;UOM;VENDOR</code>`
                });

                html5QrcodeScanner.clear();
                return;
            }

            let parts = line.split(";");

            scannedItems.push({
                delivery_number: parts[0].trim(),
                material: parts[1].trim(),
                qty: parts[2].trim(),
                uom: parts[3].trim(),
                vendor: parts[4].trim()
            });
        });

        if (!isValid) return;

        $("#delivery_number").val(scannedItems[0].delivery_number);
        get_table_delivery_local(scannedItems);
        $("#table_delivery_detail").show();
        $("#input_delivery").hide();
        $("#start_scan_material").prop("disabled", false);

        html5QrcodeScanner.clear();
    }

    function get_table_delivery_local(items) {
        let html = "";
        items.forEach(item => {
            html += `
            <tr>
                <td class="text-center">${item.material}</td>
                <td class="text-end">${item.qty}</td>
                <td class="text-center">${item.uom}</td>
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
            <b>Delivery Number:</b> ${scannedItems[0].delivery_number}<br>
            <b>Vendor:</b> ${scannedItems[0].vendor}
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
                        items: scannedItems
                    },
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
                            $("#section-scan-delivery").hide();
                            $("#section-scan-material").show();
                            get_table_material();
                            check_submit_gr()
                            html5MaterialScanner.render(onMaterialScanSuccess, onMaterialScanError);
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

    function onScanError(errorMessage) {
        console.warn(`QR Code Scan Error: ${errorMessage}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 15,
            qrbox: {
                width: 250,
                height: 250
            }
        },
    );
    html5QrcodeScanner.render(onScanSuccess, onScanError);

    let isScanning = true;

    function onMaterialScanSuccess(decodedText, decodedResult) {
        if (!isScanning) return;
        isScanning = false;
        console.log("Material Scan:", decodedText);
        let line = decodedText.trim();
        const formatRegex = /^([^;]+);([^;]+);([^;]+)$/;
        if (!formatRegex.test(line)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Format',
                html: `Scanned data is invalid:<br>
                   <code>${line}</code><br><br>
                   Expected: <code>MATERIAL;QTY;UOM</code>`
            });
            setTimeout(() => {
                isScanning = true;
            }, 1200);
            return;
        }
        let parts = line.split(";");
        let item = {
            material: parts[0].trim(),
            qty: parts[1].trim(),
            uom: parts[2].trim(),
            delivery_number: $("#delivery_number").val()
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
                setTimeout(() => {
                    isScanning = true;
                }, 1200);
            }
        });
    }

    function onMaterialScanError(errorMessage) {
        console.warn("Material Scan Error:", errorMessage);
    }

    let html5MaterialScanner = new Html5QrcodeScanner(
        "reader-material", {
            fps: 15,
            qrbox: {
                width: 250,
                height: 250
            }
        }
    );

    $(document).ready(function() {
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

    function check_submit_gr() {
        let disable_submit = false;
        $("#table_material_detail_body tr").each(function() {
            let statusText = $(this).find("td:nth-child(1)").text().trim().toUpperCase();
            if (statusText === "OPEN") {
                disable_submit = true;
            }
        });
        $("#submit_gr").prop("disabled", disable_submit);
    }

    // function get_table_delivery() {
    //     const delivery_number = $('#delivery_number').val();
    //     if ($.fn.DataTable.isDataTable('#table_delivery_detail')) {
    //         $('#table_delivery_detail').DataTable().destroy();
    //         $('#table_delivery_detail tbody').empty();
    //     }
    //     $('#table_delivery_detail_body').html(`
    //     <tr id="table_loading">
    //         <td colspan="4" class="text-center py-4">
    //             <div class="spinner-border text-primary" role="status">
    //                 <span class="visually-hidden">Loading...</span>
    //             </div>
    //             <div class="mt-2 fw-bold text-muted">Loading data...</div>
    //         </td>
    //     </tr>
    //     `);
    //     $.ajax({
    //         url: "<?= base_url('process/gr_temp_material_table'); ?>",
    //         type: "GET",
    //         data: {
    //             delivery_number: delivery_number,
    //             type: 'delivery'
    //         },
    //         dataType: "html",
    //         success: function(res) {
    //             $('#table_delivery_detail_body').html(res);
    //             initializeDataTable('table_delivery_detail');
    //             check_submit_gr();
    //         },
    //         error: function(xhr, status, error) {
    //             console.error("AJAX Error:", error);
    //             $('#table_delivery_detail_body').html(`
    //             <tr>
    //                 <td colspan="4" class="text-center text-black p-3">
    //                     Failed to load data. Please try again.
    //                 </td>
    //             </tr>
    //         `);
    //         }
    //     });
    // }

    function get_table_material() {
        const delivery_number = $('#delivery_number').val();
        if ($.fn.DataTable.isDataTable('#table_material_detail')) {
            $('#table_material_detail').DataTable().destroy();
            $('#table_material_detail tbody').empty();
        }
        $('#table_material_detail_body').html(`
        <tr id="table_loading">
            <td colspan="6" class="text-center py-4">
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
                delivery_number: delivery_number,
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
                    <td colspan="6" class="text-center text-black p-3">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
            }
        });
    }

    function get_table_print() {
        const delivery_number = $('#delivery_number').val();
        if ($.fn.DataTable.isDataTable('#table_print')) {
            $('#table_print').DataTable().destroy();
            $('#table_print tbody').empty();
        }
        $('#table_print_detail').html(`
        <tr id="table_loading">
            <td colspan="6" class="text-center py-4">
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
                delivery_number: delivery_number
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
                    <td colspan="6" class="text-center text-black p-3">
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
        const delivery_number = $('#delivery_number').val();
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
                        delivery_number: delivery_number
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
                    get_table_print();
                    $("#section-scan-material").hide();
                    $("#section-print-material").show();
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>