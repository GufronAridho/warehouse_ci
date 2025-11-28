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
                                <span class="btn-text"><strong>Add Data</strong></span>
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
                        <table class="table table-bordered table-striped table-hover table-custom" id="table_detail">
                            <thead>
                                <tr>
                                    <th class="text-center">Plant Code</th>
                                    <th class="text-center">Plant Name</th>
                                    <th class="text-center">Line Code</th>
                                    <th class="text-center">Line Name</th>
                                    <th class="text-center">Cell Name</th>
                                    <th class="text-center">Process Type</th>
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

<!-- Add Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i> Add Production Master
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_add">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="add_plant_code" class="form-label">Plant Code</label>
                            <input type="text" class="form-control" id="add_plant_code" name="plant_code" required>
                        </div>
                        <div class="col-md-6">
                            <label for="add_plant_name" class="form-label">Plant Name</label>
                            <input type="text" class="form-control" id="add_plant_name" name="plant_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="add_line_code" class="form-label">Line Code</label>
                            <input type="text" class="form-control" id="add_line_code" name="line_code" required>
                        </div>
                        <div class="col-md-6">
                            <label for="add_line_name" class="form-label">Line Name</label>
                            <input type="text" class="form-control" id="add_line_name" name="line_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="add_cell_name" class="form-label">Cell Name</label>
                            <input type="text" class="form-control" id="add_cell_name" name="cell_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="add_process_type" class="form-label">Process Type</label>
                            <input type="text" class="form-control" id="add_process_type" name="process_type" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i> Edit Production Master
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_edit">
                <div class="modal-body">
                    <div class="row g-2">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="col-md-6">
                            <label for="edit_plant_code" class="form-label">Plant Code</label>
                            <input type="text" class="form-control" id="edit_plant_code" name="plant_code" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_plant_name" class="form-label">Plant Name</label>
                            <input type="text" class="form-control" id="edit_plant_name" name="plant_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_line_code" class="form-label">Line Code</label>
                            <input type="text" class="form-control" id="edit_line_code" name="line_code" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_line_name" class="form-label">Line Name</label>
                            <input type="text" class="form-control" id="edit_line_name" name="line_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_cell_name" class="form-label">Cell Name</label>
                            <input type="text" class="form-control" id="edit_cell_name" name="cell_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_process_type" class="form-label">Process Type</label>
                            <input type="text" class="form-control" id="edit_process_type" name="process_type" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Update
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
            tags: true,
            createTag: function(params) {
                let term = $.trim(params.term);
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (term === '' || !emailRegex.test(term)) {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            },
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
            const plant_code = $(this).data('plant_code');
            const plant_name = $(this).data('plant_name');
            const line_code = $(this).data('line_code');
            const line_name = $(this).data('line_name');
            const cell_name = $(this).data('cell_name');
            const process_type = $(this).data('process_type');
            const is_active = $(this).data('is_active');

            $('#edit_id').val(id);
            $('#edit_plant_code').val(plant_code);
            $('#edit_plant_name').val(plant_name);
            $('#edit_line_code').val(line_code);
            $('#edit_line_name').val(line_name);
            $('#edit_cell_name').val(cell_name);
            $('#edit_process_type').val(process_type);
            $('#edit_is_active').val(is_active);

            $('#edit_modal').modal('show');
        });


        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Delete this Production master data",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Confirm!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('master_data/delete_prod') ?>",
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
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('master_data/prod_table'); ?>",
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
        $('#' + tableId + ' thead tr.search-row').remove();

        $('#' + tableId + ' thead tr')
            .clone(true)
            .addClass('search-row')
            .appendTo('#' + tableId + ' thead');

        $('#' + tableId + ' thead tr.search-row th').each(function(index) {
            if (index === 6) {
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
            text: "Add this Production master data",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/create_prod') ?>",
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
            text: "Edit this Production master data",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/update_prod') ?>",
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