<?= $this->extend('shared/layout_home') ?>

<?= $this->section('content') ?>
<main class="app-main">
    <div class="app-content">
        <div class="container-fluid d-flex justify-content-center align-items-center">
            <div class="login-box w-100 mt-4">
                <div class="card shadow-lg d-flex flex-column flex-md-row custom-card">

                    <div class="col-12 col-md-4 branding-section d-flex flex-column justify-content-center align-items-center p-4 text-white">
                        <i class="fa fa-key fa-4x mb-3 text-white"></i>
                        <div class="text-center mb-3">
                            <h3 class="fw-bold">Change Your Password</h3>
                        </div>
                    </div>

                    <div class="col-12 col-md-8 p-3 form-section d-flex flex-column justify-content-center">
                        <form id="form_change_password">
                            <?= csrf_field() ?>
                            <div class=" mb-3">
                                <p>Enter your current password and set a new password</p>
                            </div>
                            <div class="form-floating mb-3">
                                <div class="input-group mb-3 position-relative">
                                    <div class="form-floating flex-grow-1">
                                        <input type="password" class="form-control bg-light bg-opacity-75"
                                            id="currentPasswordInput"
                                            name="current_password"
                                            placeholder="Current Password"
                                            required>
                                        <label for="currentPasswordInput">Current Password</label>
                                    </div>
                                    <button type="button" class="input-group-text bg-light bg-opacity-75 border-0 toggle-password" tabindex="-1">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="input-group mb-3 position-relative">
                                        <div class="form-floating flex-grow-1">
                                            <input type="password" class="form-control bg-light bg-opacity-75"
                                                id="newPasswordInput"
                                                name="password"
                                                autocomplete="new-password"
                                                placeholder="New Password"
                                                required>
                                            <label for="newPasswordInput">New Password</label>
                                        </div>
                                        <button type="button" class="input-group-text bg-light bg-opacity-75 border-0 toggle-password" tabindex="-1">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3 position-relative">
                                        <div class="form-floating flex-grow-1">
                                            <input type="password" class="form-control bg-light bg-opacity-75"
                                                id="confirmPasswordInput"
                                                name="password_confirm"
                                                autocomplete="new-password"
                                                placeholder="Confirm Password"
                                                required>
                                            <label for="confirmPasswordInput">New Password (Again)</label>
                                        </div>
                                        <button type="button" class="input-group-text bg-light bg-opacity-75 border-0 toggle-password" tabindex="-1">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid col-12 col-md-8 mx-auto mb-2">
                                <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                            </div>

                            <p class="text-center p-0 m-0"> Back to
                                <a href="<?= base_url("home/index"); ?>">Home</a>
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .form-section {
        backdrop-filter: blur(12px);
        background: rgba(230, 220, 250, 0.85);
    }

    .branding-section {
        backdrop-filter: blur(12px);
        background: rgba(64, 0, 96, 0.75);
        text-align: center;
    }

    .btn-primary {
        background-color: #5f0188;
        border-color: #5f0188;
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #3d005b;
        border-color: #3d005b;
    }

    .form-control {
        border-radius: 8px;
    }

    .custom-card {
        border-radius: 16px;
        overflow: hidden;
        background: transparent !important;
    }

    @media (max-width: 768px) {
        .custom-card {
            flex-direction: column !important;
        }

        .branding-section {
            border-radius: 16px 16px 0 0;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $(".toggle-password").click(function() {
            let input = $(this).siblings(".form-floating").find("input");
            let icon = $(this).find("i");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });

        $("#form_change_password").on("submit", function(e) {
            e.preventDefault();
            let dataForm = new FormData(this);

            Swal.fire({
                title: "Are you sure?",
                text: "Change your password!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, change it!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: () => {
                    return $.ajax({
                        url: "<?= base_url('home/update_password') ?>",
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
                        window.location.href = "<?= url_to('logout') ?>";
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>