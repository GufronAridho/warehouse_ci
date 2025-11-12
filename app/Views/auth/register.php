<?= $this->extend('shared/layout_login') ?>
<?= $this->section('content') ?>
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-image">
    <div class="login-box w-100 px-3" style="max-width: 800px;">
        <div class="card shadow-lg d-flex flex-column flex-md-row custom-card">
            <div class="col-12 col-md-5 branding-section d-flex flex-column justify-content-center align-items-center p-3">
                <img src="<?= base_url('assets/img/logo.png'); ?>"
                    alt="Company Logo"
                    class="mb-3 img-fluid branding-logo">
                <h2 class="fw-bold text-warning text-center">WMiS</h2>
                <p class="text-warning text-center">Create a new account</p>
            </div>
            <div class="col-12 col-md-7 p-3 form-section d-flex flex-column justify-content-center">
                <div class="text-center">
                    <h3 class="fw-bold"><?= lang('Auth.register') ?></h3>
                    <p>Fill in your details to create an account</p>
                </div>

                <?php if (session('error')) : ?>
                    <div class="alert alert-danger"><?= esc(session('error')) ?></div>
                <?php elseif (session('errors')) : ?>
                    <div class="alert alert-danger">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= esc($error) ?><br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= esc(session('errors')) ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <?php if (session('message')) : ?>
                    <div class="alert alert-success"><?= esc(session('message')) ?></div>
                <?php endif ?>
                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control bg-light bg-opacity-75"
                            id="floatingUsernameInput"
                            name="username"
                            placeholder="<?= lang('Auth.username') ?>"
                            value="<?= old('username') ?>" required>
                        <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control bg-light bg-opacity-75"
                            id="floatingEmailInput"
                            name="email"
                            placeholder="<?= lang('Auth.email') ?>"
                            value="<?= old('email') ?>" required>
                        <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="input-group mb-3 position-relative">
                                <div class="form-floating flex-grow-1">
                                    <input type="password" class="form-control bg-light bg-opacity-75"
                                        id="passwordInput"
                                        name="password"
                                        autocomplete="new-password"
                                        placeholder="<?= lang('Auth.password') ?>" required>
                                    <label for="passwordInput"><?= lang('Auth.password') ?></label>
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
                                        id="passwordConfirmInput"
                                        name="password_confirm"
                                        autocomplete="new-password"
                                        placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                                    <label for="passwordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
                                </div>
                                <button type="button" class="input-group-text bg-light bg-opacity-75 border-0 toggle-password" tabindex="-1">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid col-12 col-md-8 mx-auto mb-2">
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                    </div>

                    <p class="text-center"><?= lang('Auth.haveAccount') ?>
                        <a href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a>
                    </p>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
    .custom-card {
        border-radius: 16px;
        overflow: hidden;
        background: transparent !important;
    }

    .branding-logo {
        max-width: 80px;
    }

    .form-select {
        border-radius: 8px;
    }

    @media (max-width: 767.98px) {
        .branding-section {
            padding: 2rem 1rem;
        }

        .branding-logo {
            max-width: 60px;
        }

        .form-section {
            padding: 2rem 1rem;
        }
    }
</style>
<?= $this->endSection() ?>