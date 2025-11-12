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
                    <div class="d-md-flex align-items-center mb-2 mb-md-0">
                        <a href="<?= base_url("home/index"); ?>" class="layout-logo d-flex align-items-center text-decoration-none">
                            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo Icon" class="logo-icon me-2">
                            <img src="<?= base_url('assets/img/logo-text.png'); ?>" alt="Logo Text" class="logo-text">
                        </a>
                    </div>

                    <div class="d-flex align-items-center flex-wrap">
                        <div class="dropdown me-2">
                            <a class="d-flex align-items-center text-white fw-semibold text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="me-2 text-end">
                                    <div><?= $layout_emp['name'] ?? auth()->user()->username; ?></div>
                                    <small class="text-light"><?= $layout_emp['emp_id'] ?? implode(', ', auth()->user()->getGroups()); ?></small>
                                </div>
                                <img src="<?= base_url('assets/profile/' . ($layout_emp['photo'] ?? 'avatar5.png')); ?>"
                                    alt="User Image"
                                    class="rounded-circle layout-profile-img"
                                    onerror="this.onerror=null; this.src='<?= base_url('assets/profile/avatar5.png'); ?>';">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end layout-dropdown">
                                <li><a class="dropdown-item layout-dropdown-item" href="<?= base_url('home/change_password') ?>"><i class="fas fa-key me-2"></i>Change Password</a></li>
                                <li><a class="dropdown-item layout-dropdown-item" href="<?= base_url('master_data/mst_user') ?>"><i class="fas fa-user-cog me-2"></i>Master Data</a></li>
                                <li><a class="dropdown-item layout-dropdown-item" href="<?= url_to('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!--end::Header-->
        <!--begin::Main-->
        <?= $this->renderSection('content') ?>
        <!--end::Main-->
        <!--begin::Footer-->
        <!-- <footer class="app-footer layout-footer d-flex justify-content-between align-items-center px-3 py-1">
            <div>
                <strong>Copyright &copy; 2014-2025&nbsp;</strong> All rights reserved.
            </div>
            <div class="d-none d-sm-block">
                Anything you want
            </div>
        </footer> -->
        <!--end::Footer-->
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
        }

        .layout-link {
            color: #f8f9fa !important;
            font-weight: 500;
            border-radius: 12px;
            padding: 8px 16px;
            transition: all 0.25s ease;
            position: relative;
        }

        .layout-dropdown {
            border-radius: 12px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            border: 2px solid #4d056bff;
            min-width: 200px;
            padding: 4px 0;
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

        @media (max-width: 768px) {
            .layout-logo .logo-icon {
                max-height: 36px;
            }

            .layout-logo .logo-text {
                max-height: 28px;
            }
        }

        @media (max-width: 480px) {
            .layout-logo {
                justify-content: center;
            }

            .layout-logo .logo-text {
                display: none;
            }

            .layout-logo .logo-icon {
                max-height: 32px;
            }
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

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

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
                        let res = JSON.parse(xhr.responseText);
                        if (res.csrfHash) {
                            $('meta[name="csrf-token"]').attr("content", res.csrfHash);
                        }
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