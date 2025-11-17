<?= $this->extend('shared/layout') ?>

<?= $this->section('content') ?>
<main class="app-main">
    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm rounded-3 card-table mb-2 mt-2">
                <div class="card-header text-center custom-card-purple">
                    <h5 class="m-0" style="color:#FFD700;">
                        <i class="fas fa-truck-loading me-2"></i> GR Request
                    </h5>
                </div>
                <form id="submit_gr">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="form-floating flex-grow-1">
                                        <input type="text"
                                            class="form-control "
                                            id="delivery_number"
                                            name="delivery_number"
                                            placeholder="Delivery Number"
                                            required>
                                        <label for="delivery_number">Delivery Number</label>
                                    </div>
                                    <div class="input-group-text ">
                                        <i class="fas fa-truck text-purple"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="form-floating flex-grow-1">
                                        <input type="text"
                                            class="form-control "
                                            id="vendor"
                                            name="vendor"
                                            placeholder="Vendor"
                                            required>
                                        <label for="vendor">Vendor</label>
                                    </div>
                                    <div class="input-group-text ">
                                        <i class="fas fa-industry text-purple"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="form-floating flex-grow-1">
                                        <input type="date"
                                            class="form-control "
                                            id="gr_date"
                                            name="gr_date"
                                            placeholder="GR Date"
                                            required>
                                        <label for="gr_date">GR Date</label>
                                    </div>
                                    <div class="input-group-text ">
                                        <i class="fas fa-calendar-day text-purple"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="form-floating flex-grow-1">
                                        <select class="form-select"
                                            id="material_number"
                                            name="material_number">
                                        </select>
                                    </div>
                                    <div class="input-group-text ">
                                        <i class="fas fa-cubes text-purple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover table-custom" id="table_detail">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Material Number</th>
                                    <th class="text-center">Material Description</th>
                                    <th class="text-end">Qty Ordered</th>
                                    <th class="text-end">Qty Received</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_detail_body">

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Submit GR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::App Content-->
</main>

<!-- Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="add_modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-boxes me-2"></i> Material Quantity
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_add">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="text"
                                        class="form-control"
                                        id="add_material_number"
                                        name="material_number"
                                        placeholder="Material Number"
                                        readonly>
                                    <label for="add_material_number">Material Number</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-cube text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="text"
                                        class="form-control"
                                        id="add_material_desc"
                                        name="material_desc"
                                        placeholder="Material Description"
                                        readonly>
                                    <label for="add_material_desc">Material Description</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-align-left text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="number"
                                        class="form-control"
                                        id="add_qty_order"
                                        name="qty_order"
                                        placeholder="Qty Ordered"
                                        value="0">
                                    <label for="add_qty_order">Qty Ordered</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-clipboard-list text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="number"
                                        class="form-control"
                                        id="add_qty_received"
                                        name="qty_received"
                                        placeholder="Qty Received"
                                        value="0" required>
                                    <label for="add_qty_received">Qty Received</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-box-open text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="text"
                                        class="form-control"
                                        id="add_uom"
                                        name="uom"
                                        placeholder="Unit of Measure">
                                    <label for="add_uom">Unit of Measure</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-ruler text-purple"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="edit_modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-boxes me-2"></i> Material Quantity
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_edit">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="text"
                                        class="form-control"
                                        id="edit_material_number"
                                        name="material_number"
                                        placeholder="Material Number"
                                        readonly>
                                    <label for="edit_material_number">Material Number</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-cube text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="text"
                                        class="form-control"
                                        id="edit_material_desc"
                                        name="material_desc"
                                        placeholder="Material Description"
                                        readonly>
                                    <label for="edit_material_desc">Material Description</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-align-left text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="number"
                                        class="form-control"
                                        id="edit_qty_order"
                                        name="qty_order"
                                        placeholder="Qty Ordered"
                                        value="0">
                                    <label for="edit_qty_order">Qty Ordered</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-clipboard-list text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="number"
                                        class="form-control"
                                        id="edit_qty_received"
                                        name="qty_received"
                                        placeholder="Qty Received"
                                        value="0" required>
                                    <label for="edit_qty_received">Qty Received</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-box-open text-purple"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="form-floating flex-grow-1">
                                    <input type="text"
                                        class="form-control"
                                        id="edit_uom"
                                        name="uom"
                                        placeholder="Unit of Measure">
                                    <label for="edit_uom">Unit of Measure</label>
                                </div>
                                <div class="input-group-text">
                                    <i class="fas fa-ruler text-purple"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>

