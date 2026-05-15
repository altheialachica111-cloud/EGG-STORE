<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="card shadow-sm text-center">
        <div class="card-body">
            <div class="mb-4">
                <i class="bi bi-envelope-check text-primary" style="font-size: 3rem;"></i>
            </div>
            
            <h2 class="fw-bold mb-3"><?= lang('Auth.checkYourEmail') ?></h2>
            
            <p class="text-muted mb-4">
                <?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?>
            </p>

            <div class="d-grid mt-4">
                <a href="<?= url_to('login') ?>" class="btn btn-outline-primary"><?= lang('Auth.backToLogin') ?></a>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
