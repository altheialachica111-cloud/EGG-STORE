<?php
use CodeIgniter\Shield\Entities\User;
?>

<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.email2FATitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="fw-bold">🥚 EGG STORE</h2>
                <p class="text-muted"><?= lang('Auth.email2FATitle') ?></p>
            </div>

            <p class="text-center mb-4"><?= lang('Auth.confirmEmailAddress') ?></p>

            <?php if (session('error')) : ?>
                <div class="alert alert-danger py-2"><?= esc(session('error')) ?></div>
            <?php endif ?>

            <form action="<?= url_to('auth-action-handle') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" name="email" id="floatingEmailInput"
                        inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                        <?php /** @var User $user */ ?>
                        value="<?= old('email', $user->email) ?>" required>
                    <label for="floatingEmailInput"><i class="bi bi-envelope me-2"></i><?= lang('Auth.email') ?></label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg"><?= lang('Auth.send') ?></button>
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