</style>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<script>
    // $('#add_modal').on('shown.bs.modal', function() {
    //     initSelect2Ajax('#add_email', 'Select Email', "<?= base_url('select_form/emailSelect') ?>", '#add_modal .modal-body');
    // });

    // $('#edit_modal').on('shown.bs.modal', function() {
    //     initSelect2Ajax('#edit_email', 'Select Email', "<?= base_url('select_form/emailSelect') ?>", '#edit_modal .modal-body');
    // });

    $('#add_modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('select').val(null).trigger('change');
        $(this).find('.error, .invalid-feedback').remove();
        $(this).find('.is-invalid').removeClass('is-invalid');
        $('#material_number').val(null).trigger('change');
    });

    $('#edit_modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('select').val(null).trigger('change');
        $(this).find('.error, .invalid-feedback').remove();
        $(this).find('.is-invalid').removeClass('is-invalid');
    });

    function initSelect2Ajax(selector, placeholder, url, modal = null) {
        $(selector).select2({
            placeholder: placeholder,
            allowClear: true,
            width: '100%',
            dropdownParent: modal ? $(modal) : null,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    if (!data.items) return {
                        results: []
                    };

                    return {
                        results: data.items.map(item => ({
                            id: item.id,
                            text: item.name
                        }))
                    };
                },
                cache: true
            }
        });
    }

    function setSelect2Value(selector, value) {
        if (value && value !== 'null' && value.trim() !== '') {
            var opt = new Option(value, value, true, true);
            $(selector).empty().append(opt).trigger('change');
        } else {
            $(selector).val(null).trigger('change');
        }
    }

    $(document).ready(function() {
        initSelect2Ajax('#material_number', 'Select Material Number', "<?= base_url('select_form/grTempMaterialNumberSelect') ?>");
        get_table();
        $('#material_number').on('change', function() {
            const selected = $(this).val();
            if (!selected) return;

            $.ajax({
                url: "<?= base_url('process/modal_material_detail') ?>",
                type: "GET",
                data: {
                    material_number: selected
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#add_material_number').val(response.data.material_number);
                        $('#add_material_desc').val(response.data.material_desc);
                        $('#add_uom').val(response.data.uom);
                    } else {
                        $('#add_material_number_modal').val(selectedMaterial);
                        $('#add_material_desc').val('');
                        $('#add_uom').val('');
                    }
                    $('#add_modal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch material details.',
                    });
                }
            });

        });

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const material_number = $(this).data('material_number');
            const material_desc = $(this).data('material_desc');
            const qty_order = $(this).data('qty_order');
            const qty_received = $(this).data('qty_received');
            const uom = $(this).data('uom');

            $('#edit_id').val(id);
            $('#edit_material_number').val(material_number);
            $('#edit_material_desc').val(material_desc);
            $('#edit_qty_order').val(qty_order);
            $('#edit_qty_received').val(qty_received);
            $('#edit_uom').val(uom);

            $('#edit_modal').modal('show');
        });

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Delete this Material",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Confirm!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('process/delete_gr_temp_material') ?>",
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
                        get_table();
                    });
                }
            });
        });
    });

    function get_table() {
        if ($.fn.DataTable.isDataTable('#table_detail')) {
            $('#table_detail').DataTable().destroy();
            $('#table_detail tbody').empty();
        }
        $('#table_detail_body').html(`
        <tr id="table_loading">
            <td colspan="8" class="text-center py-4">
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
            dataType: "html",
            success: function(res) {
                $('#table_detail_body').html(res);
                initializeDataTable('table_detail');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#table_detail_body').html(`
                <tr>
                    <td colspan="8" class="text-center text-black p-3">
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

        // $('#' + tableId + ' thead tr')
        //     .clone(true)
        //     .addClass('search-row')
        //     .appendTo('#' + tableId + ' thead');

        // $('#' + tableId + ' thead tr.search-row th').each(function(index) {
        //     if (index === 6 || index === 0) {
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

    $("#form_add").on("submit", function(e) {
        e.preventDefault();

        let dataForm = new FormData(this);
        // for (const pair of dataForm.entries()) {
        //     console.log(`${pair[0]}: ${pair[1]}`);
        // }
        Swal.fire({
            title: "Are you sure?",
            text: "Add this Material",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('process/create_gr_temp_material') ?>",
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
                    timer: 1000,
                    showConfirmButton: false
                }).then(() => {
                    $('#add_modal').modal('hide');
                    get_table();
                });
            }
        });
    });

    $("#form_edit").on("submit", function(e) {
        e.preventDefault();

        let dataForm = new FormData(this);
        // for (const pair of dataForm.entries()) {
        //     console.log(`${pair[0]}: ${pair[1]}`);
        // }
        Swal.fire({
            title: "Are you sure?",
            text: "Edit this Material",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('process/update_gr_temp_material') ?>",
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
                    timer: 1000,
                    showConfirmButton: false
                }).then(() => {
                    $('#edit_modal').modal('hide');
                    get_table();
                });
            }
        });
    });

    $("#submit_gr").on("submit", function(e) {
        e.preventDefault();

        let dataForm = new FormData(this);
        // for (const pair of dataForm.entries()) {
        //     console.log(`${pair[0]}: ${pair[1]}`);
        // }
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
                    timer: 1000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>