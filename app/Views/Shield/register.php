<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="fw-bold">🥚 EGG STORE</h2>
                <p class="text-muted"><?= lang('Auth.register') ?> for a new account</p>
            </div>

            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger py-2" role="alert"><?= esc(session('error')) ?></div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="alert alert-danger py-2" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= esc($error) ?>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= esc(session('errors')) ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <form action="<?= url_to('register') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                    <label for="floatingEmailInput"><i class="bi bi-envelope me-2"></i><?= lang('Auth.email') ?></label>
                </div>

                <!-- Username -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                    <label for="floatingUsernameInput"><i class="bi bi-person me-2"></i><?= lang('Auth.username') ?></label>
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
                    <label for="floatingPasswordInput"><i class="bi bi-lock me-2"></i><?= lang('Auth.password') ?></label>
                </div>

                <!-- Password (Again) -->
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                    <label for="floatingPasswordConfirmInput"><i class="bi bi-lock-fill me-2"></i><?= lang('Auth.passwordConfirm') ?></label>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg"><?= lang('Auth.register') ?></button>
                </div>

                <div class="text-center small">
                    <p class="mb-0 text-muted">
                        <?= lang('Auth.haveAccount') ?> 
                        <a href="<?= url_to('login') ?>" class="text-decoration-none fw-bold"><?= lang('Auth.login') ?></a>
                    </p>
                </div>

            </form>
        </div>
    </div>

<?= $this->endSection() ?>
