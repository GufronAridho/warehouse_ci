<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= $title ?? "WMiS" ?></title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="<?php echo isset($title) ? $title : "WMiS"; ?>" />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <!-- Accessibility Features -->
    <meta name="supported-color-schemes" content="light dark" />

    <meta name="csrf-token" content="<?= csrf_hash(); ?>">
    <meta name="csrf-header" content="<?= csrf_token(); ?>">

    <link rel="preload" href="<?= base_url('dist/adminLte/css/adminlte.css'); ?>" as="style" />

    <!-- Fonts -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
        media="print"
        onload="this.media='all'" />

    <!-- Core AdminLTE -->
    <link rel="stylesheet" href="<?= base_url('dist/adminLte/css/adminlte.css') ?>">

    <!-- Third Party Plugins -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
        crossorigin="anonymous" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('dist/plugins/fontawosome7/css/all.min.css') ?>">

    <!-- Custom Plugins -->
    <link rel="stylesheet" href="<?= base_url('dist/plugins/DataTables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('dist/plugins/select2-4.0.13/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/plugins/sweetalert2/dist/sweetalert2.min.css') ?>">

</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container-fluid flex-column px-0">
                <div class="d-flex align-items-center justify-content-between w-100 py-2 px-3 layout-bottom">
                    <div class="d-flex align-items-center mb-2">
                        <a data-lte-toggle="sidebar" href="#" role="button" class="layout-logo d-flex align-items-center text-decoration-none">
                            <img src="<?= base_url('assets/img/logo-text.png'); ?>" alt="Logo Text" class="logo-text">
                        </a>
                    </div>

                    <div class="d-flex align-items-center flex-wrap">
                        <a class="d-flex align-items-center text-white fw-semibold text-decoration-none">
                            <div class="me-2 text-end">
                                <div><?= $layout_emp['name'] ?? auth()->user()->username; ?></div>
                                <small class="text-light"><?= $layout_emp['emp_id'] ?? implode(', ', auth()->user()->getGroups()); ?></small>
                            </div>
                            <img src="<?= base_url('assets/profile/' . ($layout_emp['photo'] ?? 'avatar5.png')); ?>"
                                alt="User Image"
                                class="rounded-circle layout-profile-img"
                                onerror="this.onerror=null; this.src='<?= base_url('assets/profile/avatar5.png'); ?>';">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <aside class="app-sidebar bg-body shadow sidebar-dark-primary" data-bs-theme="dark">
            <div class="sidebar-brand text-center py-3">
                <a href="<?= base_url('home/index'); ?>" class="brand-link">
                    <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo"
                        class="brand-image img-circle elevation-3" style="height: 50px;">
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <!-- <li class="nav-item">
                            <a href="<?= base_url('process/good_receipt_image'); ?>"
                                class="nav-link <?= (strpos(uri_string(), 'process/good_receipt_image') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-truck-loading"></i>
                                <p>Good Receipt (Image)</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="<?= base_url('process/good_receipt_input'); ?>"
                                class="nav-link <?= (strpos(uri_string(), 'process/good_receipt_input') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-truck-loading"></i>
                                <p>Good Receipt</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('process/put_away'); ?>"
                                class="nav-link <?= (strpos(uri_string(), 'process/put_away') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>Put Away</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview <?= (strpos(uri_string(), 'picking') === 0) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= (strpos(uri_string(), 'picking') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Picking
                                    <i class="nav-arrow fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview" style="<?= (strpos(uri_string(), 'picking') === 0) ? 'display: block;' : '' ?>">

                                <li class="nav-item">
                                    <a href="<?= base_url('picking/create_po'); ?>"
                                        class="nav-link <?= (uri_string() == 'picking/create_po') ? 'active' : '' ?>">
                                        <i class="fas fa-plus-circle nav-icon"></i>
                                        <p>Create Work Order</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url('picking/list'); ?>"
                                        class="nav-link <?= (uri_string() == 'picking/list') ? 'active' : '' ?>">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Picking List</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('process/cycle_count'); ?>"
                                class="nav-link <?= (strpos(uri_string(), 'process/cycle_count') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-sync-alt"></i>
                                <p>Cycle Count</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview <?= (strpos(uri_string(), 'master_data') === 0) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= (strpos(uri_string(), 'master_data') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Master Data
                                    <i class="nav-arrow fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="<?= (strpos(uri_string(), 'master_data') === 0) ? 'display: block;' : '' ?>">
                                <li class="nav-item">
                                    <a href="<?= base_url('master_data/mst_user'); ?>"
                                        class="nav-link <?= (uri_string() == 'master_data/mst_user') ? 'active' : '' ?>">
                                        <i class="fas fa-user-cog nav-icon"></i>
                                        <p>User Management</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('master_data/mst_prod'); ?>"
                                        class="nav-link <?= (uri_string() == 'master_data/mst_prod') ? 'active' : '' ?>">
                                        <i class="fas fa-industry nav-icon"></i>
                                        <p>Master Production</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('master_data/mst_location'); ?>"
                                        class="nav-link <?= (uri_string() == 'master_data/mst_location') ? 'active' : '' ?>">
                                        <i class="fas fa-map-marker-alt nav-icon"></i>
                                        <p>Storage</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('master_data/mst_material'); ?>"
                                        class="nav-link <?= (uri_string() == 'master_data/mst_material') ? 'active' : '' ?>">
                                        <i class="fas fa-boxes nav-icon"></i>
                                        <p>Master Material</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('master_data/mst_safg_bom'); ?>"
                                        class="nav-link <?= (uri_string() == 'master_data/mst_safg_bom') ? 'active' : '' ?>">
                                        <i class="fas fa-sitemap nav-icon"></i>
                                        <p>Master BOM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('master_data/mst_stock'); ?>"
                                        class="nav-link <?= (uri_string() == 'master_data/mst_stock') ? 'active' : '' ?>">
                                        <i class="fas fa-boxes nav-icon"></i>
                                        <p>Stock</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview <?= (strpos(uri_string(), 'summary') === 0) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= (strpos(uri_string(), 'summary') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Summary
                                    <i class="nav-arrow fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview" style="<?= (strpos(uri_string(), 'summary') === 0) ? 'display: block;' : '' ?>">

                                <li class="nav-item">
                                    <a href="<?= base_url('summary/good_receipt_summary'); ?>"
                                        class="nav-link <?= (uri_string() == 'summary/good_receipt_summary') ? 'active' : '' ?>">
                                        <i class="fas fa-receipt nav-icon"></i>
                                        <p>Good Receipt Summary</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('home/change_password'); ?>"
                                class="nav-link <?= (strpos(uri_string(), 'home/change_password') === 0) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-key"></i>
                                <p>Change Password</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= url_to('logout'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </aside>

        <!--end::Header-->
        <!--begin::Main-->
        <?= $this->renderSection('content') ?>
        <!--end::Main-->
    </div>
    <!--end::App Wrapper-->
    <style>
        .app-header.navbar {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .app-header {
            border-bottom: 0 !important;
        }

        .layout-bottom {
            background: #5f0188;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
            min-height: 64px;
            display: flex;
            align-items: center;
        }

        .layout-link {
            color: #f8f9fa !important;
            font-weight: 500;
            border-radius: 12px;
            padding: 8px 16px;
            transition: all 0.25s ease;
            position: relative;
        }

        .layout-dropdown-item {
            color: #5f0188 !important;
            font-weight: 500;
            padding: 10px 16px;
            transition: all 0.25s ease;
            border-radius: 8px;
        }

        .layout-dropdown-item:hover {
            background-color: #7030a0;
            color: #ffd700 !important;
            transform: translateY(-3px);
        }

        .layout-dropdown-item i {
            color: #ffd700;
        }

        .dropdown-divider {
            background-color: rgba(255, 255, 255, 0.2);
            margin: 4px 0;
        }

        .app-main {
            background-color: #f2f0f8;
            color: #2a2a2a;
        }

        .layout-logo img {
            height: auto;
            max-height: 40px;
            width: auto;
            transition: all 0.3s ease;
        }

        .layout-profile-img {
            width: 3rem;
            height: 3rem;
            object-fit: cover;
        }

        .sidebar-brand {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 !important;
        }

        .sidebar-brand img {
            height: 42px;
            object-fit: contain;
        }

        .sidebar-wrapper {
            background-color: #f2f0f8;
        }

        .sidebar-menu .nav-link {
            color: #5f0188 !important;
            font-weight: 500;
            transition: all 0.25s ease;
            border-radius: 8px;
            display: flex;
            align-items: center;
        }

        .sidebar-menu .nav-link:hover {
            background-color: #7030a0 !important;
            color: #ffd700 !important;
            transform: translateY(-2px);
        }

        .sidebar-menu .nav-link.active {
            background-color: #7030a0 !important;
            color: #ffd700 !important;
            font-weight: 600;
        }

        .sidebar-menu .nav-link i {
            color: #ffd700 !important;
            transition: color 0.25s ease;
        }

        .sidebar-menu .nav-link:hover i {
            color: #ffd700 !important;
        }

        .custom-card-purple {
            background: #5f0188 !important;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            color: #f2f0f8;
        }

        .modal-custom-purple {
            background: #5f0188eb;
            color: #ffd700;
        }

        .text-purple {
            color: #5f0188eb;
        }

        .custom-card-breadcrumb {
            background: #5f0188eb;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }


        /* .custom-card-purple,
    .custom-card-breadcrumb,
    .card-button,
    .card-table {
        background: rgba(128, 0, 128, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        color: #fff;
    } */

        .custom-card-slim {
            padding: 0.4rem 0.8rem !important;
        }

        .breadcrumb {
            background: transparent;
            margin-bottom: 0;
            font-size: 1.2rem;
            color: #ffd700;
        }

        .breadcrumb a {
            color: #ffd700;
            text-decoration: none;
        }

        .breadcrumb .active {
            color: #ffd700;
            font-weight: 600;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: #ffd700;
        }

        .btn-split {
            display: flex;
            padding: 0;
            overflow: hidden;
            border-radius: 8px;
            border: 2px solid transparent;
            font-size: 14px;
        }

        .btn-split .btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px 8px;
            color: #f2f0f8;
        }

        .btn-split .btn-text {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px 8px;
            background-color: #f2f0f8;
            /* font-weight: bold; */
        }

        .btn:hover {
            transform: translateY(-1px) scale(1.00);
        }

        .btn-primary .btn-text {
            color: #5f0188eb;
            border-left: 1px solid #5f0188eb;
        }

        .btn-info .btn-text {
            color: #5f0188eb;
            border-left: 1px solid #0dcaf0;
        }

        .btn-success .btn-text {
            color: #5f0188eb;
            border-left: 1px solid #198754;
        }

        .btn-warning .btn-text {
            color: #5f0188eb;
            border-left: 1px solid #ffd700;
        }

        .btn-secondary .btn-text {
            color: #5f0188eb;
            border-left: 1px solid #6c757d;
        }

        .btn-danger .btn-text {
            color: #5f0188eb;
            border-left: 1px solid #dc3545;
        }

        .btn-primary .btn-icon {
            background-color: #5f0188eb;
        }

        .btn-info .btn-icon {
            background-color: #0dcaf0;
        }

        .btn-success .btn-icon {
            background-color: #198754;
        }

        .btn-warning .btn-icon {
            background-color: #ffd700;
        }

        .btn-secondary .btn-icon {
            background-color: #6c757d;
        }

        .btn-danger .btn-icon {
            background-color: #dc3545;
        }

        .table-custom {
            border: 1px solid #dee2e6;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }

        .table-custom th {
            background-color: #ffd700 !important;
            color: #1e1e1f;
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 0;
        }

        .table-custom td {
            border: 1px solid #dee2e6;
            border-radius: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f5ff;
        }

        .table-hover tbody tr:hover {
            background-color: #efe6ff;
        }

        .select2-container--default .select2-selection--single {
            height: calc(1.5em + 0.75rem + 2px);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(1.5em + 0.75rem);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + 0.75rem + 2px);
        }
    </style>
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
        src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->

    <!-- Core JS -->
    <script src="<?= base_url('dist/plugins/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('dist/adminLte/js/adminlte.js') ?>"></script>

    <!-- UI & Icons -->
    <script src="<?= base_url('dist/plugins/fontawosome7/js/all.min.js') ?>"></script>

    <!-- Plugins -->
    <script src="<?= base_url('dist/plugins/DataTables/datatables.min.js') ?>"></script>
    <script src="<?= base_url('dist/plugins/select2-4.0.13/js/select2.full.min.js') ?>"></script>
    <script src="<?= base_url('dist/plugins/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                beforeSend: function(xhr, settings) {
                    if (settings.type.toUpperCase() === "POST") {
                        let token = $('meta[name="csrf-token"]').attr("content");
                        let header = $('meta[name="csrf-header"]').attr("content");
                        xhr.setRequestHeader(header, token);
                        if (settings.data instanceof FormData) {
                            settings.data.append("csrf_test_name", token);
                        } else if (typeof settings.data === "string") {
                            if (settings.data.length > 0) {
                                settings.data += "&csrf_test_name=" + encodeURIComponent(token);
                            } else {
                                settings.data = "csrf_test_name=" + encodeURIComponent(token);
                            }
                        } else if (typeof settings.data === "object" && settings.data !== null) {
                            // Add CSRF token to data object
                            settings.data.csrf_test_name = token;
                        }
                    }
                },
                complete: function(xhr) {
                    try {
                        // let res = JSON.parse(xhr.responseText);
                        // if (res.csrfHash) {
                        //     $('meta[name="csrf-token"]').attr("content", res.csrfHash);
                        // }
                        sessionTimer = 0;
                    } catch (e) {}
                }
            });
        });

        const SESSION_EXPIRATION = 900;
        const WARNING_BEFORE = 60;
        let sessionTimer = 0;
        setInterval(() => {
            sessionTimer++;
            if (sessionTimer >= (SESSION_EXPIRATION - WARNING_BEFORE)) {
                check_session();
                sessionTimer = 0;
            }

        }, 1000);

        function check_session() {
            Swal.fire({
                title: "Session Expiration Notice",
                text: "Your session is about to expire. Do you want to stay logged in or log out?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Stay Logged In",
                cancelButtonText: "Logout",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => false,
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('home/refresh_session') ?>",
                        type: "GET",
                        dataType: "json"
                    }).then((res) => {
                        if (!res.status) {
                            throw new Error(res.message);
                        }
                        return res;
                    }).catch((error) => {
                        Swal.showValidationMessage(
                            "Session has expired, please Logout"
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

                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "<?= url_to('logout') ?>";
                }
            });
        }
    </script>

    <?= $this->renderSection('script'); ?>
    <!--end::Script-->
</body>
<!--end::Body-->

</html>