<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="fw-bold">🥚 EGG STORE</h2>
                <p class="text-muted"><?= lang('Auth.login') ?> to your account</p>
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

            <?php if (session('message') !== null) : ?>
                <div class="alert alert-success py-2" role="alert"><?= esc(session('message')) ?></div>
            <?php endif ?>

            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                    <label for="floatingEmailInput"><i class="bi bi-envelope me-2"></i><?= lang('Auth.email') ?></label>
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
                    <label for="floatingPasswordInput"><i class="bi bi-lock me-2"></i><?= lang('Auth.password') ?></label>
                </div>

                <!-- Remember me -->
                <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe" <?php if (old('remember')): ?> checked<?php endif ?>>
                        <label class="form-check-label" for="rememberMe">
                            <?= lang('Auth.rememberMe') ?>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg"><?= lang('Auth.login') ?></button>
                </div>

                <div class="text-center small">
                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                        <p class="mb-1 text-muted">
                            <?= lang('Auth.forgotPassword') ?> 
                            <a href="<?= url_to('magic-link') ?>" class="text-decoration-none"><?= lang('Auth.useMagicLink') ?></a>
                        </p>
                    <?php endif ?>

                    <?php if (setting('Auth.allowRegistration')) : ?>
                        <p class="mb-0 text-muted">
                            <?= lang('Auth.needAccount') ?> 
                            <a href="<?= url_to('register') ?>" class="text-decoration-none fw-bold"><?= lang('Auth.register') ?></a>
                        </p>
                    <?php endif ?>
                </div>

            </form>
        </div>
    </div>

<?= $this->endSection() ?>
