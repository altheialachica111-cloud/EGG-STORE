<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.email2FATitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="fw-bold">🥚 EGG STORE</h2>
                <p class="text-muted"><?= lang('Auth.emailEnterCode') ?></p>
            </div>

            <p class="text-center mb-4"><?= lang('Auth.emailConfirmCode') ?></p>

            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger py-2"><?= esc(session('error')) ?></div>
            <?php endif ?>

            <form action="<?= url_to('auth-action-verify') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Code -->
                <div class="form-floating mb-4">
                    <input type="number" class="form-control text-center fw-bold fs-4" name="token" id="floatingTokenInput" placeholder="000000"
                        inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" required style="letter-spacing: 0.5rem;">
                    <label for="floatingTokenInput"><?= lang('Auth.token') ?></label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg"><?= lang('Auth.confirm') ?></button>
                </div>

                <div class="text-center small">
                    <p class="mb-0 text-muted">
                        <a href="<?= url_to('login') ?>" class="text-decoration-none"><?= lang('Auth.backToLogin') ?></a>
                    </p>
                </div>

            </form>
        </div>
    </div>

<?= $this->endSection() ?>
