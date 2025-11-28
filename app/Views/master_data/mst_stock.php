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
                                    <th class="text-center">material_number</th>
                                    <th class="text-center">location_id</th>
                                    <th class="text-center">rack</th>
                                    <th class="text-center">bin</th>
                                    <th class="text-end">qty</th>
                                    <th class="text-center">last_updated</th>
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
                    <i class="fas fa-plus me-2"></i> Add New Location
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_add">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="add_storage_type" class="form-label">Storage Type</label>
                                            <select class="form-select" id="add_storage_type" name="storage_type">
                                                <option value="GR-AREA">GR-AREA</option>
                                                <option value="STORAGE">STORAGE</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_rack" class="form-label">Rack</label>
                                            <input type="text" class="form-control" id="add_rack" name="rack" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_bin" class="form-label">Bin</label>
                                            <input type="text" class="form-control" id="add_bin" name="bin" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_capacity" class="form-label">Capacity</label>
                                            <input type="number" class="form-control" id="add_capacity" name="capacity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="add_material_type_allowed" class="form-label">Material Type Allowed</label>
                                            <input type="text" class="form-control" id="add_material_type_allowed" name="material_type_allowed">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="add_priority" class="form-label">Priority</label>
                                            <input type="number" class="form-control" id="add_priority" name="priority" min="0" value="0">
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
                        <i class="fas fa-save me-1"></i> Save Location
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
                    <i class="fas fa-edit me-2"></i> Edit Location
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_edit">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="col-md-6">
                                            <label for="edit_storage_type" class="form-label">Storage Type</label>
                                            <select class="form-select" id="edit_storage_type" name="storage_type">
                                                <option value="STAGING">STAGING</option>
                                                <option value="STORAGE">STORAGE</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_rack" class="form-label">Rack</label>
                                            <input type="text" class="form-control" id="edit_rack" name="rack" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_bin" class="form-label">Bin</label>
                                            <input type="text" class="form-control" id="edit_bin" name="bin" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_capacity" class="form-label">Capacity</label>
                                            <input type="number" class="form-control" id="edit_capacity" name="capacity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="edit_material_type_allowed" class="form-label">Material Type Allowed</label>
                                            <input type="text" class="form-control" id="edit_material_type_allowed" name="material_type_allowed">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_priority" class="form-label">Priority</label>
                                            <input type="number" class="form-control" id="edit_priority" name="priority" min="0" value="0">
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
                        <i class="fas fa-save me-1"></i> Update Location
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

    function initSelect2Ajax(selector, placeholder, url, modal = null) {
        $(selector).select2({
            placeholder: placeholder,
            allowClear: true,
            width: '100%',
            dropdownParent: modal ? $(modal) : null,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
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
        get_table();

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const storage_type = $(this).data('storage_type');
            const rack = $(this).data('rack');
            const bin = $(this).data('bin');
            const capacity = $(this).data('capacity');
            const material_type_allowed = $(this).data('material_type_allowed');
            const priority = $(this).data('priority');
            const is_active = $(this).data('is_active');

            $('#edit_id').val(id);
            $('#edit_storage_type').val(storage_type);
            $('#edit_rack').val(rack);
            $('#edit_bin').val(bin);
            $('#edit_capacity').val(capacity);
            $('#edit_material_type_allowed').val(material_type_allowed);
            $('#edit_priority').val(priority);
            $('#edit_is_active').val(is_active);

            $('#edit_modal').modal('show');
        });

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Delete this Location",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Confirm!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('master_data/delete_location') ?>",
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
            <td colspan="6" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('master_data/stock_table'); ?>",
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
        $('#' + tableId + ' thead tr.search-row').remove();

        $('#' + tableId + ' thead tr')
            .clone(true)
            .addClass('search-row')
            .appendTo('#' + tableId + ' thead');

        $('#' + tableId + ' thead tr.search-row th').each(function(index) {
            if (index === 5) {
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
        // for (const pair of dataForm.entries()) {
        //     console.log(`${pair[0]}: ${pair[1]}`);
        // }
        Swal.fire({
            title: "Are you sure?",
            text: "Add this Location",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/create_location') ?>",
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
            text: "Edit this Location",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/update_location') ?>",
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