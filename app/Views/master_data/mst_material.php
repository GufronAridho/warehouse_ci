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
                            <li class="breadcrumb-item"><a href="<?= base_url("home/index"); ?>">Master Data</a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card h-100 custom-card-purple custom-card-slim card-button">
                        <div class="h-100 d-flex justify-content-end align-items-center gap-2 flex-wrap">

                            <button class="btn btn-split btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_modal">
                                <span class="btn-icon"><i class="fa fa-plus"></i></span>
                                <span class="btn-text">
                                    <strong>
                                        Add Data
                                    </strong>
                                </span>
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
                <!-- Card Body with Table -->
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-custom" id="table_detail">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Material Number</th>
                                    <th class="text-center">Material Description</th>
                                    <th class="text-center">MS</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">PGr</th>
                                    <th class="text-center">MRPC</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_detail_body">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end::App Content-->
</main>

<!-- Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i> Add New Material
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_add">
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label for="add_material_number" class="form-label">Material Number</label>
                                    <input type="text" class="form-control" id="add_material_number" name="material_number" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="add_material_desc" class="form-label">Material Description</label>
                                    <input type="text" class="form-control" id="add_material_desc" name="material_desc">
                                </div>
                                <div class="col-md-4">
                                    <label for="add_ms" class="form-label">MS</label>
                                    <input type="text" class="form-control" id="add_ms" name="ms">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="add_uom" class="form-label">UOM</label>
                                            <input type="text" class="form-control" id="add_uom" name="uom" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_type" class="form-label">Type</label>
                                            <input type="text" class="form-control" id="add_type" name="type">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_pgr" class="form-label">PGr</label>
                                            <input type="text" class="form-control" id="add_pgr" name="pgr">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_mrpc" class="form-label">MRPC</label>
                                            <input type="text" class="form-control" id="add_mrpc" name="mrpc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="add_price" class="form-label">Price</label>
                                            <input type="number" step="0.01" class="form-control" id="add_price" name="price" value="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_currency" class="form-label">Currency</label>
                                            <input type="text" class="form-control" id="add_currency" name="currency" value="IDR" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_additional" class="form-label">Additional</label>
                                            <input type="text" class="form-control" id="add_additional" name="additional">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_is_active" class="form-label">Active</label>
                                            <select class="form-select" id="add_is_active" name="is_active">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i> Edit Material
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_edit">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label for="edit_material_number" class="form-label">Material Number</label>
                                    <input type="text" class="form-control" id="edit_material_number" name="material_number" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_material_desc" class="form-label">Material Description</label>
                                    <input type="text" class="form-control" id="edit_material_desc" name="material_desc">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_ms" class="form-label">MS</label>
                                    <input type="text" class="form-control" id="edit_ms" name="ms">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="edit_uom" class="form-label">UOM</label>
                                            <input type="text" class="form-control" id="edit_uom" name="uom" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_type" class="form-label">Type</label>
                                            <input type="text" class="form-control" id="edit_type" name="type">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_pgr" class="form-label">PGr</label>
                                            <input type="text" class="form-control" id="edit_pgr" name="pgr">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_mrpc" class="form-label">MRPC</label>
                                            <input type="text" class="form-control" id="edit_mrpc" name="mrpc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="edit_price" class="form-label">Price</label>
                                            <input type="number" step="0.01" class="form-control" id="edit_price" name="price">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_currency" class="form-label">Currency</label>
                                            <input type="text" class="form-control" id="edit_currency" name="currency">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_additional" class="form-label">Additional</label>
                                            <input type="text" class="form-control" id="edit_additional" name="additional">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_is_active" class="form-label">Active</label>
                                            <select class="form-select" id="edit_is_active" name="is_active">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Update Material
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
        $(this).find('#add_preview').empty();
    });

    $('#edit_modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('select').val(null).trigger('change');
        $(this).find('.error, .invalid-feedback').remove();
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('#edit_preview').empty();
    });

    function setSelect2Value(selector, value) {
        if (value && value !== 'null' && value.trim() !== '') {
            var opt = new Option(value, value, true, true);
            $(selector).empty().append(opt).trigger('change');
        } else {
            $(selector).val(null).trigger('change');
        }
    }

    $(document).ready(function() {
        get_table();

        $(document).on('click', '.edit-btn', function() {

            const id = $(this).data('id');
            const material_number = $(this).data('material_number');
            const material_desc = $(this).data('material_desc');
            const ms = $(this).data('ms');
            const uom = $(this).data('uom');
            const type = $(this).data('type');
            const pgr = $(this).data('pgr');
            const mrpc = $(this).data('mrpc');
            const price = $(this).data('price');
            const currency = $(this).data('currency');
            const additional = $(this).data('additional');
            const is_active = $(this).data('is_active');

            $('#edit_id').val(id);
            $('#edit_material_number').val(material_number);
            $('#edit_material_desc').val(material_desc);
            $('#edit_ms').val(ms);
            $('#edit_uom').val(uom);
            $('#edit_type').val(type);
            $('#edit_pgr').val(pgr);
            $('#edit_mrpc').val(mrpc);
            $('#edit_price').val(price);
            $('#edit_currency').val(currency);
            $('#edit_additional').val(additional);
            $('#edit_is_active').val(is_active);

            $('#edit_modal').modal('show');
        });

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Delete this Material!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Confirm!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('master_data/delete_material') ?>",
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
            <td colspan="11" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('master_data/material_table'); ?>",
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
                    <td colspan="11" class="text-center text-black p-3">
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
            if (index === 10 || index === 0) {
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
                    $('input', $('.search-row th').eq(colIdx)).on('keyup change clear', function() {
                        api.column(colIdx).search(this.value).draw();
                    });
                });
            }
        });
    }

    $("#form_add").on("submit", function(e) {
        e.preventDefault();

        let dataForm = new FormData(this);

        Swal.fire({
            title: "Are you sure?",
            text: "Add this Material!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/create_material') ?>",
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
            text: "Edit this Material!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/update_material') ?>",
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
</script>
<?= $this->endSection() ?>