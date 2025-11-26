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
                    <table class="table table-bordered table-striped table-hover table-custom" id="table_detail">
                        <thead>
                            <tr>
                                <th>SAFG Number</th>
                                <th>SAFG Description</th>
                                <th>Plant</th>
                                <th>Cell Name</th>
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
    <!--end::App Content-->
</main>

<!-- Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i> Add New SAFG
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_add">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">SAFG Number</label>
                            <input type="text" class="form-control" id="add_safg_number" name="safg_number" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">SAFG Description</label>
                            <input type="text" class="form-control" id="add_safg_desc" name="safg_desc" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Plant</label>
                            <input type="text" class="form-control" id="add_plant" name="plant" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Cell Name</label>
                            <input type="text" class="form-control" id="add_cell_name" name="cell_name" required>
                        </div>
                    </div>
                    <hr class="my-3">
                    <h5 class="fw-bold">Add Material</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Material Number</label>
                            <select class="form-select" id="add_material_number" name="material_number" required></select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Qty</label>
                            <input type="number" step="0.01" class="form-control" id="add_qty" name="qty" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Is Active</label>
                            <select class="form-select" id="add_is_active" name="is_active" required>
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save SAFG
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="safg_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-purple">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i> Add New SAFG
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">SAFG Number</label>
                        <input type="text" class="form-control" id="safg_number" name="safg_number" readonly>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold">SAFG Description</label>
                        <input type="text" class="form-control" id="safg_desc" name="safg_desc" placeholder="Enter SAFG Description">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Plant</label>
                        <input type="text" class="form-control" id="plant" name="plant" placeholder="Enter Plant Code">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Cell Name</label>
                        <input type="text" class="form-control" id="cell_name" name="cell_name" placeholder="Enter Cell Name">
                    </div>
                </div>
                <hr class="my-4">
                <h5 class="fw-bold mb-3">Material List for This SAFG</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-custom" id="table_material">
                        <thead class="table-light">
                            <tr>
                                <th>Material Number</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>UOM</th>
                                <th>Price</th>
                                <th>Active</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_material_body"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn_update_safg">
                    <i class="fas fa-save me-1"></i> Update SAFG
                </button>
            </div>
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
                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" id="edit_id_bom" name="id_bom">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Material Number</label>
                            <select class="form-select" id="edit_material_number" name="material_number" required></select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Material Description</label>
                            <input type="text" class="form-control" id="edit_material_desc" name="material_desc" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Quantity</label>
                            <input type="number" step="0.01" class="form-control" id="edit_qty" name="qty" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Is Active</label>
                            <select class="form-select" id="edit_is_active" name="is_active" required>
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>
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
    $('#edit_modal').on('shown.bs.modal', function() {
        initSelect2Ajax(
            '#edit_material_number',
            'Select Material Number',
            "<?= base_url('select_form/materialNumberSelect') ?>",
            '#edit_modal .modal-body'
        );
    });

    $("#add_modal").on("shown.bs.modal", function() {
        initSelect2Ajax(
            '#add_material_number',
            'Search Material',
            "<?= base_url('select_form/materialNumberSelect') ?>",
            '#add_modal .modal-body'
        );
    });

    $('#safg_modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('select').val(null).trigger('change');
        $(this).find('.error, .invalid-feedback').remove();
        $(this).find('.is-invalid').removeClass('is-invalid');
    });

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

        $(document).on('click', '.view-material', function() {
            let safg_number = $(this).data('safg_number');
            let plant = $(this).data('plant');
            let cell_name = $(this).data('cell_name');
            let safg_desc = $(this).data('safg_desc');

            $("#safg_number").val(safg_number);
            $("#plant").val(plant);
            $("#cell_name").val(cell_name);
            $("#safg_desc").val(safg_desc);

            get_table_material(safg_number);

            $('#safg_modal').modal('show');
        });

        $(document).on('click', '.edit-btn', function() {

            $('#edit_id_bom').val($(this).data('id'));
            // $('#edit_material_number').val($(this).data('material_number'));
            material_number = $(this).data('material_number');
            setSelect2Value('#edit_material_number', material_number);
            $('#edit_material_desc').val($(this).data('material_desc'));
            $('#edit_qty').val($(this).data('qty'));
            $('#edit_is_active').val($(this).data('is_active'));
            $('#edit_modal').modal('show');
        });

        $(document).on("click", ".add-material", function() {

            $("#add_safg_number").val($(this).data("safg_number"));
            $("#add_safg_desc").val($(this).data("safg_desc"));
            $("#add_plant").val($(this).data("plant"));
            $("#add_cell_name").val($(this).data("cell_name"));

            $("#add_modal").modal("show");
        });

        $(document).on('click', '.delete-safg', function() {
            var safg_number = $(this).data('safg_number');

            Swal.fire({
                title: "Are you sure?",
                text: "Delete this SAFG and its Material",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Confirm!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('master_data/delete_safg') ?>",
                        type: "POST",
                        data: {
                            safg_number: safg_number
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
                        url: "<?= base_url('master_data/delete_safg_material') ?>",
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
                        let safg_number = $("#safg_number").val();
                        get_table();
                        get_table_material(safg_number);
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
            <td colspan="5" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);
        $.ajax({
            url: "<?= base_url('master_data/safg_table'); ?>",
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
                    <td colspan="5" class="text-center text-black p-3">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
            }
        });
    }

    function get_table_material(safg_number) {
        if (!safg_number) {
            console.error("Missing safg_number for material table!");
            return;
        }

        if ($.fn.DataTable.isDataTable('#table_material')) {
            $('#table_material').DataTable().destroy();
            $('#table_material tbody').empty();
        }

        $('#table_material_body').html(`
        <tr>
            <td colspan="10" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 fw-bold text-muted">Loading data...</div>
            </td>
        </tr>
        `);

        $.ajax({
            url: "<?= base_url('master_data/safg_material_table'); ?>/",
            type: "GET",
            data: {
                safg_number
            },
            dataType: "html",
            success: function(res) {
                $('#table_material_body').html(res);
                initializeDataTable('table_material');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#table_material_body').html(`
                <tr>
                    <td colspan="10" class="text-center text-black p-3">
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
            if (index === 8 || index === 0) {
                $(this).html('');
            } else {
                $(this).html('<input type="text" placeholder="Search" class="form-control form-control-sm" />');
            }
            if (tableId == 'table_detail') {
                if (index === 4) {
                    $(this).html('');
                } else {
                    $(this).html('<input type="text" placeholder="Search" class="form-control form-control-sm" />');
                }
            } else {
                if (index === 6) {
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
            title: "Save SAFG?",
            text: "This will create a new SAFG and material!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, save it",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/create_safg') ?>",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    dataType: "json"
                }).then((res) => {
                    if (!res.status) throw new Error(res.message);
                    return res;
                }).catch(err => {
                    Swal.showValidationMessage(
                        `Request failed: ${err.message}`
                    );
                });
            }
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: result.value.message,
                    timer: 1000,
                    showConfirmButton: false
                }).then(() => {
                    get_table();
                    $("#add_modal").modal("hide");
                });
            }
        });
    });


    $('#btn_update_safg').on('click', function() {

        let data = {
            safg_number: $('#safg_number').val(),
            safg_desc: $('#safg_desc').val(),
            plant: $('#plant').val(),
            cell_name: $('#cell_name').val()
        };

        Swal.fire({
            title: "Are you sure?",
            text: "Edit this SAFG!!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/update_safg') ?>",
                    type: "POST",
                    data: data,
                    // processData: false,
                    // contentType: false,
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
                    let safg_number = $("#safg_number").val();
                    get_table();
                    get_table_material(safg_number);
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
            text: "Edit this Material!!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Confirm!",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                return $.ajax({
                    url: "<?= base_url('master_data/update_safg_material') ?>",
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
                    let safg_number = $("#safg_number").val();
                    get_table_material(safg_number);
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>